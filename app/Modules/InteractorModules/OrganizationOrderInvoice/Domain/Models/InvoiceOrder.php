<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Factories\InvoiceOrderFactory;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceOrder extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'invoice_orders';

    protected static function newFactory()
    {
        return InvoiceOrderFactory::new();
    }

    protected $fillable = [

        "transport_id",
        "price",
        "date",
        "comment",

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
            'data' => "datetime",
        ];
    }

    public function organizationOrderUnitInvoice() : HasOne
    {
        return $this->hasOne(OrganizationOrderUnitInvoice::class, 'invoice_order_id', 'id');
    }

    public function transport() : BelongsTo
    {
        return $this->belongsTo(Transport::class, 'transport_id', 'id');
    }

}
