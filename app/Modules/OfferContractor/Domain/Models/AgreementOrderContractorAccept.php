<?php

namespace App\Modules\OfferContractor\Domain\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementOrderContractorAccept extends Model
{ //Таблица Когда перевозчик выбрал исполнителя "заказчика", то есть возьмёт в работу заказ

    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'agreement_order_contractor_accept';

    protected $fillable = [

        "agreement_order_contractor_id",
        "order_bool",
        "contractor_bool",

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
    * Связь с таблицей где перевозчик выбрал заказчика
    * @return BelongsTo
    */
    public function agreement_order_contractor() : BelongsTo
    {
        return $this->belongsTo(AgreementOrderContractor::class, 'agreement_order_contractor_id');
    }


    /**
     * Прямая связь к таблице orderUnit через промежуточную табилцу agreement_order_contractor с помощью акксесора
     * @return Attribute
     */
    protected function order(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->agreement_order_contractor?->order_unit ? $this->agreement_order_contractor->order_unit : null,
        );

        // Логика для вычисления offer_invoice
        // return $this->orgOrderInvoices->invoice_order ? $this->orgOrderInvoices->invoice_order : null;
    }
}

