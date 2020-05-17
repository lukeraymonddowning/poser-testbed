<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public function users()
    {
        return $this->morphedByMany(User::class, 'taggable');
    }

    public function customers()
    {
        return $this->morphedByMany(Customer::class, 'taggable');
    }

}
