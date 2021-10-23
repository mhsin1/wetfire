<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Childcategory extends Model
{
    protected $fillable = ['subcategory_id','name','slug','sequence'];
    public $timestamps = false;

    public function subcategory()
    {
    	return $this->belongsTo('App\Models\Subcategory')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }

    public function subchilds()
    {
    	return $this->hasMany('App\Models\Subchildcategory')->where('status','=',1)->orderBy('sequence', 'ASC');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_replace(' ', '-', $value);
    }

    public function attributes() {
        return $this->morphMany('App\Models\Attribute', 'attributable');
    }
}
