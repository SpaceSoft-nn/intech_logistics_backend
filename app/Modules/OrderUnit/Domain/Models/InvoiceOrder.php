<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceOrder extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'invoice_orders';

    // protected static function newFactory()
    // {
    //     return CargoUnitFactory::new();
    // }

    protected $fillable = [

        "organization_id",
        "price",
        "data",
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

    public function organizationOrderUnitInvoice()
    {
        return $this->hasOne(OrganizationOrderUnitInvoice::class, 'invoice_order_id', 'id');
    }


}
