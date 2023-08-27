<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class MealOrder extends Pivot
{
    use HasFactory;
    protected $table = 'meal_order';
    public $incrementing = true;
    protected $fillable=['order_id','meal_id','quantity'];
   
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
