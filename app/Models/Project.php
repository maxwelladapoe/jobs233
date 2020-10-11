<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $with = ['user', 'currency', 'category', 'subcategory', 'attachments'];
    protected $withCount = ['bids'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ProjectSubCategory::class, 'secondary_category_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

}
