<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'sign', 'value', 'country_id'];
    public $timestamps = false;
}
