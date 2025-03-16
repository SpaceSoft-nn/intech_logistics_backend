<?php

namespace App\Modules\OfferContractor\Domain\Models;

use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transfer\Domain\Models\Transfer;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
        "offer_contractor_id",

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
        return $this->belongsTo(OfferContractorCustomer::class);
    }


    /**
    * Таблица
    * @return BelongsTo
    */
    public function organization_contractor() : BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_contractor_id', 'id');
    }


    /**
    * Таблица
    * @return BelongsTo
    */
    public function order_unit() : BelongsTo
    {
        return $this->belongsTo(OrderUnit::class, 'order_unit_id', 'id');
    }

    /**
    * Связь на таблицу согласование между заказчиком и перевозчиком
    * @return HasOne
    */
    public function agreement_order_contractor_accept() : HasOne
    {
        return $this->hasOne(AgreementOrderContractorAccept::class, 'agreement_order_contractor_id', 'id');
    }

    /**
    *
    * @return HasOne
    */
    public function offer_contractor() : BelongsTo
    {
        return $this->BelongsTo(OfferContractor::class, 'offer_contractor_id');
    }

    public function transfer(): MorphToMany
    {
        return $this->morphToMany(Transfer::class, 'agreementable', 'transfer_agreement_pylymorphs');
    }
}
