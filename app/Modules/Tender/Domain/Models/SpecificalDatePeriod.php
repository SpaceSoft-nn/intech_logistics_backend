<?php

namespace App\Modules\Tender\Domain\Models;

use App\Modules\Tender\Domain\Factories\SpecificalDatePeriodFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecificalDatePeriod extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'specific_date_periods';

    protected static function newFactory()
    {
        return SpecificalDatePeriodFactory::new();
    }

    protected $fillable = [

        "lot_tender_id",
        "date",
        "count_transport",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            "date" => \App\Modules\Base\Casts\RuDateTimeCast::class,
        ];
    }

    public function lot_tender(): BelongsTo
    {
        return $this->belongsTo(LotTender::class, 'lot_tender_id');
    }

}
