<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $with=['subCategories'];

    public function subCategories(){
        return $this->hasMany(ProjectSubCategory::class);
    }

}
