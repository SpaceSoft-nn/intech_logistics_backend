<?php

namespace App\Modules\Tender\Domain\Models\Response;

use App\Modules\Organization\Domain\Models\Organization;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Tender\Domain\Models\LotTender;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function organization_contractor(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_contractor_id', 'id');
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

    /**
     * Прямая связь к таблице invoiceTender через промежуточную табилцу orgOrderInvoices с помощью акксесора
     * @return Attribute
     */
    protected function invoiceTender(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->lot_tender_response?->invoice_lot_tender ? $this->lot_tender_response->invoice_lot_tender : null,
        );

    }

}
