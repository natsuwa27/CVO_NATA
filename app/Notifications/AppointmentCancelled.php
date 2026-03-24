<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentCancelled extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        $slot = $this->appointment->timeSlot;
        $day  = $slot?->workingDay;

        return [
            'type'           => 'appointment_cancelled',
            'title'          => 'Cita cancelada',
            'message'        => "La cita de {$this->appointment->pet?->name} del {$day?->date} ha sido cancelada.",
            'appointment_id' => $this->appointment->id,
            'pet_name'       => $this->appointment->pet?->name,
            'service'        => $this->appointment->service?->name,
            'date'           => $day?->date,
        ];
    }
}
