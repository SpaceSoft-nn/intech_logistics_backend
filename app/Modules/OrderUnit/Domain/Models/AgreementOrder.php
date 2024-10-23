<?php

namespace App\Modules\OrderUnit\Domain\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AgreementOrder extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'agreement_orders';

    // protected static function newFactory()
    // {
    //     return TransferFactory::new();
    // }

    protected $fillable = [

        'order_unit_id',
        'organization_transfer_id',
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


}
