<?php

namespace App\Modules\Matrix\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MatrixDistanceFileSeed extends Seeder
{
    public function run(): void
    {
        // Путь к CSV файлу
        $csvFile = database_path('data/matrix_distance_v2.csv');

        // Проверим, существует ли файл
        if (!File::exists($csvFile)) {
            $this->command->error("Error: Файл {$csvFile} не найден."); // Выводим ошибку в консоль
            return;
        }

        // Откроем файл и прочитаем данные
        $data = array_map('str_getcsv', file($csvFile));

        // Извлечем заголовки из первой строки массива (файла)
        $headers = array_shift($data);

        $bulkData = [];

        // Вставим данные в базу
        foreach ($data as $row) {

            //Комбинируем head => и значение массивов (создаёт массив один для ключей другой для значений)
            $rowData = array_combine($headers, $row);

            $bulkData[] = [
                'id' => $rowData['id'],
                'city_start_gar_id'=> $rowData['city_start_gar_id'],
                'city_end_gar_id' => $rowData['city_end_gar_id'],
                'city_name_start' => $rowData['city_name_start'],
                'city_name_end' => $rowData['city_name_end'],
                'distance' => $rowData['distance'],
            ];

        }

        $chunkedData = array_chunk($bulkData, 5000);
        foreach ($chunkedData as $chunk) {
            // Вставляем данные в таблицу, region_economic_factors
            DB::table('matrix_distance')->insert($chunk);
        }

    }
}


