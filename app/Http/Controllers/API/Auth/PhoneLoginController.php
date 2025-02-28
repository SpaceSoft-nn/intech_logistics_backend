<?php

namespace App\Http\Controllers\API\Auth;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use App\Modules\User\Domain\Models\User;
use App\Modules\Notification\Domain\Models\PhoneList;

use App\Modules\Auth\Domain\Request\Phone\HasPhoneRequest;
use App\Modules\Auth\Domain\Resources\Phone\OrganizationLoginCollection;

class PhoneLoginController
{
    public function __invoke(
        HasPhoneRequest $request,
    ) {

        $validated = $request->validated();

        /** @var PhoneList */
        $phone = PhoneList::where('value', $validated['phone'])->first();

        /** @var User */
        $user = $phone->user;

        $collection = $user->organizations->map(function ($item) {

            //добавляем к каждому объекту коллекции тип кабинета у данного user по phone
            $item->user_role_for_organization = $item->pivot->type_cabinet;

            return $item;
        });


        return $phone ?
            response()->json(array_success(OrganizationLoginCollection::make($collection), 'Successfully return all organization for phone.'), 200)
        :
            response()->json(array_error(null, 'Faild return all organization for phone.'), 401);

    }

}
