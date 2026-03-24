<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentCreated extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array { return ['database']; }

    public function toDatabase(object $notifiable): array
    {
        $slot = $this->appointment->timeSlot;
        $day  = $slot?->workingDay;

        return [
            'type'           => 'appointment_created',
            'title'          => 'Cita registrada',
            'message'        => "Cita para {$this->appointment->pet?->name} el {$day?->date} de {$slot?->start_time} a {$slot?->end_time}.",
            'appointment_id' => $this->appointment->id,
            'pet_name'       => $this->appointment->pet?->name,
            'service'        => $this->appointment->service?->name,
            'date'           => $day?->date,
            'start_time'     => $slot?->start_time,
            'status'         => $this->appointment->status,
        ];
    }
}
