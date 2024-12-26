<?php

namespace App\Modules\Tender\Domain\Models\Response;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LotTenderRespons extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'lot_tender_responses';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

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
        return $this->hasOne(InvoiceLotTender::class, 'lot_tender_respons_id');
    }

}
