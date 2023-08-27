<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealShortResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        
        $validator=Validator::make($request->all(),[
            'restaurant_id'=>'required|numeric',
            'name'=>'required|string',
            'price'=>'required'
    
            ]
        );
                if($validator->fails()){
                    return $this->  errorResponse([], false, $validator->errors() , 422);
        }
    
       
    
      try {
      
         $input=$validator->validated();
  
        $meal=Meal::create($input);
         $data['meal']=new MealShortResource($meal);
         return $this->successResponse($data,true,'review is created successfully', 201);
          
        }
        catch (\Exception $ex)
        {
              return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
