<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice;

use Arr;
use Illuminate\Contracts\Support\Arrayable;

class InvoiceOrderVO implements Arrayable
{
    public function __construct(
        public readonly string $price,
        public readonly string $date,
        public readonly string $comment,
    ){}

    public static function make(

        string $price,
        string $date,
        string $comment,

    ) : self {

        return new self(

            price: $price,
            date: $date,
            comment: $comment,

        );

    }

    public function toArray() : array
    {
        return [
            'price' => $this->price,
            'date' => $this->date,
            'comment' => $this->comment,
        ];
    }

    public static function fromArrayToObject(array $array): self
    {
        $price = Arr::get($array, "price");
        $date = Arr::get($array, "date");
        $comment = Arr::get($array, "comment");


        return new self(
            price: $price,
            date: $date,
            comment: $comment,
        );
    }

}
