<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\Address\Domain\Models\Address;
use App\Modules\InteractorModules\AddressOrder\Domain\Models\OrderUnitAddress;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\OrderUnit\Domain\Factories\OrderUnitFactory;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Transport\Domain\Models\Transport;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderUnit extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'order_units';

    protected static function newFactory()
    {
        return OrderUnitFactory::new();
    }

    protected $fillable = [

        //date
        "end_date_order",
        "exemplary_date_start",

        "body_volume",
        "order_total",
        "description",

        "cargo_unit_sum",
        "product_type",

        //enum
        "type_transport_weight",
        "type_load_truck",

        //relastionship
        "transport_id",
        "user_id",
        "organization_id",
        "contractor_id",
        "lot_tender_id",
        "offer_contractor_id",


        //bool
        "add_load_space",
        "change_price",
        "change_time",
        "address_is_array",
        "goods_is_array",

    ];

    protected $guarded = [
        'id',
        'number_order',
        'created_at',
        'updated_at',

        "change_price",
        "change_time",
    ];

    protected $hidden = [

    ];

    protected function casts(): array
    {
        return [

            "type_load_truck" => TypeLoadingTruckMethod::class,
            "type_transport_weight" => TypeTransportWeight::class,
            'exemplary_date_start' => "datetime",

            'add_load_space' => "boolean",
            'change_price' => "boolean",
            'change_time' => "boolean",
            'address_is_array' => "boolean",
            'goods_is_array' => "boolean",

            'end_date_order' => \App\Modules\Base\Casts\RuDateTimeCast::class,
        ];
    }



    //TODO - Вынести в репозиторий
    /**
    * Вернуть все возможные статусы которые были
    * @return HasMany
    */
    public function order_unit_statuses(): HasMany
    {
        return $this->hasMany(OrderUnitStatus::class);
    }

    #TODO Вынести в репозиторий
    public function actual_status(): HasOne
    {
        /**
         * при latest - мы можем указать по какому столбцу возвращать P.S Может быть проблема,
         * если uuid будет заполняться от разных серверов с разным временем - будет коллизия или не верный возврат статуса
        */
        return $this->hasOne(OrderUnitStatus::class)->latest('created_at')->orderBy('id', 'desc');
    }

    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class, 'order_unit_address', 'order_unit_id' , 'address_id')
            ->using(OrderUnitAddress::class)
            ->withPivot(['data_time', 'type', 'priority'])
            ->withTimestamps();
    }

    /**
    * Связь с заказом многие ко многим
    * @return BelongsToMany
    */
    public function cargo_goods(): BelongsToMany
    {
        //TODO Может быть баг - потом проверить
        return $this->belongsToMany(CargoGood::class, 'order_unit_cargo_good', 'order_unit_id' , 'cargo_good_id');
    }


    public function mgx(): BelongsTo
    {
        return $this->belongsTo(Mgx::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function transport(): BelongsTo
    {
        return $this->belongsTo(Transport::class, 'transport_id', 'id');
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'contractor_id');
    }

    public function lot_tender(): BelongsTo
    {
        return $this->belongsTo(LotTender::class, 'lot_tender_id', 'id');
    }

    /**
     * Вернуть все отклики от перевозчиков на заказ
     * @return HasMany
     */
    public function organization_order_unit_invoices(): HasMany
    {
        return $this->hasMany(OrganizationOrderUnitInvoice::class, 'order_unit_id', 'id');
    }

     /**
     * Вернуть все отклики от перевозчиков на заказ
     * @return HasMany
     */
    public function offer_contractor(): BelongsTo
    {
        return $this->belongsTo(OfferContractor::class, 'offer_contractor_id', 'id');
    }

}
