<?php

namespace App\Modules\OfferContractor\Domain\Models;

use App\Modules\Organization\Domain\Models\Organization;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OfferContractorCustomer extends Model
{ //Таблица когда заказчики откликнулись на предложение перевозчика
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    protected $table = 'offer_contractor_invoice_order_customers';

    protected $fillable = [

        "invoice_order_customer_id",
        "offer_contractor_id",
        "organization_id",
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
    * Связь к таблице на предложения перевозчика
    * @return HasMany
    */
    public function offer_contractor() : BelongsTo
    {
        return $this->belongsTo(OfferContractor::class, 'offer_contractor_id', 'id');
    }

    /**
    * Связь к таблице организации
    * @return HasMany
    */
    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    /**
    * Связь к таблице Когда перевозчик выбрал исполнителя "заказчика", то есть возьмёт в работу заказ
    * @return HasMany
    */
    public function invoice_order_customer() : BelongsTo
    {
        return $this->belongsTo(InvoiceOrderCustomer::class, 'invoice_order_customer_id', 'id');
    }

    /**
    * Таблица - когда отклик выбрал
    * @return HasOne
    */
    public function agreement_order_contractors() : HasOne
    {
        return $this->hasOne(AgreementOrderContractor::class, 'agreement_order_contractors');
    }
}
