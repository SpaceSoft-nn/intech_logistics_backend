<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\InteractorModules\AdressOrder\Domain\Models\OrderUnitAddress;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Factories\OrderUnitFactory;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transfer\Domain\Models\Transfer;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderUnit extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'order_units';

    protected static function newFactory()
    {
        return OrderUnitFactory::new();
    }

    protected $fillable = [

        "delivery_start",
        "delivery_end",
        "adress_start_id",
        "adress_end_id",
        "body_volume",
        "order_total",
        "description",
        "product_type",
        "order_status",
        "user_id",
        "organization_id",
        "mgx_id",
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
            'order_status' => StatusOrderUnitEnum::class,
        ];
    }



    /**
     * Связь с паллетами многие ко многим
     * @return BelongsToMany
     */
    public function cargo_units(): BelongsToMany
    {
        #TODO Может быть баг проверить
        return $this->belongsToMany(CargoUnit::class, 'order_unit_cargo_unit', 'order_unit_id' , 'cargo_unit_id')->withPivot('factor');
    }

    public function transfers(): BelongsToMany
    {
        #TODO Может быть баг проверить - нужно ли это тут?
        return $this->belongsToMany(Transfer::class, 'cargo_unit_transfer', 'cargo_unit_id' , 'transfer_id');
    }

    public function adresses(): BelongsToMany
    {
        return $this->belongsToMany(Adress::class, 'order_unit_adress', 'order_unit_id' , 'adress_id' )
            ->using(OrderUnitAddress::class)
            ->withPivot(['data_time', 'type', 'priority'])
            ->withTimestamps();
    }

    public function mgx(): BelongsTo
    {
        return $this->belongsTo(Mgx::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

}
