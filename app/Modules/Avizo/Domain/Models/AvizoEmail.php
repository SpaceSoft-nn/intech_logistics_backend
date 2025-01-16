<?php

namespace App\Modules\Avizo\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class AvizoEmail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'avizo_emails';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

    protected $fillable = [


        "sender",
        "confirming",

        "status_confirmation",

        "url",
        "url_liftime",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'status_confirmation' => 'bolean',
        ];
    }

}
