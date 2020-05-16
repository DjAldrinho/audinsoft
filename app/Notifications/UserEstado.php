<?php

namespace App\Notifications;

use App\Baneado;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserEstado extends Notification
{
    use Queueable;

    public $baneado;

    public $estado;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Baneado $baneado, $estado)
    {
        $this->baneado = $baneado;
        $this->estado = $estado;
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
        return (new MailMessage)->markdown('mail.user-estado', ['baneado' => $this->baneado, 'estado' => $this->estado])
            ->subject('Su estado para reservar ha sido cambiado!');
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
