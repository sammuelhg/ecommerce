<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordSetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Senha Cadastrada com Sucesso - LosFit')
                    ->greeting('Olá ' . $notifiable->name . '!')
                    ->line('Sua senha de acesso foi cadastrada com sucesso.')
                    ->line('Agora você pode fazer login utilizando seu e-mail e a senha que acabou de criar, além do login social.')
                    ->action('Acessar Minha Conta', route('login'))
                    ->line('Se você não realizou esta alteração, entre em contato conosco imediatamente.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
