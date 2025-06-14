<?php

namespace App\Modules\Tender\Domain\Models;

use App\Modules\Tender\Domain\Factories\AgreementDocumentTenderFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementDocumentTender extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'agreement_document_tenders';

    protected static function newFactory()
    {
        return AgreementDocumentTenderFactory::new();
    }

    protected $fillable = [

        "lot_tender_id",
        "path",
        "disk",
        "description",

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

    public function lot_tender(): BelongsTo
    {
        return $this->belongsTo(LotTender::class, 'lot_tender_id');
    }
}
