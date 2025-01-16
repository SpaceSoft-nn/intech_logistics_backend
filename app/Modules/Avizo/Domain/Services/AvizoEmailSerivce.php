<?php

namespace App\Modules\Avizo\Domain\Services;

use DB;
use App\Modules\Avizo\Domain\Models\AvizoEmail;
use App\Modules\Avizo\App\Data\ValueObject\AvizoEmailVO;
use App\Modules\Avizo\Domain\Actions\CreateAvizoEmailAction;
use App\Modules\Avizo\Domain\Async\jobs\SendAvizoEmailJob;
use App\Modules\Base\Error\BusinessException;
use Carbon\Carbon;

class AvizoEmailSerivce
{
    //инициация создание и отправки ссылки для подтврждения на email
    public function createAvizoEmail(AvizoEmailVO $vo) : AvizoEmail
    {

        /** @var AvizoEmail */
        $model = DB::transaction(function ($pdo) use ($vo) {

            /** @var AvizoEmail */
            $model = CreateAvizoEmailAction::make($vo);


            // SendAvizoEmailJob::dispatch($model)->afterCommit();  #TODO Проверить отправку

            return $model;

        });

        return $model;

    }

    public function confirmation(AvizoEmail $avizoEmail) : bool
    {
        $liftimeDate = Carbon::parse($avizoEmail->url_liftime);

        //проверяем истекло ли время
        if($liftimeDate->isPast())
        {
            throw new BusinessException('Срок действия ссылки истек.', 400);
        }

        //ставим true - что пользователь подтвердил по ссылке авизацию
        $avizoEmail->status_confirmation = true;
        $avizoEmail->save();

        return true;
    }


}
