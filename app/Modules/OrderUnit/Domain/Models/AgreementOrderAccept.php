<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\Domain\Factories\AgreementOrderAcceptFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementOrderAccept extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'agreement_orders_accepts';

    protected static function newFactory()
    {
        return AgreementOrderAcceptFactory::new();
    }

    protected $fillable = [

        'document_agreement_accept_order_id',
        'document_agreement_accept_order_type',

        'agreement_order_id',

        'order_bool',
        'contractor_bool',
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
            'order_bool' => 'boolean',
            'contractor_bool' => 'boolean',
        ];
    }

    // Связь обратная belongsTo с Agreement
    public function agreement() : BelongsTo
    {
        return $this->belongsTo(AgreementOrder::class, 'agreement_order_id');
    }

}
