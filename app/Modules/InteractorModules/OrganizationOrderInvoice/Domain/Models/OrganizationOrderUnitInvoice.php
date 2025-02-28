<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Factories\OrganizationOrderInvoiceFactory;

class OrganizationOrderUnitInvoice extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'organization_order_unit_invoces';

    protected static function newFactory()
    {
        return OrganizationOrderInvoiceFactory::new();
    }

    protected $fillable = [

        "order_unit_id",

        "organization_id",
        // "user_id", #TODO Надо организовывать таблицу связи org + user

        "invoice_order_id",

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

    public function order_unit(): BelongsTo
    {
        return $this->belongsTo(OrderUnit::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function invoice_order(): BelongsTo
    {
        return $this->belongsTo(InvoiceOrder::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(AgreementOrder::class)->chaperone();
    }

}
