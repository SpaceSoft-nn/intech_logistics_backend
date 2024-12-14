<?php

namespace App\Modules\OfferContractor\Domain\Models;

use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AgreementOrderContractor extends Model
{ //Таблица Когда перевозчик выбрал исполнителя "заказчика", то есть возьмёт в работу заказ

    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'agreement_order_contractors';

    protected $fillable = [

        "offer_contractor_invoice_order_customer_id",
        "order_unit_id",
        "organization_contractor_id",
        "user_id",

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

        ];
    }

    /**
    * Таблица
    * @return BelongsTo
    */
    public function offer_contractor_invoice_order_customer() : BelongsTo
    {
        return $this->belongsTo(InvoiceOrderCustomer::class, 'offer_contractors');
    }

    /**
    * Таблица
    * @return BelongsTo
    */
    public function order_unit() : BelongsTo
    {
        return $this->belongsTo(OrderUnit::class, 'order_units');
    }п

    /**
    * Связь на таблицу согласование между заказчиком и перевозчиком
    * @return HasOne
    */
    public function agreement_order_contractor_accept() : HasOne
    {
        return $this->hasOne(OrderUnit::class, 'agreement_order_contractors');
    }
}
