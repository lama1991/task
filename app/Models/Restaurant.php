<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'city_id','user_id','contact','address','cuisine_type','rating'];
   
   
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
