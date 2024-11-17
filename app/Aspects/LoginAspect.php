<?php

namespace App\Aspects;

use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;
use ReflectionFunction;
use Validator;

class LoginAspect
{
    protected $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function around($joinPoint)
    {
        Log::info("Hi");
        $validator = Validator::make($joinPoint->all(),$joinPoint->rules());
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);}
        return $validator;
    }
}
