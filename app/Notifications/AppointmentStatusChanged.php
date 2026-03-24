<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentStatusChanged extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        $labels = [
            'pending'     => 'pendiente',
            'confirmed'   => 'confirmada',
            'in_progress' => 'en curso',
            'completed'   => 'completada',
            'cancelled'   => 'cancelada',
        ];

        $label = $labels[$this->appointment->status] ?? $this->appointment->status;

        return [
            'type'           => 'appointment_status_changed',
            'title'          => 'Estado de cita actualizado',
            'message'        => "La cita de {$this->appointment->pet?->name} ahora está {$label}.",
            'appointment_id' => $this->appointment->id,
            'pet_name'       => $this->appointment->pet?->name,
            'status'         => $this->appointment->status,
            'status_label'   => $label,
        ];
    }
}
