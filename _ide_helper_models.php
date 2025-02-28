<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Modules\Address\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $region
 * @property string $city
 * @property string $street
 * @property string|null $building
 * @property string|null $postal_code
 * @property numeric $latitude
 * @property numeric $longitude
 * @property array|null $json
 * @property string|null $update_json
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Modules\Address\App\Data\Enums\TypeAddressEnum $type_Address
 * @property-read \App\Modules\InteractorModules\AddressOrder\Domain\Models\OrderUnitAddress|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\OrderUnit> $order_units
 * @property-read int|null $order_units_count
 * @method static \App\Modules\Address\Domain\Factories\AddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdateJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Modules\Avizo\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $sender Отправитель
 * @property string $confirming Подтверждающий
 * @property bool $status_confirmation Статус подтверждения со стороны подтверждающего
 * @property string $url Url для подтверждения
 * @property string $uuid uuid подтврждения
 * @property string $url_liftime Время жизни кода
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereConfirming($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereStatusConfirmation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereUrlLiftime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoEmail whereUuid($value)
 */
	class AvizoEmail extends \Eloquent {}
}

namespace App\Modules\Avizo\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $sender Отправитель
 * @property string $confirming Подтверждающий
 * @property bool $status_confirmation Статус подтверждения со стороны подтверждающего
 * @property string $code Код для подтврждения
 * @property string $code_liftime Время жизни кода
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone whereCodeLiftime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone whereConfirming($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone whereStatusConfirmation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AvizoPhone whereUpdatedAt($value)
 */
	class AvizoPhone extends \Eloquent {}
}

namespace App\Modules\GAR\Domain\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GAR newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GAR newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GAR query()
 */
	class GAR extends \Eloquent {}
}

namespace App\Modules\IndividualPeople\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $personal_area_id
 * @property string|null $organization_id
 * @property string $series Серия Водительского Удостоверения
 * @property string $number Номер Водительского Удостоверения
 * @property mixed $date_get Дата получения Водительского Удостоверения
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\IndividualPeople\Domain\Models\IndividualPeople|null $individual_people
 * @property-read \App\Modules\Organization\Domain\Models\Organization|null $organization
 * @property-read \App\Modules\Transport\Domain\Models\Transport|null $transport
 * @method static \App\Modules\IndividualPeople\Domain\Factories\DriverPeopleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople whereDateGet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople wherePersonalAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DriverPeople whereUpdatedAt($value)
 */
	class DriverPeople extends \Eloquent {}
}

namespace App\Modules\IndividualPeople\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $owner_id
 * @property string $name
 * @property string $address
 * @property string|null $phone_number
 * @property string|null $email
 * @property bool $remuved Статус Закрыт/Открыт
 * @property string|null $website
 * @property string $type
 * @property string|null $description
 * @property string|null $okved
 * @property string|null $founded_date
 * @property string $inn Инн у ООО/ИП
 * @property string|null $kpp КПП - Только у организации
 * @property string|null $registration_number ОГРН - Только у организации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople query()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereFoundedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereokved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereRegistrationNumberIndividual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereRemuved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereWebsite($value)
 * @property string $first_name Имя
 * @property string $last_name Фамилия
 * @property string $father_name Отчество
 * @property string $position
 * @property string $phone
 * @property string $other_contact
 * @property string $comment
 * @property string $personal_area_id
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereOtherContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople wherePersonalAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople wherePosition($value)
 * @mixin \Eloquent
 * @property string|null $individualable_id
 * @property string|null $individualable_type
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $individualable
 * @method static \App\Modules\IndividualPeople\Domain\Factories\IndividualPeopleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualPeople whereIndividualableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualPeople whereIndividualableType($value)
 */
	class IndividualPeople extends \Eloquent {}
}

namespace App\Modules\IndividualPeople\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $personal_area_id
 * @property string|null $organization_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\IndividualPeople\Domain\Models\IndividualPeople|null $individual_people
 * @method static \App\Modules\IndividualPeople\Domain\Factories\StorekeeperPeopleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorekeeperPeople newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorekeeperPeople newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorekeeperPeople query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorekeeperPeople whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorekeeperPeople whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorekeeperPeople whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorekeeperPeople wherePersonalAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StorekeeperPeople whereUpdatedAt($value)
 */
	class StorekeeperPeople extends \Eloquent {}
}

namespace App\Modules\InteractorModules\AddressOrder\Domain\Models{
/**
 * 
 *
 * @property int $id
 * @property string $order_unit_id
 * @property string $address_id
 * @property string $data_time
 * @property \App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum $type
 * @property int $priority Приоритетность - с помощью этого поля поймём вектор движение между адрессами
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress whereDataTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress whereOrderUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitAddress whereUpdatedAt($value)
 */
	class OrderUnitAddress extends \Eloquent {}
}

namespace App\Modules\InteractorModules\AgreementTransfer\Domain\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTransfer query()
 */
	class AgreementTransfer extends \Eloquent {}
}

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $transport_id
 * @property string|null $price
 * @property string|null $date
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice|null $organizationOrderUnitInvoice
 * @property-read \App\Modules\Transport\Domain\Models\Transport|null $transport
 * @method static \App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Factories\InvoiceOrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder whereTransportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrder whereUpdatedAt($value)
 */
	class InvoiceOrder extends \Eloquent {}
}

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $order_unit_id
 * @property string $organization_id
 * @property string|null $user_id user который создавал данный отклик
 * @property string $invoice_order_id Документ при отклике, может быть один связь 1к1
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder|null $invoice_order
 * @property-read \App\Modules\OrderUnit\Domain\Models\OrderUnit|null $order_unit
 * @property-read \App\Modules\Organization\Domain\Models\Organization|null $organization
 * @method static \App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Factories\OrganizationOrderInvoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice whereInvoiceOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice whereOrderUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationOrderUnitInvoice whereUserId($value)
 */
	class OrganizationOrderUnitInvoice extends \Eloquent {}
}

namespace App\Modules\InteractorModules\Registration\Domain\Model{
/**
 * 
 *
 * @property int $id
 * @property string $user_id
 * @property string $organization_id
 * @property \App\Modules\Organization\App\Data\Enums\TypeCabinetEnum|null $type_cabinet Тип кабинета: заказчик, склад (РЦ), перевозчик
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Organization\Domain\Models\Organization|null $organization
 * @property-read \App\Modules\User\Domain\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization whereTypeCabinet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserOrganization whereUserId($value)
 */
	class UserOrganization extends \Eloquent {}
}

namespace App\Modules\Matrix\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $city_start_gar_id Значение Гар для города отправления
 * @property string|null $city_end_gar_id Значение Гар для города прибытия
 * @property string $city_name_start Название города отправки
 * @property string $city_name_end Название города прибытия
 * @property float $distance Дистанция
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \App\Modules\Matrix\Domain\Factories\MatrixDistanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance whereCityEndGarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance whereCityNameEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance whereCityNameStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance whereCityStartGarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MatrixDistance whereUpdatedAt($value)
 */
	class MatrixDistance extends \Eloquent {}
}

namespace App\Modules\Matrix\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $region_start_gar_id Значение Гар для области отправления
 * @property string|null $region_end_gar_id Значение Гар для области прибытия
 * @property string $region_name_start Название области отправки
 * @property string $region_name_end Название области прибытия
 * @property float $factor коэффициент
 * @property string $price цена за 1 км
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \App\Modules\Matrix\Domain\Factories\RegionEconomicFactorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor whereFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor whereRegionEndGarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor whereRegionNameEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor whereRegionNameStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor whereRegionStartGarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegionEconomicFactor whereUpdatedAt($value)
 */
	class RegionEconomicFactor extends \Eloquent {}
}

namespace App\Modules\Notification\Domain\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigNotification whereValue($value)
 * @mixin \Eloquent
 */
	class ConfigNotification extends \Eloquent {}
}

namespace App\Modules\Notification\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $uuid_send
 * @property int $code Введённый код пользователем
 * @property bool|null $confirm Статус подтрвеждения кода
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Notification\Domain\Models\SendEmail|null $send
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmEmail whereUuidSend($value)
 * @mixin \Eloquent
 */
	class ConfirmEmail extends \Eloquent {}
}

namespace App\Modules\Notification\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $uuid_send
 * @property int $code Введённый код пользователем
 * @property bool|null $confirm Статус подтрвеждения кода
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Notification\Domain\Models\SendPhone|null $send
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfirmPhone whereUuidSend($value)
 * @mixin \Eloquent
 */
	class ConfirmPhone extends \Eloquent {}
}

namespace App\Modules\Notification\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $value Почта
 * @property bool $status Статус активации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailList whereValue($value)
 * @mixin \Eloquent
 * @property-read \App\Modules\User\Domain\Models\User|null $user
 * @method static \App\Modules\Notification\Domain\Factories\EmailFactory factory($count = null, $state = [])
 */
	class EmailList extends \Eloquent {}
}

namespace App\Modules\Notification\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $value Номер телефона
 * @property bool $status Статус активации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList query()
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PhoneList whereValue($value)
 * @mixin \Eloquent
 * @property-read \App\Modules\User\Domain\Models\User|null $user
 * @method static \App\Modules\Notification\Domain\Factories\PhoneFactory factory($count = null, $state = [])
 */
	class PhoneList extends \Eloquent {}
}

namespace App\Modules\Notification\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $uuid_list
 * @property string $driver Драйвер отправки
 * @property string $value Почта
 * @property int $code Код для подтверждения активации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereUuidList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendEmail whereValue($value)
 * @mixin \Eloquent
 */
	class SendEmail extends \Eloquent {}
}

namespace App\Modules\Notification\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $uuid_list
 * @property string $driver Драйвер отправки
 * @property string $value Номер телефона
 * @property int $code Код для подтверждения активации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereUuidList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SendPhone whereValue($value)
 * @mixin \Eloquent
 */
	class SendPhone extends \Eloquent {}
}

namespace App\Modules\OfferContractor\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $offer_contractor_invoice_order_customer_id
 * @property string|null $order_unit_id Создание заказа после согласование сторон
 * @property string $offer_contractor_id Предложения к которому мы привязаны
 * @property string $organization_contractor_id Организация перевозчика
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept|null $agreement_order_contractor_accept
 * @property-read \App\Modules\OfferContractor\Domain\Models\OfferContractor|null $offer_contractor
 * @property-read \App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer|null $offer_contractor_invoice_order_customer
 * @property-read \App\Modules\OrderUnit\Domain\Models\OrderUnit|null $order_unit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Transfer\Domain\Models\Transfer> $transfer
 * @property-read int|null $transfer_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor whereOfferContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor whereOfferContractorInvoiceOrderCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor whereOrderUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor whereOrganizationContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractor whereUserId($value)
 */
	class AgreementOrderContractor extends \Eloquent {}
}

namespace App\Modules\OfferContractor\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $agreement_order_contractor_id
 * @property bool $order_bool Подтврждения со стороны организации: заказчика
 * @property bool $contractor_bool Подтврждения со стороны организации: перевозчика
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor|null $agreement_order_contractor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept whereAgreementOrderContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept whereContractorBool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept whereOrderBool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderContractorAccept whereUpdatedAt($value)
 */
	class AgreementOrderContractorAccept extends \Eloquent {}
}

namespace App\Modules\OfferContractor\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $order_total Цена/Выплата за заказ
 * @property string|null $description
 * @property string $body_volume Общий объём заказа
 * @property string $type_product Тип товара перевозки
 * @property \App\Modules\Transport\App\Data\Enums\TransportTypeWeight $type_transport_weight Тип траспортного средства
 * @property \App\Modules\Transport\App\Data\Enums\TransportLoadingType $type_load_truck Тип загрузки трака: LTL, FTL, Custom...
 * @property string $start_address_id Адресс начала заказа
 * @property string $end_address_id Адресс доставки
 * @property \Illuminate\Support\Carbon $start_date Дата отправления
 * @property \Illuminate\Support\Carbon $end_date Дата прибытия
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read InvoiceOrderCustomer|null $offer_contractor_customer
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereBodyVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereEndAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereOrderTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereStartAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereTypeLoadTruck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereTypeProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereTypeTransportWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceOrderCustomer whereUpdatedAt($value)
 */
	class InvoiceOrderCustomer extends \Eloquent {}
}

namespace App\Modules\OfferContractor\Domain\Models{
/**
 * Таблица - предложения перевозчика
 *
 * @property string $id
 * @property string $city_name_start Только город
 * @property string $city_name_end Только город
 * @property string $price_for_distance Дистанция за 1 км
 * @property string|null $description Дистанция за 1 км
 * @property \App\Modules\OfferContractor\App\Data\Enums\OfferContractorStatusEnum $status
 * @property string $transport_id
 * @property string|null $user_id
 * @property string $organization_id
 * @property string|null $order_unit_id к какому заказу привязано предложения
 * @property bool $add_load_space Возможен ли догруз
 * @property bool $road_back Обратная дорога
 * @property bool $directly_road Прямая дорога
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor|null $agreement_order_contractor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer> $offer_contractor_customer
 * @property-read int|null $offer_contractor_customer_count
 * @method static \App\Modules\OfferContractor\Domain\Factories\OfferContractorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereAddLoadSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereCityNameEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereCityNameStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereDirectlyRoad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereOrderUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor wherePriceForDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereRoadBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereTransportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractor whereUserId($value)
 */
	class OfferContractor extends \Eloquent {}
}

namespace App\Modules\OfferContractor\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $invoice_order_customer_id
 * @property string $offer_contractor_id
 * @property string $organization_id
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor|null $agreement_order_contractors
 * @property-read \App\Modules\OfferContractor\Domain\Models\InvoiceOrderCustomer|null $invoice_order_customer
 * @property-read OfferContractorCustomer|null $offer_contractor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer whereInvoiceOrderCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer whereOfferContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferContractorCustomer whereUserId($value)
 */
	class OfferContractorCustomer extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $order_unit_id
 * @property string|null $organization_contractor_id Данные организации contractor (подрядчика)
 * @property string $organization_order_units_invoce_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept|null $agreementOrderAccept
 * @property-read \App\Modules\OrderUnit\Domain\Models\OrderUnit|null $order
 * @property-read \App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice|null $orgOrdertInvoices
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Transfer\Domain\Models\Transfer> $transfer
 * @property-read int|null $transfer_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Transfer\Domain\Models\Transfer> $transfers
 * @property-read int|null $transfers_count
 * @method static \App\Modules\OrderUnit\Domain\Factories\AgreementOrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder whereOrderUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder whereOrganizationContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder whereOrganizationOrderUnitsInvoceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrder whereUpdatedAt($value)
 */
	class AgreementOrder extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $document_agreement_accept_order_type
 * @property int|null $document_agreement_accept_order_id
 * @property string $agreement_order_id
 * @property bool $order_bool Заказчик подтвердил
 * @property bool $contractor_bool Исполнитель подтвердил
 * @property bool $one_agreement Если вдруг исполнитель/заказчик не находится в нашей инфрастуктуре (внешний апи), тогда нужно что бы было подтвреждение с одной стороны
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OrderUnit\Domain\Models\AgreementOrder|null $agreement
 * @method static \App\Modules\OrderUnit\Domain\Factories\AgreementOrderAcceptFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereAgreementOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereContractorBool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereDocumentAgreementAcceptOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereDocumentAgreementAcceptOrderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereOneAgreement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereOrderBool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementOrderAccept whereUpdatedAt($value)
 */
	class AgreementOrderAccept extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $name_value Наименование груза
 * @property string $product_type Тип продукта: Бытовая техника, Грибы, древисина и т.д
 * @property \App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum $type_pallet Тип паллета: eur, fin и т.д
 * @property-read int|null $cargo_units_count Количество паллетов
 * @property string $body_volume Общий объём паллетов
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OrderUnit\Domain\Models\CargoUnitCargoGoodPivot|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\CargoUnit> $cargo_units
 * @property-read \App\Modules\OrderUnit\Domain\Models\Mgx|null $mgx
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\CargoUnit> $order_units
 * @property-read int|null $order_units_count
 * @method static \App\Modules\OrderUnit\Domain\Factories\CargoGoodFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereBodyVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereCargoUnitsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereNameValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereTypePallet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoGood whereUpdatedAt($value)
 */
	class CargoGood extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property \App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum $pallets_space Тип Паллета
 * @property bool $customer_pallets_space Если тип паллета = custom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OrderUnit\Domain\Models\CargoUnitCargoGoodPivot|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\CargoGood> $cargo_goods
 * @property-read int|null $cargo_goods_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Transfer\Domain\Models\Transfer> $transfers
 * @property-read int|null $transfers_count
 * @method static \App\Modules\OrderUnit\Domain\Factories\CargoUnitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnit whereCustomerPalletsSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnit wherePalletsSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnit whereUpdatedAt($value)
 */
	class CargoUnit extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property int $id
 * @property string $cargo_good_id
 * @property string $cargo_unit_id
 * @property string $factor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot whereCargoGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot whereCargoUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot whereFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CargoUnitCargoGoodPivot whereUpdatedAt($value)
 */
	class CargoUnitCargoGoodPivot extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $length Длина
 * @property string $width Ширина
 * @property string $height Высота
 * @property string $weight Вес
 * @property string $cargo_good_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OrderUnit\Domain\Models\CargoGood|null $cargo_good
 * @method static \App\Modules\OrderUnit\Domain\Factories\MgxFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx whereCargoGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mgx whereWidth($value)
 */
	class Mgx extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property int $number_order Номер заказа для фронта
 * @property \Illuminate\Support\Carbon|null $end_date_order До какой даты заказ будет активен
 * @property \Illuminate\Support\Carbon|null $exemplary_date_start Примерная дата начала заказ
 * @property string|null $body_volume Общий объём заказа
 * @property string $order_total Цена/Выплата за заказ
 * @property string|null $description
 * @property \App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight $type_transport_weight Тип траспортного средства
 * @property int|null $cargo_unit_sum Общее количество паллетов в заказе
 * @property \App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod $type_load_truck Тип загрузки трака: LTL, FTL, Custom...
 * @property string|null $user_id Пользователь создавший заказ
 * @property string $organization_id Организация к которой привязан заказ
 * @property string|null $contractor_id Выбранный подрядчик на заказ.
 * @property string|null $transport_id Выбранный транспорта перевозчика
 * @property bool $add_load_space Возможен ли догруз
 * @property bool $change_price Возможна изменения цены (торг)
 * @property bool $change_time Возможна Изменение времени
 * @property bool $address_is_array Если у нас больше двух адрессов
 * @property bool $goods_is_array Если у заказа больше одного груза
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $lot_tender_id Если заказ создатёся по бизнес-логики Тендера
 * @property-read \App\Modules\OrderUnit\Domain\Models\OrderUnitStatus|null $actual_status
 * @property-read \App\Modules\InteractorModules\AddressOrder\Domain\Models\OrderUnitAddress|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Address\Domain\Models\Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\CargoGood> $cargo_goods
 * @property-read int|null $cargo_goods_count
 * @property-read \App\Modules\Organization\Domain\Models\Organization|null $contractor
 * @property-read \App\Modules\Tender\Domain\Models\LotTender|null $lot_tender
 * @property-read \App\Modules\OrderUnit\Domain\Models\Mgx|null $mgx
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\OrderUnitStatus> $order_unit_statuses
 * @property-read int|null $order_unit_statuses_count
 * @property-read \App\Modules\Organization\Domain\Models\Organization|null $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice> $organization_order_unit_invoices
 * @property-read int|null $organization_order_unit_invoices_count
 * @property-read \App\Modules\User\Domain\Models\User|null $user
 * @method static \App\Modules\OrderUnit\Domain\Factories\OrderUnitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereAddLoadSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereAddressIsArray($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereBodyVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereCargoUnitSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereChangePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereChangeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereEndDateOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereExemplaryDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereGoodsIsArray($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereLotTenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereNumberOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereOrderTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereTransportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereTypeLoadTruck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereTypeTransportWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnit whereUserId($value)
 */
	class OrderUnit extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $order_unit_id
 * @property \App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum $status status order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OrderUnit\Domain\Models\OrderUnit|null $order_unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitStatus whereOrderUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderUnitStatus whereUpdatedAt($value)
 */
	class OrderUnitStatus extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $order_unit_id
 * @property \App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum $status Событие транспортировки: в пути, на выгрзке, на разгрузке
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OrderUnit\Domain\Models\OrderUnit|null $order_unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusTransportationEventModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusTransportationEventModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusTransportationEventModel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusTransportationEventModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusTransportationEventModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusTransportationEventModel whereOrderUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusTransportationEventModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StatusTransportationEventModel whereUpdatedAt($value)
 */
	class StatusTransportationEventModel extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models\Status{
/**
 * 
 *
 * @property-read ChainTransportationStatus|null $next_status
 * @property-read \App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus|null $status
 * @method static \App\Modules\OrderUnit\Domain\Factories\ChainTransportationStatusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChainTransportationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChainTransportationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChainTransportationStatus query()
 */
	class ChainTransportationStatus extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models\Status{
/**
 * 
 *
 * @property int $id
 * @property string $enum_name Название статуса
 * @property \App\Modules\OrderUnit\App\Data\Enums\TransportationStatusEnum $enum_value Значения Статуса
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnumTransportationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnumTransportationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnumTransportationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnumTransportationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnumTransportationStatus whereEnumName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnumTransportationStatus whereEnumValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnumTransportationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EnumTransportationStatus whereUpdatedAt($value)
 */
	class EnumTransportationStatus extends \Eloquent {}
}

namespace App\Modules\OrderUnit\Domain\Models\Status{
/**
 * 
 *
 * @property string $id
 * @property string $order_unit_id ссылка на заказ
 * @property int $enum_transporatrion_status_id ссылка на таблицу enum/const в бд на статусы
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus $enum_transporatrion_status
 * @method static \App\Modules\OrderUnit\Domain\Factories\TransporationStatusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransporationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransporationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransporationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransporationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransporationStatus whereEnumTransporatrionStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransporationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransporationStatus whereOrderUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransporationStatus whereUpdatedAt($value)
 */
	class TransporationStatus extends \Eloquent {}
}

namespace App\Modules\Organization\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $owner_id
 * @property string $name
 * @property string $address
 * @property string|null $phone_number
 * @property string|null $email
 * @property bool $remuved Статус Закрыт/Открыт
 * @property string|null $website
 * @property OrganizationEnum $type
 * @property string|null $description
 * @property string|null $okved
 * @property \Illuminate\Support\Carbon|null $founded_date
 * @property string $inn Инн у ООО/ИП
 * @property string|null $kpp КПП - Только у организации
 * @property string|null $registration_number ОГРН - Только у организации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $password
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereFoundedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereokved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereRegistrationNumberIndividual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereRemuved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereWebsite($value)
 * @mixin \Eloquent
 * @property string|null $phone
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\IndividualPeople\Domain\Models\DriverPeople> $drivers
 * @property-read int|null $drivers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OfferContractor\Domain\Models\OfferContractor> $offer_contractors
 * @property-read int|null $offer_contractors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\OrderUnit> $order_units
 * @property-read int|null $order_units_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Tender\Domain\Models\LotTender> $tenders
 * @property-read int|null $tenders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Transport\Domain\Models\Transport> $transports
 * @property-read int|null $transports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\User\Domain\Models\User> $users
 * @property-read int|null $users_count
 * @method static \App\Modules\Organization\Domain\Factories\OrganizationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereOkved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization wherePhone($value)
 */
	class Organization extends \Eloquent {}
}

namespace App\Modules\Permission\Domain\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Permission extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $lot_tender_id
 * @property string $path Указание пути к файлу с полным названием
 * @property string $disk Диск хранения файла
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Tender\Domain\Models\LotTender $lot_tender
 * @method static \App\Modules\Tender\Domain\Factories\AgreementDocumentTenderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender whereLotTenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementDocumentTender whereUpdatedAt($value)
 */
	class AgreementDocumentTender extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $lot_tender_id
 * @property string $path Указание пути к файлу
 * @property string $disk Диск хранения файла
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Tender\Domain\Models\LotTender $lot_tender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender whereLotTenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationDocumentTender whereUpdatedAt($value)
 */
	class ApplicationDocumentTender extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property int $number_tender Номер тендера для фронта
 * @property int $general_count_transport количество транспорта
 * @property float $price_for_km количество транспорта
 * @property float $body_volume_for_order количество объёма на 1 заказ
 * @property \App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight $type_transport_weight Тип транспортного средства: small - 1.5-3тонны, medium 5-10тонны
 * @property \App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod $type_load_truck Тип транспортного средства: small - 1.5-3тонны, medium 5-10тонны
 * @property \App\Modules\Tender\App\Data\Enums\StatusTenderEnum $status_tender Статус Тендера: в работе, черновик..
 * @property \App\Modules\Tender\App\Data\Enums\TypeTenderEnum $type_tender Разовый/Переодический
 * @property string $date_start Дата начало тендера
 * @property int $period Количество дней, например в течении 60 дней
 * @property string $organization_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Tender\Domain\Models\AgreementDocumentTender|null $agreement_document_tender
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Tender\Domain\Models\ApplicationDocumentTender> $application_document_tender
 * @property-read int|null $application_document_tender_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\OrderUnit> $order_unit
 * @property-read int|null $order_unit_count
 * @property-read \App\Modules\Organization\Domain\Models\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Tender\Domain\Models\SpecificalDatePeriod> $specifica_date_period
 * @property-read int|null $specifica_date_period_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Tender\Domain\Models\WeekPeriod> $week_period
 * @property-read int|null $week_period_count
 * @method static \App\Modules\Tender\Domain\Factories\TenderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereBodyVolumeForOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereDateStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereGeneralCountTransport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereNumberTender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender wherePriceForKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereStatusTender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereTypeLoadTruck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereTypeTender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereTypeTransportWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTender whereUpdatedAt($value)
 */
	class LotTender extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models\Response{
/**
 * 
 *
 * @property string $id
 * @property string $lot_tender_response_id
 * @property string $organization_contractor_id Организация - которая откликнулась на заказ
 * @property string $lot_tender_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender whereLotTenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender whereLotTenderResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender whereOrganizationContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTender whereUpdatedAt($value)
 */
	class AgreementTender extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models\Response{
/**
 * 
 *
 * @property string $id
 * @property string $agreement_tender_id
 * @property bool $tender_creater_bool Статус организации: создателя тендера
 * @property bool $contractor_bool Статус организации: откликнувшиеся на тендер
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept whereAgreementTenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept whereContractorBool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept whereTenderCreaterBool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AgreementTenderAccept whereUpdatedAt($value)
 */
	class AgreementTenderAccept extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models\Response{
/**
 * 
 *
 * @property string $id
 * @property string $transport_id
 * @property string $lot_tender_response_id
 * @property float $price_for_km количество транспорта
 * @property string|null $comment количество транспорта
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender whereLotTenderResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender wherePriceForKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender whereTransportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLotTender whereUpdatedAt($value)
 */
	class InvoiceLotTender extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models\Response{
/**
 * 
 *
 * @property string $id
 * @property string $lot_tender_id
 * @property string $organization_contractor_id Организация - перевозчика, которая откликнулась на тендер
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Tender\Domain\Models\Response\InvoiceLotTender|null $invoice_lot_tender
 * @property-read \App\Modules\Organization\Domain\Models\Organization $organization_contractor
 * @property-read \App\Modules\Tender\Domain\Models\LotTender $tender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTenderResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTenderResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTenderResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTenderResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTenderResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTenderResponse whereLotTenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTenderResponse whereOrganizationContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTenderResponse whereUpdatedAt($value)
 */
	class LotTenderResponse extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $lot_tender_id Выбранный подрядчик на заказ.
 * @property string $date Дата выполнения
 * @property int $count_transport Количество транспорта
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Tender\Domain\Models\LotTender $lot_tender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod whereCountTransport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod whereLotTenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecificalDatePeriod whereUpdatedAt($value)
 */
	class SpecificalDatePeriod extends \Eloquent {}
}

namespace App\Modules\Tender\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $lot_tender_id
 * @property \App\Modules\Base\Enums\WeekEnum $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Tender\Domain\Models\LotTender $lot_tender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeekPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeekPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeekPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeekPeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeekPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeekPeriod whereLotTenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeekPeriod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WeekPeriod whereValue($value)
 */
	class WeekPeriod extends \Eloquent {}
}

namespace App\Modules\Transfer\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $transport_id
 * @property string $delivery_start Дата загрузки и отправления
 * @property string $delivery_end Дата прибытия
 * @property string $address_start_id
 * @property string $address_end_id
 * @property string $order_total Общая сумма всех заказов
 * @property string $description
 * @property string $body_volume Подсчет общего объёма загрузки
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Address\Domain\Models\Address|null $address_end
 * @property-read \App\Modules\Address\Domain\Models\Address|null $address_start
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor> $agreement_contractor
 * @property-read int|null $agreement_contractor_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\AgreementOrder> $agreement_order
 * @property-read int|null $agreement_order_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\CargoUnit> $cargo_units
 * @property-read int|null $cargo_units_count
 * @method static \App\Modules\Transfer\Domain\Factories\TransferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereAddressEndId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereAddressStartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereBodyVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereDeliveryEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereDeliveryStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereOrderTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereTransportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transfer whereUpdatedAt($value)
 */
	class Transfer extends \Eloquent {}
}

namespace App\Modules\Transfer\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $transfer_id
 * @property string $offer_contractor_invoice_order_customer_id
 * @property string $agreementable_type
 * @property int $agreementable_id
 * @property bool $order_main
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \App\Modules\Transfer\Domain\Factories\TransferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph whereAgreementableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph whereAgreementableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph whereOfferContractorInvoiceOrderCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph whereOrderMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph whereTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransferAgreementPolymorph whereUpdatedAt($value)
 */
	class TransferAgreementPolymorph extends \Eloquent {}
}

namespace App\Modules\Transport\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $brand_model модель - например: Volvo FH, MAN TGS
 * @property \App\Modules\Transport\App\Data\Enums\TransportLoadingType $type_loading Тип загрузки транспортного средства (cбоку, cверху и т.д)
 * @property \App\Modules\Transport\App\Data\Enums\TransportTypeWeight $type_weight Тип транспортного средства в Тоннах
 * @property \App\Modules\Transport\App\Data\Enums\TransportBodyType $type_body Тип Кузова: бортовой, цистерна и т.д
 * @property \App\Modules\Transport\App\Data\Enums\TransportStatusEnum $type_status Текущий статус транспортного средства: свободно, эксплуатация, ремонт
 * @property string $year Год выпуска транспорта
 * @property string $transport_number Номерной знак
 * @property float $body_volume Максимальная Вместимость
 * @property float $body_weight Максимальная Масса груза
 * @property string|null $description Описание/Заметка
 * @property string $organization_id
 * @property string|null $driver_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\IndividualPeople\Domain\Models\DriverPeople|null $driver
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder> $invoiceOrders
 * @property-read int|null $invoice_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\OrderUnit\Domain\Models\OrderUnit> $order_units
 * @property-read int|null $order_units_count
 * @property-read \App\Modules\Organization\Domain\Models\Organization $organization
 * @method static \App\Modules\Transport\Domain\Factories\TransportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereBodyVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereBodyWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereBrandModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereTransportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereTypeBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereTypeLoading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereTypeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereTypeWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transport whereYear($value)
 */
	class Transport extends \Eloquent {}
}

namespace App\Modules\User\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property string $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\User\Domain\Models\User> $users
 * @property-read int|null $users_count
 * @method static \App\Modules\User\Domain\Factories\PersonalAreaFactory factory($count = null, $state = [])
 */
	class PersonalArea extends \Eloquent {}
}

namespace App\Modules\User\Domain\Models{
/**
 * 
 *
 * @property string $id
 * @property mixed $password
 * @property string $first_name Имя
 * @property string $last_name Фамилия
 * @property string $father_name Отчество
 * @property UserRoleEnum $role Роль User
 * @property int $access_type Тип доступа
 * @property bool $active Активен ли пользователь
 * @property bool $auth Прошёл ли пользователь нотификацию
 * @property string|null $personal_area_id
 * @property string|null $email_id
 * @property string|null $phone_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $remember_token
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAuth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePersonalAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $permission Тип доступа
 * @property-read \App\Modules\Notification\Domain\Models\EmailList|null $email
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\Organization\Domain\Models\Organization> $organizations
 * @property-read int|null $organizations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Modules\User\Domain\Models\PersonalArea> $personal_areas
 * @property-read int|null $personal_areas_count
 * @property-read \App\Modules\Notification\Domain\Models\PhoneList|null $phone
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \App\Modules\User\Domain\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePermission($value)
 */
	class User extends \Eloquent {}
}

