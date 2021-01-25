<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Traits\CanPay;
use Bavix\Wallet\Traits\CanPayFloat;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;


class User extends Authenticatable implements Customer,MustVerifyEmail
{
    use HasFactory, Notifiable, Searchable, CanPayFloat, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'is_online',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $with = ['profile', 'wallet', 'skills'];
    protected $withCount = ['projects','assigned_projects_to_worker', 'my_assigned_projects', 'completedProjects','completed_assigned_projects'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function profile()
    {

        return $this->hasOne(Profile::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function completedProjects()
    {
        return $this->hasMany(Project::class)->where('status','completed');
    }
    public function project_payments()
    {
        return $this->hasMany(ProjectPayment::class);
    }

    public function assigned_projects_to_worker()
    {
        return $this->hasMany(Project::class, 'user_id')->whereNotIn('status', ['completed', 'new']);
    }
 public function my_assigned_projects()
    {
        return $this->hasMany(Project::class, 'worker_id')->whereNotIn('status', ['completed', 'new']);
    }

    public function completed_assigned_projects()
    {
        return $this->hasMany(Project::class, 'worker_id')->where('status','completed');
    }


    public function portfolio()
    {
        return $this->hasMany(PortfolioItem::class, 'user_id');
    }


    public function chatContacts()
    {
        return $this->hasMany(ChatContact::class);
    }

    public function relatedChatContacts()
    {
        return $this->hasMany(ChatContact::class, 'related_user_id');
    }

    public function allChatContacts()
    {
        return $this->chatContacts->merge($this->relatedChatContacts());
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function preferences()
    {
        return $this->hasOne(Preference::class);
    }

    public function toSearchableArray()
    {
        $array = [

            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
        ];

        // Customize array...

        return $array;
    }

//the skills function is primary accessed through the pivot table UserSkill
    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }


}
