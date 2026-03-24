<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserRegistered extends Notification
{
    use Queueable;

    public function __construct(public User $user) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'    => 'user_registered',
            'title'   => 'Bienvenido a CVO',
            'message' => "Hola {$this->user->name}, tu cuenta ha sido creada exitosamente.",
            'user_id' => $this->user->id,
        ];
    }
}
