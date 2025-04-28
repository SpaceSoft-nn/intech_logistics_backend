<?php

namespace App\Http\Controllers\API\Test;

use Webklex\IMAP\Facades\Client;
use App\Http\Controllers\Controller;
use App\Modules\OrderUnit\Domain\Services\ParseEmailService;

class TestController extends Controller
{
    public function index(
        ParseEmailService $service,
    ) { //нужно подключать апи смс или отправку на почту.

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

                $service->parseEmailAndChangeTransportStatus($email);

            }

        } finally {

            $client->disconnect();

        }
    }
}
