<?php

namespace App\Modules\Transfer\Domain\Models;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\Transfer\Domain\Factories\TransferFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Transfer extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'transfers';

    protected static function newFactory()
    {
        return TransferFactory::new();
    }

    protected $fillable = [

        "transport_id",
        "delivery_start",
        "delivery_end",
        "address_start_id",
        "address_end_id",
        "order_total",
        "description",
        "body_volume",

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

    public function cargo_units(): BelongsToMany
    {
        return $this->belongsToMany(CargoUnit::class, 'cargo_unit_transfer', 'transfer_id' , 'cargo_unit_id');
    }

    public function address_start(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_start_id');
    }

    public function address_end(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_end_id');
    }

    // public function agreements(): BelongsToMany
    // {
    //     return $this->belongsToMany(AgreementOrder::class, 'agreement_transfer', 'transfer_id' , 'agreement_id');
    // }

    //полиморфное отношение к таблица agreement (При выборе перевозчиком - заказчика)
    public function agreement_contractor(): MorphToMany
    {
        return $this->morphToMany(AgreementOrderContractor::class , 'agreementable' ,'transfer_agreement_pylymorphs');
    }

    //полиморфное отношение к таблица agreement (При выборе заказчиком - перевозчика)
    public function agreement_order(): MorphToMany
    {
        return $this->morphToMany(AgreementOrder::class , 'agreementable' ,'transfer_agreement_pylymorphs');
    }
}
