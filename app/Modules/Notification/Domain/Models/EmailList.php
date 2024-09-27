<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class EmailList extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'email_list';

    protected $fillable = ['value'];

    // public function newUniqueId(): string
    // {
    //     return (string) Uuid::uuid4();
    // }
}
