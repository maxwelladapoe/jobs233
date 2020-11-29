<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkills extends Model
{
    use HasFactory;


    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
