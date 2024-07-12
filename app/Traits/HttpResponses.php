<?php

namespace App\Traits;
use Illuminate\Support\MessageBag;

trait HttpResponses{
    public function response(string|int $code, string $message = "", $data = []){
        return response()->json(["code"=> $code,"message"=> $message,"data"=> $data], $code); 
    }
    
    public function error(string|int $code, string $message = "", array|MessageBag $errors = [], $data = []){
        return response()->json(["code"=> $code,"message"=> $message, "errors" => $errors, "data"=> $data], $code); 
    }
    
}