<?php

namespace App\Modules\OfferContractor\Domain\Models;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceOrderCustomer extends Model
{ //Таблица когда заказчики откликнулись на предложение перевозчика (пред создание заказа)
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'invoice_order_customers';

    protected $fillable = [

        "order_total",

        "cargo_good",
        "organization_creator_id",

        "description",
        "body_volume",
        "type_product",
        "type_transport_weight",
        "type_load_truck",
        "start_address_id",
        "end_address_id",
        "start_date",
        "end_date",

    ];

    protected $guarded = [

        'id',
        'created_at',
        'updated_at',

    ];

    protected $hidden = [

    ];

    protected function casts(): array
    {
        return [
            "cargo_good" => 'array',
            "start_date" => \App\Modules\Base\Casts\RuDateTimeCast::class,
            "end_date" => \App\Modules\Base\Casts\RuDateTimeCast::class,
            "type_transport_weight" => TransportTypeWeight::class,
            // "type_load_truck" => TypeLoadingTruckMethod::class,
            "type_load_truck" => TypeLoadingTruckMethod::class,
        ];
    }

    /**
     * Связь к таблице информации от Организации: заказчика
     * @return HasOne
    */
    public function offerContractorCustomer() : HasOne
    {
        #TODO Может быть случай когда эта таблица может использоваться как черновик и HasOne не подойдёт
        return $this->hasOne(OfferContractorCustomer::class, 'invoice_order_customer_id', 'id');
    }

    /**
     * Связь к таблице информации от Организации: заказчика
     * @return BelongsTo
    */
    public function start_address() : BelongsTo
    {
        #TODO Может быть случай когда эта таблица может использоваться как черновик и HasOne не подойдёт
        return $this->belongsTo(Address::class, 'start_address_id', 'id');
    }


    /**
     * Связь к таблице информации от Организации: заказчика
     * @return BelongsTo
    */
    public function end_address() : BelongsTo
    {
        #TODO Может быть случай когда эта таблица может использоваться как черновик и HasOne не подойдёт
        return $this->belongsTo(Address::class, 'end_address_id', 'id');
    }
}
