<?php

namespace App\Modules\Tender\Domain\Models\Response;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\Domain\Factories\LotTenderResponseFactory;
use App\Modules\Tender\Domain\Models\LotTender;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

//Отклик подрядичка (перевозчика) на тендер
class LotTenderResponse extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'lot_tender_responses';

    protected static function newFactory()
    {
        return LotTenderResponseFactory::new();
    }

    protected $fillable = [

        "lot_tender_id",
        "organization_contractor_id",

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

    public function invoice_lot_tender() : HasOne
    {
        return $this->hasOne(InvoiceLotTender::class, 'lot_tender_response_id');
    }

    public function organization_contractor() : BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_contractor_id', 'id');
    }

    public function tender() : BelongsTo
    {
        return $this->belongsTo(LotTender::class, 'lot_tender_id', 'id');
    }

}
