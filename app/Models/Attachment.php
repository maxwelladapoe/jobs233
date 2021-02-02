<?php

namespace App\Models;

use App\Http\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Attachment extends Model
{
    use HasFactory;
    use UsesUUID;

    protected $hidden=[
        'original_file_location',
        'is_water_marked'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function status_update()
    {
        return $this->belongsTo(ProjectStatusUpdate::class);
    }

}
