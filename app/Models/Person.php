<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Person
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Posting[] $postings
 * @property-read int|null $postings_count
 * @method static \Database\Factories\PersonFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Person newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Person query()
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereUserId($value)
 * @mixin \Eloquent
 */
class Person extends Model
{
    use HasFactory;

    protected $hidden   = ['created_at', 'updated_at'];
    public $fillable = ['name'];

    public function postings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Posting::class);
    }
}
