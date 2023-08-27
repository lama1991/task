<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use App\Http\Resources\MealShortResource;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\ReviewResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadTrait;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    use ApiResponseTrait,UploadTrait;
  
    public function index()
    {
        try{
           
           $restaurants=Restaurant::with('images','user','city')->get();
            $data['restaurants']=RestaurantResource::collection( $restaurants);
            
             return $this->successResponse($data,  true, 'all restaurants are here', 200);
           
         }
         catch (\Exception $ex){
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
         }
    }

  
    public function store(Request $request)
    {
       
      $validator=Validator::make($request->all(),[
        'name'=>'required|string',
        'city_id'=>'required|numeric',
        'cuisine_type'=>'required|string',
        'contact'=>'required|string',
        'address'=>'required|string',
        'images'=>'array',

        ]
    );
            if($validator->fails()){
                return $this->  errorResponse([], false, $validator->errors() , 422);
    }
    try
    {
    $input=$validator->validated();
    $input['user_id']=Auth::id();
    DB::beginTransaction();
    $restaurant=Restaurant::create($input);
    $restaurant['rating']=0.00;
    $restaurant->save();
    if($request->hasFile('images'))
        {
         $files=$request->file('images');
         $paths=$this->uploadMulti($files,'images/restaurants');
         foreach($paths as $path)
         {
            $image=$restaurant->images()->create(['link'=>$path]);
         }
        }
    $data['restaurant']=new RestaurantResource($restaurant);
    DB::commit();
    return $this->successResponse($data,true,'restaurant is created successfully', 201);
    dd($restaurant) ;
    }
    catch (\Exception $ex)
    {
        DB::rollback();
          return $this-> errorResponse([], false,$ex->getMessage() , 500);
    }
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $restaurant=Restaurant::find($id);
           
            if(!$restaurant)

             return $this-> errorResponse([], false,'No product with such id' ,404);
            
            $data=new RestaurantResource($restaurant);
            return $this->successResponse($data,true,'restaurant is retrieved successfully', 200);
          
            
        }
        catch (\Exception $ex){
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */

    // search restaurants by cuisine type
    public function cuisine($cuisine)
    {
        try
        {
       
        $restaurants=Restaurant::where('cuisine_type','LIKE', "%$cuisine%")->get();
        if(empty($restaurants))
             return $this-> errorResponse([], false,'No restaurants have this cuisine type' ,404);
        $data['restaurants']=RestaurantResource::collection( $restaurants);
            
        return $this->successResponse($data,  true, 'all restaurants of the specific cuisine type', 200); 
              
        }
        catch (\Exception $ex){
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }
    
    }
    public function reviews($id)
    {
        try
        {
       
         $restaurant=Restaurant::find($id);
           
        if(!$restaurant)

         return $this-> errorResponse([], false,'No product with such id' ,404);
        $reviews=$restaurant->reviews;
        $data['reviews']=ReviewResource::collection( $reviews);
        return $this->successResponse($data,  true, 'all reviews', 200);      
        }
        catch (\Exception $ex){
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }
    
    }
    public function menue($id)
    {
        try
        {
       
         $restaurant=Restaurant::find($id);
           
        if(!$restaurant)

         return $this-> errorResponse([], false,'No product with such id' ,404);
       
        $meals=$restaurant->meals;
        $data['menue']=MealShortResource::collection($meals);
        return $this->successResponse($data,  true, 'menue is here', 200);      
        }
        catch (\Exception $ex){
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }
    
    }
    public function edit(Restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
}
