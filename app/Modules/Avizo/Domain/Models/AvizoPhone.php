<?php

namespace App\Modules\Avizo\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AvizoPhone extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'avizo_phones';

    // protected static function newFactory()
    // {
    //     return OrganizationFactory::new();
    // }

    protected $fillable = [

        "sender",
        "confirming",

        "status_confirmation",

        "code",
        "code_liftime",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
           'status_confirmation' => 'boolean',
        ];
    }

}
