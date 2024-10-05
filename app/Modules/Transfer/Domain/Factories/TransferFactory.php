<?php

namespace App\Modules\Transfer\Domain\Factories;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\Transfer\Domain\Actions\DTO\ValueObject\TransferVO;
use App\Modules\Transfer\Domain\Models\Transfer;
use App\Modules\Transport\Domain\Models\Transport;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferFactory extends Factory
{
    protected $model = Transfer::class;

    public function definition(): array
    {

        {
            /**
            * @var Transport $transport
            */
            $transport = Transport::factory()->create();

            /**
            * @var Adress[] $adress
            */
            $adress = Adress::factory()->count(2)->create();
        }

        $deliveryStart = $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'); // Генерируем дату начала в пределах последнего месяца
        $daysToAdd = rand(2, 9); // Случайное количество дней от 2 до 5
        /**
        * @var TransferVO
        */
        $transferVO = TransferVO::make(

            transport_id: $transport->id,
            delivery_start: $deliveryStart,
            delivery_end: (new DateTime($deliveryStart))->modify("+{$daysToAdd} days")->format('Y-m-d H:i:s'),
            adress_start_id: $adress[0]->id,
            adress_end_id: $adress[1]->id,
            order_total: $this->faker->numberBetween(60000, 320000),
            description: $this->faker->text(),
            body_volume: $this->faker->randomFloat(2, 5, 35),

        );


        return $transferVO->toArrayNotNull();
    }

}
