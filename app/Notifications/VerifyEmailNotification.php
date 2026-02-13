<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verifikasi Email RenCMS')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Terima kasih telah mendaftar. Klik tombol di bawah untuk memverifikasi email kamu.')
            ->action('Verifikasi Email', $this->verificationUrl($notifiable))
            ->line('Jika kamu tidak membuat akun ini, abaikan email ini.')
            ->salutation('Salam, RenCMS');
    }
}
