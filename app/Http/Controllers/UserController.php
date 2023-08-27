<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function assignRoles(Request $request)
    {
            
      $validator=Validator::make($request->all(),[
        'uuid'=>'required|string',
        'role_id'=>'required|array',
        ]
    );
            if($validator->fails()){
                return $this->  errorResponse([], false, $validator->errors() , 422);
    }
    try
    {
    $input=$validator->validated();
    $user=User::where('uuid',$request['uuid'])->first();
    if(!$user)
    {
     return $this-> errorResponse([], false,'No user with such uuid' ,404);
    }
    $user->roles()->attach($request['role_id']);
    
    $data['user']=new UserResource( $user);
    
    return $this->successResponse($data,true,'roles were attached succefully', 201);
   
    }
    catch (\Exception $ex)
    {
       
          return $this-> errorResponse([], false,$ex->getMessage() , 500);
    }
    }
    public function updateRoles(Request $request)
    {
            
      $validator=Validator::make($request->all(),[
        'uuid'=>'required|string',
        'role_id'=>'required|array',
        ]
    );
            if($validator->fails()){
                return $this->  errorResponse([], false, $validator->errors() , 422);
    }
    try
    {
    $input=$validator->validated();
    $user=User::where('uuid',$request['uuid'])->first();
    if(!$user)
    {
     return $this-> errorResponse([], false,'No user with such uuid' ,404);
    }
    $user->roles()->sync($request['role_id']);
    
    $data['user']=new UserResource( $user);
    
    return $this->successResponse($data,true,'roles were updated succefully', 201);
   
    }
    catch (\Exception $ex)
    {
       
          return $this-> errorResponse([], false,$ex->getMessage() , 500);
    }
    }
}
