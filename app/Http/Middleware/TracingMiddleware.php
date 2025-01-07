<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class TracingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        Log::channel('http')->info('======== START REQUEST ======');
        Log::channel('http')->info('Request Captured', [
            'IP Address' => $request->ip(),
            'URL' => $request->path(),
            'Host' => $request->host(),
            'Method' => $request->method(),
            'User' => $user ? $user->email : 'Guest',
            'Token' => $request->bearerToken(),
            'Inputs' => $request->all(),
        ]);

        Log::channel('http')->info('============= END REQUEST =========');

        $response = $next($request);
        Log::channel('http')->info('Response Caught', [
           
            'Content' => json_decode($response->getContent(), true),
        ]);
        
        return $response;
    }

    
}
