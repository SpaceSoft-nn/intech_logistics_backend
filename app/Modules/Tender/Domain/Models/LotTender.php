<?php

namespace App\Modules\Tender\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Modules\Tender\App\Data\Enums\TypeTenderEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Tender\Domain\Factories\TenderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\Domain\Models\SpecificalDatePeriod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\Tender\Domain\Models\AgreementDocumentTender;
use App\Modules\Tender\Domain\Models\ApplicationDocumentTender;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;

class LotTender extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'lot_tenders';

    protected static function newFactory()
    {
        return TenderFactory::new();
    }

    protected $fillable = [

        "general_count_transport",
        "number_tender",
        "price_for_km",
        "body_volume_for_order",

        "type_transport_weight",
        "type_load_truck",

        "status_tender",
        "type_tender",

        "date_start",
        "period",
        "day_period",
        "organization_id",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            "price_for_km" => 'double',
            "body_volume_for_order" => 'double',

            "type_transport_weight" => TypeTransportWeight::class,
            "type_load_truck" => TypeLoadingTruckMethod::class,
            "status_tender" => StatusTenderEnum::class,
            "type_tender" => TypeTenderEnum::class,

            "date_start" => \App\Modules\Base\Casts\RuDateTimeCast::class,
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function agreement_document_tender(): HasOne
    {
        return $this->hasOne(AgreementDocumentTender::class, 'lot_tender_id');
    }

    public function application_document_tender(): HasMany
    {
        return $this->hasMany(ApplicationDocumentTender::class, 'lot_tender_id');
    }

    public function specifical_date_period(): HasMany
    {
        return $this->hasMany(SpecificalDatePeriod::class, 'lot_tender_id');
    }

    public function order_unit(): HasMany
    {
        return $this->hasMany(OrderUnit::class, 'lot_tender_id');
    }

    public function week_period() : HasMany
    {
        return $this->hasMany(WeekPeriod::class, 'lot_tender_id');
    }

    /**
     * Отклики на тендер
     * @return HasMany
     */
    public function lot_tender_response() : HasMany
    {
        return $this->hasMany(LotTenderResponse::class, 'lot_tender_id', 'id');
    }
}
