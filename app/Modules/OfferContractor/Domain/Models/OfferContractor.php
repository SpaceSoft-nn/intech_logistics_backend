<?php

namespace App\Modules\OfferContractor\Domain\Models;

use App\Modules\OfferContractor\App\Data\Enums\OfferContractorStatusEnum;
use App\Modules\OfferContractor\Domain\Factories\OfferContractorFactory;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Таблица - предложения перевозчика
 */
class OfferContractor extends Model
{ //Таблица - предложения перевозчика

    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return OfferContractorFactory::new();
    }

    protected $table = 'offer_contractors';

    protected $fillable = [

        'city_name_start',
        'city_name_end',

        'price_for_distance',
        'description',
        'status',

        'transport_id',
        'user_id',
        'organization_id',
        'order_unit_id',

        //bool переменные
        'add_load_space', //Возможен ли догруз
        'road_back', //Обратная дорога
        'directly_road', //Прямая дорога
    ];

    protected $guarded = [
        'id',
        'number',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected function casts(): array
    {
        return [
            'status' => OfferContractorStatusEnum::class,
        ];
    }

    /**
    * Связь к таблице откликов от заказчиков на предложение перевозчиков
    * @return HasMany
    */
    public function offer_contractor_customer() : HasMany
    {
        return $this->hasMany(OfferContractorCustomer::class, 'offer_contractor_id', 'id');
    }

    /**
    * связь к таблице, когда перевозчик выбрал исполнителя "заказчика", то есть возьмёт в работу заказ
    * @return HasOne
    */
    public function agreement_order_contractor() : HasOne
    {
        return $this->hasOne(AgreementOrderContractor::class, 'offer_contractor_id', 'id');
    }

    /**
    *
    * @return HasOne
    */
    public function transport() : BelongsTo
    {
        return $this->belongsTo(Transport::class, 'transport_id', 'id');
    }

}
