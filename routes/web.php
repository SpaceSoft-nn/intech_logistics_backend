<?php

use App\Modules\OrderUnit\Domain\Services\TransportationStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Webklex\IMAP\Facades\Client;

Route::get('/', function (Request $request) {

    try {

        $service = app(TransportationStatusService::class);

        /** @var \Webklex\PHPIMAP\Client $client */
        $client = Client::account('default');

        /** @var \Webklex\PHPIMAP\Client $client */
        $client->connect();

        // Выбор папки "Входящие"
        $folder = $client->getFolder('INBOX');

        dd($folder);

        // Получение непрочитанных писем
        $messages = $folder->query()->unseen()->get();

        foreach ($messages as $message) {

            /** @var Webklex\PHPIMAP\Address $from */
            $from = $message->getFrom()->first();

            $email = $from->mail;

            dd($email);

            $service->parseEmailAndChangeTransportStatus($email);

            dd('Окончание');


            // $message->setFlag('Seen');
        }


    } finally {

        $client->disconnect();

    }


    // return view('welcome');
});


