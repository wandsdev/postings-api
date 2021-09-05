<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Posting
 *
 * @property int $id
 * @property float $value
 * @property string $date
 * @property string $description
 * @property int $person_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $person_name
 * @property-read \App\Models\Person $person
 * @method static \Database\Factories\PostingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Posting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Posting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Posting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Posting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posting whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posting wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Posting whereValue($value)
 * @mixin \Eloquent
 */
class Posting extends Model
{
    use HasFactory;

    protected $hidden   = ['created_at', 'updated_at', 'id'];
    public $fillable = ['person_id', 'value', 'date', 'description'];
    public $appends = ['person_name'];

    public function person(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function getPersonNameAttribute($value)
    {
        return $this->person->name;
    }
}
