<?php

namespace App\Modules\Avizo\Domain\Async\Mails;

use App\Modules\Avizo\Domain\Models\AvizoEmail;
use App\Modules\User\Domain\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Отправка почты для подтврждения авизации по email
 */
class SendAvizoEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private AvizoEmail $avizoEmail,
    ) { }

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        $url = route("avizos.emails.confirm", ['uuid' => $this->avizoEmail->url]);

        return (new MailMessage)
            ->subject('Подтверждения Авизации')
            ->greeting('Здравствуйте!')
            ->line('Для подтверждения авизации, перейдите по ссылке снизу:')
            ->action('Подтвердить авизацию', $url);
    }


}
