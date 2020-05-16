<?php

namespace App\Notifications;

use App\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservaEstado extends Notification
{
    use Queueable;
    /**
     * @var
     */
    public $estado;
    /**
     * @var Reserva
     */
    public $reserva;
    /**
     * @var null
     */
    private $motivo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($estado, Reserva $reserva, $motivo = null)
    {
        $this->estado = $estado;
        $this->reserva = $reserva;
        $this->motivo = $motivo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.reserva-estado', ['reserva' => $this->reserva, 'estado' => $this->estado, 'motivo' => $this->motivo])->subject("Informe de reserva #" . $this->reserva->codigo_reserva);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
