<?php

namespace App\Modules\Avizo\Domain\Services;

use DB;
use App\Modules\Avizo\App\Data\ValueObject\AvizoPhoneVO;
use App\Modules\Avizo\Domain\Actions\CreateAvizoPhoneAction;
use App\Modules\Avizo\Domain\Models\AvizoPhone;
use App\Modules\Base\Error\BusinessException;
use Carbon\Carbon;

class AvizoPhoneService
{
    //инициация создание и отправки кода на смс
    public function createAvizoPhone(AvizoPhoneVO $vo) : AvizoPhone
    {

        /** @var AvizoPhone */
        $model = DB::transaction(function ($pdo) use ($vo) {

            /** @var AvizoPhone */
            $model = CreateAvizoPhoneAction::make($vo);

            #TODO Логика отправки смс сообщения
            // SendAvizoEmailJob::dispatch($model)->afterCommit();  #TODO Проверить отправку

            return $model;

        });

        return $model;

    }

    public function confirmation(AvizoPhone $avizoPhone) : bool
    {
        $liftimeDate = Carbon::parse($avizoPhone->code_liftime);

        //проверяем истекло ли время
        if($liftimeDate->isPast())
        {
            throw new BusinessException('Срок действия кода истек.', 400);
        }

        //ставим true - что пользователь подтвердил по коду авизацию
        $avizoPhone->status_confirmation = true;
        $avizoPhone->save();

        return true;
    }


}
