<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PublicEbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::published()
            ->latest()
            ->paginate(9);

        return view('public.ebooks.index', compact('ebooks'));
    }

    public function show($slug)
    {
        $ebook = Ebook::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.ebooks.show', compact('ebook'));
    }

    public function download(Request $request, $slug)
    {
        $ebook = Ebook::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // =========================
        // VALIDASI RECAPTCHA
        // =========================
        $request->validate([
            'g-recaptcha-response' => 'required'
        ]);

        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret'   => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (! $response->json('success')) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Captcha tidak valid.'
            ]);
        }

        // =========================
        // LOGIC ACCESS
        // =========================

        // Paid → redirect WA
        if ($ebook->access_type === 'paid') {

            if (!$ebook->whatsapp_number) {
                return back()->with('error', 'E-book ini belum memiliki nomor WhatsApp.');
            }

            $message = urlencode("Halo, saya ingin membeli ebook: {$ebook->title}");
            return redirect("https://wa.me/{$ebook->whatsapp_number}?text={$message}");
        }

        // Login required
        if ($ebook->access_type === 'login' && !Auth::check()) {
            return redirect()->route('login')
                ->with('warning', 'Silakan login untuk mengunduh e-book ini.');
        }

        // FREE or LOGIN PASSED
        $ebook->incrementDownload();

        return response()->download(
            storage_path('app/public/' . $ebook->file_path)
        );
    }
}
