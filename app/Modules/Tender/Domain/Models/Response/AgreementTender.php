<?php

namespace App\Modules\Tender\Domain\Models\Response;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementTender extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'agreement_tenders';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

    protected $fillable = [

        "lot_tender_respons_id",
        "organization_tender_create_id",
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

}
