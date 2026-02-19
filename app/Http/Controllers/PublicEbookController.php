<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function download($slug)
    {
        $ebook = Ebook::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // jika tipe login dan belum login
        if ($ebook->access_type === 'login' && !Auth::check()) {
            return redirect()->route('login')
                ->with('warning', 'Silakan login untuk mengunduh e-book ini.');
        }

        $ebook->incrementDownload();

        return response()->download(
            storage_path('app/public/'.$ebook->file_path)
        );
    }
}
