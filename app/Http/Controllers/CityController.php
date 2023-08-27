<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use ApiResponseTrait;
   // get all restaurants of a city
   public function restaurantsOf($id)
   {
    try
    {
       $city=City::find($id);
       if(!$city)
       {
        return $this-> errorResponse([], false,'No city with such id' ,404);
       }
       $restaurants=$city->restaurants;
       $data['restaurants']=RestaurantResource::collection( $restaurants);
            
       return $this->successResponse($data,  true, 'all restaurants of this city', 200);
       
          
    }
    catch (\Exception $ex){
        return $this-> errorResponse([], false,$ex->getMessage() , 500);
    }

            
   }
    
   public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
