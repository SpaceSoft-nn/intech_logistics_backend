<?php

use App\Modules\OrderUnit\Domain\Services\TransportationStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Webklex\IMAP\Facades\Client;

// Route::get('/', function (Req) {

//     // Подключение к почтовому ящику
//     $client = Client::account('default');
//     $client->connect();

//     // Выбор папки "Входящие"
//     $folder = $client->getFolder('INBOX');

//     // Получение непрочитанных писем
//     $messages = $folder->query()->seen()->get();

//     foreach ($messages as $message) {


//         // Парсинг сообщения
//         $subject = $message->getSubject();
//         $body = $message->getTextBody();
//         $from = $message->getFrom();


//         // Ваш код обработки сообщения
//         // Например, проверка содержимого и выполнение действий

//         // Отметить письмо как прочитанное
//         $message->setFlag('Seen');
//     }

//     $client->disconnect();

//     // return view('welcome');
// });

Route::get('/', function (Request $request) {

    $service = app(TransportationStatusService::class);

    $virable = $request->all();

    $service->setTransportationStatus($virable['order_unit_id']);

});

