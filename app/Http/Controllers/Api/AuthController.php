<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4',
            ]);

        if($validator->fails()){
          return $this->  errorResponse([], false, $validator->errors() , 422);
        }
        try {
          
            $input = $validator->validated();
            $input['uuid']=Str::uuid()->toString();
            $input['password'] = Hash::make($input['password']);
           
            $user = User::create($input);
            $data['user'] = new UserResource($user);

            return $this->successResponse($data,true, 'User is registered successfully.',200);
           
          
        }
        catch (\Exception $ex){
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
            
        }
    }

    public function login(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if($validator->fails()){
            return $this->  errorResponse([], false, $validator->errors() , 422);
        }

try {
    $user = User::where('email', $request['email'])->first();

    if (!$user || !Hash::check($request ['password'], $user->password)) {
        return $this-> errorResponse([], false,'incorrect username or password',400);
    }
    $data['token'] = $user->createToken('apiToken')->plainTextToken;
    $data['user'] = new UserResource($user);
    return $this->successResponse($data,true, 'you logged in successfully.',200);
   


}
        catch(\Exception $ex)
        {
            return $this-> errorResponse([], false,$ex->getMessage() , 500);
        }

    }
    public function logout()
    {
        auth()->user()->CurrentAccesstoken()->delete();
  
        return $this->successResponse([],true, 'you logged out successfully.',200);
       
       
    }
}
