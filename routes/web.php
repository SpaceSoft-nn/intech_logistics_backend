<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
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
    $lastColumn = $sheet->getHighestColumn(); // Последняя заполненная колонка (например, "D")


    $highestColumn = $sheet->getHighestColumn(); //возвращает букву (или буквенное обозначение) последнего столбца с данными
    $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); //преобразовываем колонку в цифровое значение

    $array = [];
    for ($i = 2; $i < $lastRow; $i++) //строка
    {

        $stringValueRow = $sheet->getCell([$i, 1])->getValue();


        for ($j = 2; $j < $lastColumn; $j++) // столбец
        {

            $stringValueColumn = $sheet->getCell([1, $j])->getValue();

            if($i == $j) { continue; }

            $array[] = [
                "city_name_start" => $stringValueRow,
                "city_name_end" => $stringValueColumn,
                "distance" => $sheet->getCell([$i, $j])->getValue(),
                "city_start_gar_id" => null,
                "city_end_gar_id" => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];



        }

    }

    dd($lastRow, $lastColumn    );


    // $valueColumn = $sheet->getCell([1, 2])->getValue(); //значение столбца (название города)
    // $valueRow = $sheet->getCell([2, 1])->getValue(); //значение строки (название города)




    $highestColumnIndex = Coordinate::columnIndexFromString($LastColumn); // Преобразуем букву в число






    return 'ИВАН ПРИВЕТ';

});


Route::prefix('/avizos')->group(function () {

    Route::prefix('/emails')->group(function () {

        Route::any('/{uuid}/confirm', [AvizoEmailController::class, 'confirm'])->name('avizos.emails.confirm')->whereUuid('uuid');

    });


});

