<?php

namespace App\Console\Commands;

use App\Modules\OrderUnit\Domain\Services\ParseEmailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Webklex\IMAP\Facades\Client;


class EmailParseTransportationStatus extends Command
{
    public function __construct(
        private ParseEmailService $service,
    ) {
        parent::__construct();
    }

    protected $signature = 'email:parse-status';

    protected $description = 'Парсинг почты и изменения статуса транспортировки.';


    public function handle()
    {
        $this->parseEmail();
    }

    public function parseEmail()
    {
        Log::info('Запущена команда из кроны');
        
        /** @var \Webklex\PHPIMAP\Client $client */
        $client = Client::account('default');

        /** @var \Webklex\PHPIMAP\Client $client */
        $client->connect();

        try {

            // Выбор папки "Входящие"
            $folder = $client->getFolder('INBOX');

            // Получение непрочитанных писем
            $messages = $folder->query()->unseen()->get();

            foreach ($messages as $message) {

                /** @var Webklex\PHPIMAP\Address $from */
                $from = $message->getFrom()->first();

                $email = $from->mail;

                $status = $this->service->parseEmailAndChangeTransportStatus($email);

                if($status) { $message->setFlag('SEEN'); }

            }

        } finally {
            $client->disconnect();
        }
    }


}
