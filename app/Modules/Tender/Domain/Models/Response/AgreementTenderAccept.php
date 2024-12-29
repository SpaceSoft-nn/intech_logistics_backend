<?php

namespace App\Modules\Tender\Domain\Models\Response;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementTenderAccept extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'agreement_tender_accepts';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

    protected $fillable = [

        "agreement_tender_id",
        "tender_creater_bool",
        "contractor_bool",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            "tender_creater_bool" => "boolean",
            "contractor_id" => "boolean",
        ];
    }

    protected function agreement_tender(): BelongsTo
    {
        return $this->belongsTo(AgreementTender::class, 'agreement_tender_id');
    }

}
