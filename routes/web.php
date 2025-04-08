<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Modules\Matrix\Domain\Models\MatrixDistance;
use App\Http\Controllers\API\Avizo\AvizoEmailController;

Route::get('/', function (Request $request) {

    $inputFileName = '../database/data/table.russia.xls';

    try {
        // Определяем тип файла и создаём reader
        $reader = IOFactory::createReaderForFile($inputFileName);

        // Загружаем таблицу в объект Spreadsheet
        $spreadsheet = $reader->load($inputFileName);
    } catch(Exception $e) {
        die('Ошибка загрузки файла: '. $e->getMessage());
    }

    // Получаем активный лист (можно получить и другой, если нужно)
    $sheet = $spreadsheet->getActiveSheet();

    // Получаем количество строк и столбцов
    $lastRow = $sheet->getHighestRow(); // Последний заполненный ряд
    $highestColumn = $sheet->getHighestColumn(); //возвращает букву (или буквенное обозначение) последнего столбца с данными
    $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); //преобразовываем колонку в цифровое значение

    $array = [];
    for ($i = 2; $i <= $lastRow; $i++) //строка
    {

        $stringValueRow = $sheet->getCell([$i, 1])->getValue();

        for ($j = 2; $j <= $lastColumn; $j++) // столбец
        {

            $stringValueColumn = $sheet->getCell([1, $j])->getValue();

            if(empty($stringValueColumn)) { continue; }


            if($i == $j) { continue; }

            $distance = $sheet->getCell([$i, $j])->getValue();

            // Проверим, является ли строка числом
            if (is_numeric($distance)) {
                $distance = $distance; // Преобразование и возврат числа
            } else {
                // Если ошибка — логируем
                throw new Exception("Ошибка преобразования строки '{$distance}' в int в seed при матрицы расстояний");
            }

            $array[] = [
                "id" => Str::orderedUuid(),
                "city_name_start" => $stringValueRow,
                "city_name_end" => $stringValueColumn,
                "distance" => $distance,
                "city_start_gar_id" => null,
                "city_end_gar_id" => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }

    }


    $collectArray = collect($array);
    $arrayCollectChunks =  $collectArray->chunk(2000);


    DB::transaction(function () use ($arrayCollectChunks) {

        foreach ($arrayCollectChunks as $chuck) {

            DB::table('matrix_distance')->insert($chuck->toArray());

        }

    });


    dd('done');

    return 'ИВАН ПРИВЕТ';

});

Route::get('/set-gar', function (Request $request) {


    MatrixDistance::orderBy('id')
    ->chunk(195, function ($addresses)  {

        try {


            foreach ($addresses as $address) {

                $model_start = MatrixDistance::where('city_name_start', $address->city_name_start)->whereNotNull('city_start_gar_id')->first();
                $model_end = MatrixDistance::where('city_name_end', $address->city_name_end)->whereNotNull('city_end_gar_id')->first();


                if(!empty($address->city_end_gar_id) && !empty($address->city_start_gar_id))
                {
                    continue;
                }

                $city_name_start = $address->city_name_start;
                $city_name_end = $address->city_name_end;

                $city_name_end = "Город " . $city_name_end;
                $city_name_start = "Город " . $city_name_start;

                if(!empty($model_start)) {

                    if(!empty($model_end))
                    {

                        $address->city_start_gar_id = $model_start->city_start_gar_id;
                        $address->city_end_gar_id = $model_end->city_end_gar_id;


                    } else {

                        $response = Http::get('https://data.pbprog.ru/api/address/full-address/parse?token=71e0e0018c2f49b09258a0fac9e3055dcb03befd&addressText=' . $city_name_end);

                        if ($response->successful()) {

                            $result_name_end = $response->json()[0];

                        } else {

                            dd('Ошибка запроса', $response->status());

                        }

                        $address->city_start_gar_id = $model_start->city_start_gar_id;
                        $address->city_end_gar_id = $result_name_end['objectGuid'];

                    }


                } else {

                    $response_name_start = Http::get('https://data.pbprog.ru/api/address/full-address/parse?token=71e0e0018c2f49b09258a0fac9e3055dcb03befd&addressText=' . $city_name_start);
                    $response_name_end = Http::get('https://data.pbprog.ru/api/address/full-address/parse?token=71e0e0018c2f49b09258a0fac9e3055dcb03befd&addressText=' . $city_name_end);

                    if ($response_name_start->successful() || $response_name_end->successful())
                    {

                        $result_name_start = $response_name_start->json()[0];
                        $result_name_end = $response_name_end->json()[0];

                    } else {

                        dd('Ошибка запроса', $response_name_start->status(), $response_name_end->status());

                    }

                    $address->city_start_gar_id = $result_name_start['objectGuid'];
                    $address->city_end_gar_id = $result_name_end['objectGuid'];

                }


                $address->save();

                // usleep(5000);
            }

            // usleep(20000);

        } catch (\Throwable $th) {
            dd($th, $address);
        }


    });

    return 'ИВАН ПРИВЕТ';

});


Route::prefix('/avizos')->group(function () {

    Route::prefix('/emails')->group(function () {

        Route::any('/{uuid}/confirm', [AvizoEmailController::class, 'confirm'])->name('avizos.emails.confirm')->whereUuid('uuid');

    });


});

