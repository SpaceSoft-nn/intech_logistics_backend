<?php

namespace App\Modules\Tender\Domain\Models;

use App\Modules\Base\Enums\WeekEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeekPeriod extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'week_periods';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

    protected $fillable = [

        'lot_tender_id',
        'value',

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'value' => WeekEnum::class,
        ];
    }

    public function lot_tender() : BelongsTo
    {
        return $this->belongsTo(LotTender::class, 'lot_tender_id', 'id');
    }
}
