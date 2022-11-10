<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }
}
