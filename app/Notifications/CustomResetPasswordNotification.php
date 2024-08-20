<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
    public function toMail($notifiable)
    {
        $resetUrl = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Redefinição de Password')
            ->line('Você está a receber este e-mail porque recebemos uma solicitação de redefinição de password para a sua conta.')
            ->action('Redefinir Senha', $resetUrl)
            ->line('Este link de redefinição de senha expira em 60 minutos.')
            ->line('Se você não solicitou uma redefinição de password, nenhuma ação adicional é necessária.');
    }

    /**
     * Generate the URL for the password reset link.
     *
     * @param $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        $frontendUrl = config('app.frontend_url');
        $token = urlencode($this->token);
        $email = urlencode($notifiable->getEmailForPasswordReset());

        return "{$frontendUrl}/reset-password/{$token}?email={$email}";
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

