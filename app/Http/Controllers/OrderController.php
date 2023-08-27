<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\MealOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ApiResponseTrait;
 
    public function store(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'status'=>'in:delivery,pickup',
            'meal_id'=>'required|array',
            'meal_id.*' => 'integer',
            'quantity'=>'required|array',
            'quantity.*' => 'integer',
            
        ]);
        if($validator->fails()){
            return $this->  errorResponse([], false, $validator->errors() , 422);
        }

        try {
            DB::beginTransaction();
            $order=Order::create(['user_id'=>auth()->user()->id,'status'=>$request['status']]);
            $meals=$request['meal_id'];
            $quantities=$request['quantity'];
            if(count($meals)!=count($quantities))
             return $this->errorResponse([], false,'not equal arrays' , 404);
             
          
            for($i=0;$i<count($meals);$i++)
            {
               //$order_items= MealOrder::create(['order_id'=>$order->id,'meal_id'=>$meals[$i],'quantity'=>$quantities[$i]]);
               
                $order->meals()->attach($meals[$i],['quantity'=>$quantities[$i]]);
            }

           $total=0;
           foreach($order->meals as $meal)
           {
            $total+=$meal->price*$meal->pivot->quantity;
           }
           $order->update(['total'=>$total]);
            $data['order']= new OrderResource($order);
            DB::commit();
           return  $this->successResponse($data, true,'you have added the order succefully',201);
          
         
          }

        catch (\Exception $ex)
        {
            DB::rollback();
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }
    }

 
    public function show(Order $order)
    {
        
    }

   

    public function update(Request $request, $id)
    {
        $validator =Validator::make($request->all(),[
            'status'=>'in:delivery,pickup',
            'meal_id'=>'required|array',
            'meal_id.*' => 'integer',
            'quantity'=>'required|array',
            'quantity.*' => 'integer',
            
        ]);
        if($validator->fails()){
            return $this->  errorResponse([], false, $validator->errors() , 422);
        }

        try {
            DB::beginTransaction();
            $order=Order::find($id);
            if(!$order)
            {
             return $this-> errorResponse([], false,'No order with such id' ,404);
            }
            $order->update(['status'=>$request['status']]);
            $meals=$request['meal_id'];
            $quantities=$request['quantity'];
            if(count($meals)!=count($quantities))
             return $this->errorResponse([], false,'not equal arrays' , 404);
            MealOrder::where('order_id',$id)->delete();
            $total=0;
             for($i=0;$i<count($meals);$i++)
             {
                $pivot=MealOrder::create(['order_id'=>$id,'meal_id'=>$meals[$i],'quantity'=>$quantities[$i]]);
                $total+=$pivot->meal->price*$pivot->quantity;
             }
            $order->update(['total'=>$total]);
           $data= new OrderResource($order);
            DB::commit();
           return  $this->successResponse($data, true,'you have added the order succefully',201);
          return $order;
         
          }

        catch (\Exception $ex)
        {
            DB::rollback();
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }
        
    }
// another way to perform update order
/*
    public function update(Request $request, $id)
    {
        $validator =Validator::make($request->all(),[
            'status'=>'in:delivery,pickup',
            'meal_id'=>'required|array',
            'meal_id.*' => 'integer',
            'quantity'=>'required|array',
            'quantity.*' => 'integer',
            
        ]);
        if($validator->fails()){
            return $this->  errorResponse([], false, $validator->errors() , 422);
        }

        try {
            DB::beginTransaction();
            $order=Order::find($id);
            $order->update(['status'=>$request['status']]);
            $meals=$request['meal_id'];
            $quantities=$request['quantity'];
            if(count($meals)!=count($quantities))
             return $this->errorResponse([], false,'not equal arrays' , 404);
            // preapear the array for sync
             for($i=0;$i<count($meals);$i++)
             {
                 $pivot_data[]=['quantity'=>$quantities[$i]];
             }
         $sync_data=array_combine($meals, $pivot_data);
         $order->meals()->sync( $sync_data);
       
          
          
            $data= new OrderResource($order);
            DB::commit();
           return  $this->successResponse($data, true,'you have added the order succefully',201);
          
         
          }

        catch (\Exception $ex)
        {
            DB::rollback();
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }
        
    }*/
// the authenticated user's orders
public function userOrders()
{
    try
    {
   
        $orders=Auth::user()->orders;
        $data['orders']=OrderResource::collection( $orders);
        return $this->successResponse($data,  true, 'all orders of you', 200); 
          
    }
    catch (\Exception $ex){
        return $this-> errorResponse([], false,$ex->getMessage() , 500);
    }
}

    
}
