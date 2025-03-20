<?php

namespace App\Modules\Tender\Domain\Models\Response;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Tender\Domain\Models\LotTender;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgreementTender extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'agreement_tenders';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

    protected $fillable = [

        "lot_tender_response_id",
        "organization_contractor_id",
        "lot_tender_id",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [

        ];
    }

    public function agreement_tender_accept(): HasOne
    {
        return $this->hasOne(AgreementTenderAccept::class, 'agreement_tender_id');
    }

    public function lot_tender(): BelongsTo
    {
        return $this->belongsTo(LotTender::class, 'lot_tender_id', 'id');
    }

    /**
     * //Отклик подрядичка (перевозчика) на тендер
     * @return BelongsTo
     */
    public function lot_tender_response(): BelongsTo
    {
        return $this->belongsTo(LotTenderResponse::class, 'lot_tender_response_id', 'id');
    }

}
