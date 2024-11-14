<?php

namespace App\Modules\Address\Domain\Resources;

use App\Modules\Address\Domain\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressCollection extends ResourceCollection
{

    public $collects = AddressResource::class;

    protected $idOrderUnit;

    public function __construct($resource, $idOrderUnit = null)
    {
        //получаем idOrderUnit - для проверки и получение таблицы pivot при связях многие ко многим
        $this->idOrderUnit = $idOrderUnit;
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        if(is_null($this->idOrderUnit)) { return $this->collection->toArray(); }

        return $this->toMapColletcion();
    }

    public function toMapColletcion() : array
    {
        return $this->collection->map(function ($item) {

        /**
         * @var OrderUnit $orderUnit
         */
        $orderUnit = $item->order_units->find($this->idOrderUnit);

        // Убедимся, что orderUnit существует
        if ($orderUnit && $orderUnit->pivot) {
            return [
                'address' => new AddressResource($item), // Используйте AddressResource для нормализованного представления
                'date' => $orderUnit->pivot->data_time,
                'type' => $orderUnit->pivot->type,
                'priority' => $orderUnit->pivot->priority,
            ];
        } else {
            // Обработка случая, когда orderUnit не найден
            return [
                'address' => new AddressResource($item),
            ];
        }

        })->toArray();
    }
}
