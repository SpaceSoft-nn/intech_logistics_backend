<?php

namespace App\Modules\Tender\Common\Test\Feature;

use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\Domain\Models\AgreementDocumentTender;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\SpecificalDatePeriod;
use App\Modules\Transport\Domain\Models\Transport;
use App\Modules\User\Domain\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;


class LotTenderTest extends TestCase
{
    public function test_create_tender()
    {
        /** @var User */
        $user = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::customer]
        )
            ->has(PhoneList::factory(), 'phone')->create();

        $file = UploadedFile::fake()->create('agreement.pdf', 100, 'application/pdf');

        // /** @var Address[] */
        // $address = Address::factory()->count(2)->create();

        $postData = [
            'general_count_transport' => 5,
            'price_for_km' => 150.5,
            'body_volume_for_order' => 20.5,

            'type_transport_weight' => 'medium',
            'type_load_truck' => 'ftl',

            'type_tender' => 'single',

            'date_start' => '06.01.2025',
            'organization_id' => $user->organizations->first()->id,

            'period' => 60,
            'day_period' => 6,


            'agreement_document' => $file,

            'specific_date_periods' => [
                [
                    "date" => '05.01.2025',
                    "count_transport" => 5
                ]
            ],
        ];

        // Отправляем POST-запрос на endpoint
        $response = $this->actingAs($user)
            ->withHeaders([
                'organization_id' => $user->organizations->first()->id
            ])
            ->postJson('/api/tenders', $postData);

        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);

        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('lot_tenders', [
            'id' => $response->json()['data']['id_lot_tender'],
        ]);

        // Например, проверяем, что массив содержит конкретные ключи
        $response->assertJsonStructure([
            'data' => [
                'id_lot_tender',
                'number_tender',
                'general_count_transport',
                'price_for_km',
                'body_volume_for_order',
                'type_transport_weight',
                'type_load_truck',
                'status_tender',
                'type_tender',
                'date_start',
                'period',
                'week_period',
                'organization_id',
                'agreement_document_tender_link',
                'array_application_document_tender_link',
                'array_specifical_date_period',
            ],
            'message'
        ]);
    }

    //отклик на тендер
    public function test_response_to_tender()
    {

        /** @var User */
        $userCustomer = User::factory()->hasAttached(
                Organization::factory(),
                ['type_cabinet' => TypeCabinetEnum::customer]
            )
            ->has(PhoneList::factory(), 'phone')->create();


        //создамё запись в бд тендер с ключевыми связями
        $tender = LotTender::factory([
            'organization_id' => $userCustomer->organizations->first()->id,
            ])
            ->has(SpecificalDatePeriod::factory(), 'specifical_date_period')
            ->has(AgreementDocumentTender::factory(), 'agreement_document_tender')
            ->create();


        /** @var User */
        $userCarrier = User::factory()->hasAttached(
            Organization::factory(),
            ['type_cabinet' => TypeCabinetEnum::carrier]
        )->has(PhoneList::factory(), 'phone')->create();

        /** @var Organization */
        $org_carrier = $userCarrier->organizations->first();

        /** @var Transport */
        $transport = Transport::factory()
            ->for($org_carrier)
            ->create();

        $postData = [
            'transport_id' => $transport->id,
            'price_for_km' => '125',
            'comment' => 'Коммент отклика',
        ];

        // Отправляем POST-запрос на endpoint
        $response = $this->actingAs($userCarrier)
            ->withHeaders([
                'organization_id' => $org_carrier->id
            ])
            ->postJson("/api/tenders/$tender->id/contractors/$org_carrier->id", $postData);

        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);

        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('lot_tender_responses', [
            'lot_tender_id' => $tender->id,
            'organization_contractor_id' => $org_carrier->id,
        ]);

        // Например, проверяем, что массив содержит конкретные ключи
        $response->assertJsonStructure([
            'data' => [
                'id_lot_tender_response',
                'lot_tender_id',
                'organization_contractor_id',
                'invoice_lot_tender_id',
            ],
            'message'
        ]);
    }
}
