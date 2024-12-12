<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class InvoiceOrderVO implements Arrayable
{

    use FilterArrayTrait;

    //$price и $date сделаны возможно null, т.к это зависит от статуса в заказе (можно ли указывать изменение цены или времени)
    public function __construct(
        public readonly string $transport_id,
        public readonly ?string $price,
        public readonly ?string $date,
        public readonly ?string $comment,
    ){}

    public static function make(

        string $transport_id,
        ?string $price,
        ?string $date ,
        ?string $comment = null,

    ) : self {

        return new self(

            transport_id: $transport_id,
            price: $price,
            date: Carbon::parse($date)->format('Y-m-d'),
            comment: $comment,

        );

    }

    public function toArray() : array
    {
        return [
            'transport_id' => $this->transport_id,
            'price' => $this->price,
            'date' => $this->date,
            'comment' => $this->comment,
        ];
    }

    public static function fromArrayToObject(array $array): self
    {
        $transport_id = Arr::get($array, "transport_id");
        $price = Arr::get($array, "price" , null);
        $date = Arr::get($array, "date" , null);
        $comment = Arr::get($array, "comment", null);


        return self::make(
            transport_id: $transport_id,
            price: $price,
            date: $date,
            comment: $comment,
        );
    }

}
