<?php

namespace App\Modules\Avizo\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

use function App\Helpers\uuid;

final readonly class AvizoEmailVO implements Arrayable
{
    use FilterArrayTrait;

    public string $sender;
    public string $confirming;

    public string $url; #TODO - это не правильно, нужно создавать доп таблицу подтверждения
    public string $uuid;

    public ?string $url_liftime;

    public ?bool $status_confirmation;

    private function __construct() {}

    public static function make(

        string $sender,
        string $confirming,

        ?string $url_liftime = null,
        ?bool $status_confirmation = false,

    ) : self {


        $uuid = uuid();
        $url = '/avizos/emails/' . $uuid . '/confirm';

        if(is_null($url_liftime))
        {
            $url_liftime = now()->addMinutes(15); //учитывать серверное время
        }

       $object = new self();


       $object->sender = $sender;
       $object->confirming = $confirming;
       $object->url = $url;
       $object->uuid = $uuid;
       $object->url_liftime = $url_liftime;
       $object->status_confirmation = $status_confirmation;

       return $object;
    }


    public function toArray() : array
    {
        return [
            "sender" => $this->sender,
            "confirming" => $this->confirming,
            "url" => $this->url,
            "uuid" => $this->uuid,
            "url_liftime" => $this->url_liftime,
            "status_confirmation" => $this->status_confirmation,
        ];
    }

    public static function fromArrayToObject(array $data) : self
    {
        return self::make(
            sender: Arr::get($data, 'email_sender'),
            confirming: Arr::get($data, 'email_confirmation'),
        );
    }
}
