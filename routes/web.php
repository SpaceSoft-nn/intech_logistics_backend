<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Controllers\API\Avizo\AvizoEmailController;
use App\Modules\Matrix\Domain\Models\MatrixDistance;

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

    $token = "509217298d01a514519d602904fb30f8660c2dfb";
    $secret = "098d522baa0250a084bf4e644e05830b7f3e0d24";
    $dadata = new \Dadata\DadataClient($token, $secret);

    // $result = $dadata->clean("address", "Москва");
    // dd($result['region_fias_id']);

    MatrixDistance::orderBy('id')
    ->chunk(1000, function ($addresses) use ($dadata) {

        foreach ($addresses as $address) {

            if(!empty($address->city_end_gar_id) && !empty($address->city_start_gar_id))
            {
                continue;
            }

            // $city_name_start = $address->city_name_start;
            // $city_name_end = $address->city_name_end;


            // $result_name_start = $dadata->clean("address", $city_name_start);
            // $result_name_end = $dadata->clean("address", $city_name_end);

            // $address->city_start_gar_id = $result_name_start['region_fias_id'];
            // $address->city_end_gar_id = $result_name_end['region_fias_id'];

            // $address->save();
        }

        sleep(1);

    });

    return 'ИВАН ПРИВЕТ';

});


Route::prefix('/avizos')->group(function () {

    Route::prefix('/emails')->group(function () {

        Route::any('/{uuid}/confirm', [AvizoEmailController::class, 'confirm'])->name('avizos.emails.confirm')->whereUuid('uuid');

    });


});

