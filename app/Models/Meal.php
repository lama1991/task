<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Meal extends Model
{
    use HasFactory;
    protected $fillable=['name','price','restaurant_id'];
    
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity')
        ->using(MealOrder::class);
    }
}
