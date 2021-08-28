<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $hidden   = ['created_at', 'updated_at'];
    public $fillable = ['start_date', 'end_date', 'name'];
}
