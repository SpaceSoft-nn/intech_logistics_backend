<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\Domain\Factories\AgreementOrderFactory;
use App\Modules\Transfer\Domain\Models\Transfer;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function transfers(): BelongsToMany
    {
        return $this->belongsToMany(Transfer::class, 'agreement_transfer', 'transfer_id' , 'agreement_id');
    }
}
