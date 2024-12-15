<?php

namespace App\Modules\Transfer\Domain\Models;


use App\Modules\Transfer\Domain\Factories\TransferFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TransferAgreementPolymorph extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'transfer_agreement_pylymorphs';

    protected static function newFactory()
    {
        return TransferFactory::new();
    }

    protected $fillable = [

        "transfer_id",
        "offer_contractor_invoice_order_customer_id",

        "agreementable_id",
        "agreementable_type",

        "order_main",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected function casts(): array
    {
        return [

        ];
    }

}
