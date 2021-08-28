<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function findAll($filter, $userId)
    {
        if (empty($filter['periods'])) {
            $periodStartFilter = '';
            $periodEndFilter = '';
        } else {
            $periodStartFilter = "and pos.date >= '{$filter['periods'][0]}'";
            $periodEndFilter = "and pos.date <= '{$filter['periods'][1]}'";
        }

        $personIdFilter = empty($filter['person_id']) ? '': "and pos.person_id = {$filter['person_id']}";

        if (empty($filter['period_id'])) {
            $periodFilter = '';
        } else {
            $period = Period::findOrFail($filter['period_id']);
            $periodFilter = "and pos.date >= '{$period->start_date}' and pos.date <= '{$period->end_date}'";
        }

        $query = "select pos.id, pos.person_id, peo.name, pos.value, pos.date, pos.description
                    from postings pos
                    join people peo on peo.id = pos.person_id
                   where 1 = 1
                     and pos.user_id = $userId
                     $personIdFilter
                     $periodStartFilter
                     $periodEndFilter
                     $periodFilter
                    order by pos.date desc";

        return DB::select($query);
    }

    public function getPersonNameAttribute($value)
    {
        return $this->person->name;
    }
}
