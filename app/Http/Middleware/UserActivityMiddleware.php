<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserActivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $oldData = null;
        if ($request->path() === 'api/user/group/updateGroup') {
            $oldData = DB::table('groups')->where('id', $request->route('id'))->first();
        }
        $response = $next($request);
        return $next($request);
        $newData = $request->all();
        DB::table('logs')->insert([
            'action' =>  $request->path(),
            'old_data' => $oldData ? json_encode($oldData) : null,
            'new_data' => $newData ? json_encode($newData) : null,
            'performed_by' => Auth::guard('users')->id(),
            'timeUse' => now(),
        ]);
        return $response;
    }
}
