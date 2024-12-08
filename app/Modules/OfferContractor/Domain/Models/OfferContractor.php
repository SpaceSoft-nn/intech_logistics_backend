<?php

namespace App\Modules\OfferContractor\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferContractor extends Model
{
    use HasFactory, HasUuids;

    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

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
}
