<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
