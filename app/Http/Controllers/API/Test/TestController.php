<?php

namespace App\Http\Controllers\API\Test;

use App\Http\Controllers\Controller;
use App\Modules\OrderUnit\Domain\Services\ParseEmailService;
use Webklex\IMAP\Facades\Client;

class TestController extends Controller
{
    public function index(
        ParseEmailService $service,
    ) {

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
