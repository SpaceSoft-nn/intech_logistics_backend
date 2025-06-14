<?php

namespace App\Modules\Tender\Domain\Models\Response;

use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceLotTender extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'invoice_lot_tenders';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

    protected $fillable = [

        "transport_id",
        "lot_tender_response_id",
        "price_for_km",
        "comment",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            "lot_tender_responses" => "double",
        ];
    }

    public function transport() : BelongsTo
    {
        return $this->belongsTo(Transport::class, 'transport_id', 'id');
    }



}
