<?php
namespace App\Modules\Avizo\Domain\Async\jobs;

use Illuminate\Bus\Queueable;
use App\Modules\Avizo\Domain\Models\AvizoEmail;
use App\Modules\Avizo\Domain\Async\Mails\SendAvizoEmailNotification;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendAvizoEmailJob //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected AvizoEmail $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function handle()
    {
        //создаём нотификацию отправки
        $notification = new SendAvizoEmailNotification($this->model);

        //запускаем процесс отправки нотификации.
        Notification::route('mail', $this->model->confirming)->notify($notification);
    }
}

