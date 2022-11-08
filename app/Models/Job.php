<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class);
    }
}
