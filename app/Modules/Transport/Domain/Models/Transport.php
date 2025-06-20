<?php

namespace App\Modules\Transport\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transport\App\Data\Enums\TransportBodyType;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\Transport\Domain\Factories\TransportFactory;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;

class Transport extends Model
{

    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return TransportFactory::new();
    }

    protected $table = 'transports';

    protected $fillable = [

        "brand_model",
        "year",
        "transport_number",
        "body_volume",
        "body_weight",

        "type_loading",
        "type_weight",
        "type_body",
        "type_status",

        "organization_id",
        "driver_id",
        "description"

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            "type_loading" => TransportLoadingType::class,
            "type_weight" => TransportTypeWeight::class,
            "type_body" =>  TransportBodyType::class,
            "type_status" => TransportStatusEnum::class,
        ];
    }

    //связь к документу - при отклике Перевозчика
    public function invoiceOrders(): HasMany
    {
        return $this->hasMany(InvoiceOrder::class, 'transport_id');
    }

    public function order_units(): HasMany
    {
        return $this->hasMany(OrderUnit::class, 'transport_id');
    }

    public function driver() : BelongsTo
    {
        return $this->belongsTo(DriverPeople::class, 'driver_id', 'id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
