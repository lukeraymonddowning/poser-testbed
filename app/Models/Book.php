<?php

namespace App\Models;

use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
