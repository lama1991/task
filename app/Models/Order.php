<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;
    
    protected $fillable=['user_id','status','total'];
    protected $appends = ['restaurant_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function meals()
    {
        return $this->belongsToMany(Meal::class)->withPivot('quantity')
        ->using(MealOrder::class);
    }
 // get the restauranr_id from which the order was .. suppose the order is from one restaurant
  public function getRestaurantIdAttribute()
  {
     return $this->meals()->first()->restaurant->id;
  }
}
