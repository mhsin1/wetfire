<?php

namespace App\Models;

use Session;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'product_id',
        'free_product_id',
        'discount',
        'type',
        'discount_q',
        'quantity',
        'is_feature',
        'status',
        'start_date',
        'end_date'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }

    public function free()
    {
        return $this->belongsTo('App\Models\Product','free_product_id');
    }

    public function showPrice()
    {
        $price = $this->product->price;
        $type = $this->type;
        if($type == 1){
            $discount = $this->discount;
            $discounted_price = $this->discount/100 * $price;
            $price = $price - $discounted_price;
        }
        if($type == 2){
            $price = $price * $this->quantity; 
            $discounted_price = $this->discount_q/100 * $price;
            $price = $price - $discounted_price;  
        }

        if (Session::has('currency')){
            $curr = Currency::find(Session::get('currency'));
        }
        else{
            $curr = Currency::where('is_default','=',1)->first();
        }

        $price = round(($price) * $curr->value,2);
        $gs = Generalsetting::findOrFail(1);        
        if($gs->currency_format == 0){
            return $curr->sign.$price;
        }
        else{
            return $price.$curr->sign;
        }
    }
}
