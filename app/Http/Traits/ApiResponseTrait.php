<?php

namespace App\Http\Traits;

trait ApiResponseTrait
{

    public function errorResponse($data =[], bool $status =false, $message , $statusCode)
    {
        $array = [
            'data' => (object)$data,
            'status' => $status,
            'message' =>  $message,
            'statusCode' => $statusCode
        ];
        return response($array);
    }
    public function successResponse($data, bool $status = true, $message, $statusCode = 200)
    {
        $data['message']=$message;
        $array = [
            'data' => $data,
            'status' => $status,
           
            'statusCode' => $statusCode
        ];
        return response($array);
    }



    public function unAuthoriseResponse()
    {
        return $this->apiResponse(null, 0, 'Unauthorized !!', 401);
    }


    public function notFoundMassage($more = null)
    {
        return $this->apiResponse(null, 1, $more . "Not found in our database !", 404);
    }


    public function requiredField($message)
    {
        return $this->apiResponse(null, false, $message, 200);
    }


    public function apiValidation($request, $array)
    {
        foreach ($array as $field) {
            if (!$request->has($field))
                return [false, 'Field ' . $field . ' is required'];

            if ($request[$field] == null)
                return [false, "Field " . $field . " can't be empty"];
        }
        return [true, 'No error'];
    }
}
