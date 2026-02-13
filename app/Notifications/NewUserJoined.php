<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserJoined extends Notification
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('User Baru Bergabung di RenCMS')
            ->greeting('Halo Admin!')
            ->line("User baru telah bergabung:")
            ->line("Nama: {$this->user->name}")
            ->line("Email: {$this->user->email}")
            ->line("Username: {$this->user->username}")
            ->action('Lihat User', url('/super_admin/users'))
            ->salutation('Salam, RenCMS');
    }
}
