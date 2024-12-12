<?php

namespace App\Modules\Transport\Domain\Models;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use App\Modules\Transport\App\Data\Enums\TransportBodyType;
use App\Modules\Transport\App\Data\Enums\TransportLoadingType;
use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeEnum;
use App\Modules\Transport\App\Data\Enums\TransportTypeWeight;
use App\Modules\Transport\Domain\Factories\TransportFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
