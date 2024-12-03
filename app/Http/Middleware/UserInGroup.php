<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserInGroup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $userId = Auth::id();
        // $user = User::find($userId);
        // if ($user && $user->groups()->where('group_id', $groupId)->exists()) {
        return $next($request);
        // } else {
        //     return response('You can\'t use files in this gourp', Response::HTTP_FORBIDDEN);
        // }
    }
}
