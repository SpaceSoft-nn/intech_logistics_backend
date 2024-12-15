<?php

namespace App\Modules\OfferContractor\Domain\Models;

use App\Modules\OfferContractor\Domain\Factories\OfferContractorFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
    * Связь к таблице откликов от заказчиков на предложение перевозчиков
    * @return HasMany
    */
    public function offer_contractor_customer() : HasMany
    {
        return $this->hasMany(OfferContractorCustomer::class, 'offer_contractor_invoice_order_customers', 'offer_contractor_id', 'id');
    }


}
