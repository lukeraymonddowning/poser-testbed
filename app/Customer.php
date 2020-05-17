<?php

namespace App;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function snake_case_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
