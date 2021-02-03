<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use HasFactory, Searchable;
    use \App\Http\Traits\UsesUUID;


    protected $with = ['user', 'currency', 'category', 'subcategory', 'attachments', 'acceptedBid'];
    protected $withCount = ['bids'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function worker()
    {
        return $this->belongsTo(User::class,'worker_id');
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

    public function acceptedBid()
    {
        return $this->hasMany(Bid::class)->where('is_accepted',true);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
    public function statusUpdates()
    {
        return $this->hasMany(ProjectStatusUpdate::class);
    }

    public function toSearchableArray()
    {
        $array = [

            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'skills' => $this->skills,
            'tags' => $this->tags,
        ];

        // Customize array...

        return $array;
    }

}
