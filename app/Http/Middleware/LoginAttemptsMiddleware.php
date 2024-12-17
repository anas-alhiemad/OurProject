<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LoginAttemptsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $maxAttempts = 3;
    protected $lockoutTime = 300;

    public function handle(Request $request, Closure $next)
    {


        $username = $request->input('email');
        $key = 'login_attempts_' . $username;


        if (Cache::has($key) && Cache::get($key) >= $this->maxAttempts) {
            return response()->json(['message' => 'You have exceeded the maximum number of login attempts. Try again after several minutes.'], 429);
        }

              $response = $next($request);


        if ($response->status() === 401) {
            $attempts = Cache::get($key, 0) + 1;
            Cache::put($key, $attempts, $this->lockoutTime);

                    if ($attempts >= $this->maxAttempts) {
                return response()->json(['message' =>'You have exceeded the maximum number of login attempts. Try again after several minutes.'], 429);
            }
        } else {

            Cache::forget($key);
        }

        return $response;
    }
}
