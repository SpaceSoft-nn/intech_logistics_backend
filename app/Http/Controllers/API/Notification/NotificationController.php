<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\Domain\Requests\ConfirmCodeRequest;
use App\Modules\Notification\Domain\Requests\SendNotificationRequest;
use App\Modules\Notification\Domain\Services\Notification\NotificationService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class NotificationController extends Controller
{

    public function __construct(public NotificationService $notifyService)
    {}


    public function sendNotification(SendNotificationRequest $request)
    {
        $validated = $request->validated();

        #TODO Продумать логику по другому
        switch($validated['type'])
        {
            case 'phone':
            {
                $array = $this->notifyService->runNotification(
                    SendNotificationDTO::make('aero', $validated['phone'])
                );
                break;
            }

            case 'email':
            {
                $array = $this->notifyService->runNotification(
                    SendNotificationDTO::make('smtp', $validated['email'])
                );
                break;
            }
        }

        return $array['status'] ?
            response()->json(array_success($array, 'Send notification.'), 200)
        :
            response()->json(array_error($array, 'Faild send notification.'), 400);
    }

    public function confirmCode(ConfirmCodeRequest $request)
    {
        $validated = $request->validated();

        $array = $this->notifyService->confirmNotification(
            ConfirmDTO::make(
                code: $validated['code'],
                type: $validated['type'],
                uuid: $validated['uuid_send'],
            )
        );

        return $array['status'] ?
            response()->json(array_success($array, 'Confirm code.'), 200)
        :
            response()->json(array_error($array, 'Faild confirm code.'), 400);
    }
}
