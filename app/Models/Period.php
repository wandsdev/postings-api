<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Period
 *
 * @property int $id
 * @property string $start_date
 * @property string $end_date
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PeriodFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Period newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Period query()
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Period whereUserId($value)
 * @mixin \Eloquent
 */
class Period extends Model
{
    use HasFactory;

    protected $hidden   = ['created_at', 'updated_at'];
    public $fillable = ['start_date', 'end_date', 'name'];
}
