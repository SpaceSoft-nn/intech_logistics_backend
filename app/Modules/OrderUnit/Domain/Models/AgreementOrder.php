<?php

namespace App\Modules\OrderUnit\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Transfer\Domain\Models\Transfer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Modules\Organization\Domain\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Modules\OrderUnit\Domain\Factories\AgreementOrderFactory;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;

class AgreementOrder extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'agreement_orders';

    protected static function newFactory()
    {
        return AgreementOrderFactory::new();
    }

    protected $fillable = [

        'order_unit_id',
        'organization_contractor_id',
        'organization_order_units_invoce_id',

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

    // Связь один к одному с AgreementAccept
    public function agreementOrderAccept() : HasOne
    {
        return $this->hasOne(AgreementOrderAccept::class);
    }

    public function transfers(): BelongsToMany
    {
        return $this->belongsToMany(Transfer::class, 'agreement_transfer', 'transfer_id' , 'agreement_id');
    }

    /**
     * Связь таблитцы organization_order_units_invoce
     * @return BelongsTo
     */
    public function orgOrderInvoices() : BelongsTo
    {
        return $this->belongsTo(OrganizationOrderUnitInvoice::class, 'organization_order_units_invoce_id');
    }


    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_contractor_id', 'id');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(OrderUnit::class, 'order_unit_id');
    }

    public function transfer(): MorphToMany
    {
        return $this->morphToMany(Transfer::class, 'agreementable', 'transfer_agreement_pylymorphs');
    }


    /**
     * Прямая связь к таблице invoiceOrder через промежуточную табилцу orgOrderInvoices с помощью акксесора
     * @return Attribute
     */
    protected function invoiceOrder(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->orgOrderInvoices?->invoice_order ? $this->orgOrderInvoices->invoice_order : 1,
        );

        // Логика для вычисления offer_invoice
        // return $this->orgOrderInvoices->invoice_order ? $this->orgOrderInvoices->invoice_order : null;
    }

}
