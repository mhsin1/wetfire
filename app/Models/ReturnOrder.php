<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    protected $fillable = ['order_id','user_id','reason','details','images'];

    public function user()
    {
    	return $this->belongsTo('App\Models\User')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }

}
