<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
   use ApiResponseTrait;
   
    public function index()
    {
        //
    }

 
    public function create()
    {
      
    }
 //there is an observer that update the restaurant rating column after a review has been created 
    public function store(Request $request)
    {
      
       
        $validator=Validator::make($request->all(),[
        'restaurant_id'=>'required|numeric',
        'stars'=>'required|numeric',
        'comment'=>'string'

        ]
    );
            if($validator->fails()){
                return $this->  errorResponse([], false, $validator->errors() , 422);
    }

    //authenticated user can only make a review for restaurants that he ordered from
     $restaurants=Auth::user()->orders()->get()->pluck('restaurant_id')->toArray();
    if(!in_array($request['restaurant_id'],$restaurants))
    return $this-> errorResponse([], false, 'you did not order from this restaurant' , 422);

  try {
  
     $input=$validator->validated();
    $input['user_id']=Auth::id();
    $review=Review::create($input);
     $data['review']=new ReviewResource($review);
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
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
