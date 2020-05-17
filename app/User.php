<?php

namespace App;

use App\Events\LogEventFired;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $dispatchesEvents = [
        'creating' => LogEventFired::class,
        'created' => LogEventFired::class,
        'saving' => LogEventFired::class,
        'saved' => LogEventFired::class
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function dogs()
    {
        return $this->hasMany(Dog::class, 'owner_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function snake_case_customers()
    {
        return $this->hasMany(Customer::class, 'user_id');
    }
}
