<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class VerificationCodeUserAccount extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('suporte@postings.com')
            ->subject('Código de verificação da conta')
            ->greeting("Olá {$this->user->name},")
            ->line('Geramos o código abaixo para validar sua conta. Copie e cole o código no campo indicado do seu aplicativo ou site.')
            ->line(new HtmlString("<div align='center' style='margin: auto 60px; background-color: #eee; padding: 30px 15px; font-weight: bold; letter-spacing: 5px; font-size: 1.2rem'>
                                            {$this->user->verification_code}
                                        </div>"))
            ->line(new HtmlString("<br><br><br>Obrigado por usar nossa aplicação"))
            ->salutation('Atenciosamente,');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
