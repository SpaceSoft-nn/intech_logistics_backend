<?php

namespace App\Modules\Tender\Domain\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Tender\App\Data\ValueObject\AgreementDocumentTenderVO;
use App\Modules\Tender\Domain\Models\AgreementDocumentTender;
use App\Modules\Tender\Domain\Models\LotTender;
use Illuminate\Support\Facades\Storage;

class AgreementDocumentTenderFactory extends Factory
{
    protected $model = AgreementDocumentTender::class;

    public function definition(): array
    {

        // Генерируем временное текстовое содержимое
        $tempText = $this->faker->paragraphs(3, true);

        // Определяем путь для сохранения временного файла на кастомном диске
        $fileName = 'document_agreement_' . uniqid() . '.txt';
        $filePath = 'agreements/' . $fileName;

        // Сохраняем текстовый файл на кастомном диске
        Storage::disk('tender_documents')->put($filePath, $tempText);

        $document = AgreementDocumentTenderVO::make(
            lot_tender_id: LotTender::factory()->create()->id,
            path: $filePath,
            description: 'Test Description',
        );

        $document = $document->toArrayNotNull();

        return $document;
    }


}
