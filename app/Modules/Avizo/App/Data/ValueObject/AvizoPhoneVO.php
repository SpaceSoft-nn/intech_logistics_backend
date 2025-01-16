<?php

namespace App\Modules\Avizo\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

use function App\Helpers\code;
use function App\Helpers\uuid;

final readonly class AvizoPhoneVO implements Arrayable
{
    use FilterArrayTrait;

    public string $sender;
    public string $confirming;

    public ?string $code;
    public ?string $code_liftime;

    public ?bool $status_confirmation;

    private function __construct() {}

    public static function make(

        string $sender,
        string $confirming,

        ?string $code_liftime = null,
        ?bool $status_confirmation = false,

    ) : self {

        $code = code();

        if(is_null($code_liftime))
        {
            $code_liftime = now()->addMinutes(15); //учитывать серверное время
        }

       $object = new self();

       $object->sender = $sender;
       $object->confirming = $confirming;
       $object->code = $code;
       $object->code_liftime = $code_liftime;
       $object->status_confirmation = $status_confirmation;

       return $object;

    }


    public function toArray() : array
    {
        return [
            "sender" => $this->sender,
            "confirming" => $this->confirming,
            "code" => $this->code,
            "code_liftime" => $this->code_liftime,
            "status_confirmation" => $this->status_confirmation,
        ];
    }

    public function fromArrayToObject(array $data) : self
    {
        return self::make(
            sender: Arr::get($data, 'sender'),
            confirming: Arr::get($data, 'sender'),
        );
    }
}
