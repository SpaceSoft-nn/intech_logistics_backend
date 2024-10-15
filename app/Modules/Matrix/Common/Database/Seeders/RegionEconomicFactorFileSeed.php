<?php

namespace App\Modules\Matrix\Common\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RegionEconomicFactorFileSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Путь к CSV файлу
        $csvFile = database_path('data/region_economic_factors.csv');

        // Проверим, существует ли файл
        if (!File::exists($csvFile)) {
            $this->command->error("Error: Файл {$csvFile} не найден."); // Выводим ошибку в консоль
            return;
        }

        // Откроем файл и прочитаем данные
        $data = array_map('str_getcsv', file($csvFile));

        // Извлечем заголовки из первой строки массива (файла)
        $headers = array_shift($data);

        // Вставим данные в базу
        foreach ($data as $row) {
            //Комбинируем head => и значение массивов (создаёт массив один для ключей другой для значений)
            $rowData = array_combine($headers, $row);

            // Вставляем данные в таблицу, region_economic_factors
            DB::table('region_economic_factors')->insert([
                'id' => $rowData['id'],
                'region_start_gar_id' => $rowData['region_start_gar_id'],
                'region_end_gar_id' => $rowData['region_end_gar_id'],
                'region_name_start' => $rowData['region_name_start'],
                'region_name_end' => $rowData['region_name_end'],
                'factor' => $rowData['factor'],
                'price' => $rowData['price'],
            ]);
        }
    }
}
