<?php
namespace App\Modules\Base\Error;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class BusinessException extends \Exception
{
    /**
    * @var string
    */
    private $messageCustom;

    /**
    * @var int
    */
    private ?int $codeCustom;

    public function __construct(string $messageCustom, $codeCustom = 400)
    {
        $this->messageCustom = $messageCustom;
        $this->codeCustom = $codeCustom;
        parent::__construct("Business exception", $this->codeCustom);
    }

    public function getCustomMessage(): string
    {
        return $this->messageCustom;
    }

    public function getCustomCode(): string
    {
        return $this->messageCustom;
    }


    public function render(Request $request)
    {
        //Проверяем что запросы был по апи json
        if(request()->expectsJson() || request()->isJson())
        {
            $json = [
                'success' => false,
                'error' => $this->getCustomMessage(),
            ];

            return response()->json($json, $this->getCode());
        }
    }
}
