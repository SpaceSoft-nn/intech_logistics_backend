<?php

namespace App\Modules\OfferContractor\Domain\Models;

use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
            "start_date" => \App\Modules\Base\Casts\RuDateTimeCast::class,
            "end_date" => \App\Modules\Base\Casts\RuDateTimeCast::class,
            "type_transport_weight" => TransportTypeWeight::class,
            "type_load_truck" => TransportLoadingType::class,
        ];
    }

    /**
    * Связь к таблице информации от Организации: заказчика
    * @return HasOne
    */
    public function offer_contractor_customer() : HasOne
    {
        #TODO Может быть случай когда эта таблица может использоваться как черновик и HasOne не подойдёт
        return $this->hasOne(InvoiceOrderCustomer::class, 'offer_contractors');
    }
}
