<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
    protected $with = ['profile'];
    protected $withCount = ['projects'];

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

    public function assigned_projects()
    {
        return $this->hasMany(Project::class, 'worker_id');
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







}
