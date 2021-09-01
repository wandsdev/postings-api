<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ValidationCodeUserAccount extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $text;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user, $isResetPassword = false)
    {
        $this->user = $user;
        $this->subject = $this->getSubject($isResetPassword);
        $this->text = $this->getText($isResetPassword);
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
            ->subject($this->subject)
            ->greeting("Olá {$this->user->name},")
            ->line($this->text)
            ->line(new HtmlString("<div align='center' style='margin: auto 60px; background-color: #eee; padding: 30px 15px; font-weight: bold; letter-spacing: 5px; font-size: 1.2rem'>
                                            {$this->user->validation_code}
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

    /**
     * @param false $isResetPassword
     * @return string
     */
    private function getSubject($isResetPassword = false)
    {
        if ($isResetPassword) {
            return 'Redefinir Senha';
        }
        return 'Código de verificação da conta';
    }

    /**
     * @param false $isResetPassword
     * @return string
     */
    private function getText($isResetPassword = false)
    {
        if ($isResetPassword) {
            return 'Geramos o código abaixo para redefinir sua senha. Copie e cole o código no campo indicado do seu aplicativo ou site.';
        }
        return 'Geramos o código abaixo para validar sua conta. Copie e cole o código no campo indicado do seu aplicativo ou site.';
    }
}
