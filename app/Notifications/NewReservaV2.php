<?php

namespace App\Notifications;

use App\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReservaV2 extends Notification
{
    use Queueable;
    /**
     * @var Reserva
     */
    public $reserva;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reserva $reserva)
    {

        $this->reserva = $reserva;
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
        return (new MailMessage)
            ->markdown('mail.new.reserva', ['reserva' => $this->reserva])
            ->subject('Nueva reserva creada');
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
