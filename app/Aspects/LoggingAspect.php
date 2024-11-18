<?php

namespace App\Aspects;

use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;
use ReflectionFunction;

class LoggingAspect
{
    protected $agent;

    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    public function around($joinPoint)
    {
        $reflection = new ReflectionFunction($joinPoint);
        $className = $reflection->getClosureScopeClass()->getName();
        $methodName = $reflection->getName();
        $parameters = $reflection->getParameters();
        $arguments = $this->getArguments($parameters, $joinPoint);

        Log::info("Calling method in class '{$className}' with arguments: " . json_encode($arguments));

        $result = $joinPoint();

        Log::info("Method '{$className}::{$methodName}' returned: " . json_encode($result));

        return $result;
    }

    protected function getArguments($parameters, $joinPoint)
    {
        $arguments = [];
        foreach ($parameters as $parameter) {
            $arguments[] = $joinPoint->{$parameter->getName()};
        }
        return $arguments;
    }
}
