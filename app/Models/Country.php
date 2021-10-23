<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['country_code','country_phone' , 'country_name' , 'image' , 'status'];

}
