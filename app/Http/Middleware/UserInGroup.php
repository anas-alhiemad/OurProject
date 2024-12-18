<?php

namespace App\Http\Middleware;

use App\Models\File;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $fileIds = $request->input('file_ids');
        $userId = Auth::id();
        $user = User::find($userId);
        foreach ($fileIds as $fileId) {
            $file = File::find($fileId);
            if (
                $file && $user   &&
                DB::table('user_groups')
                ->join('files', 'user_groups.groupId', '=', 'files.group_id')
                ->where('user_groups.userId', $userId)->where('files.id', $fileId)->exists()
            ) {
                return $next($request);
            }
        }
        return response(["message" => 'You can\'t use files in this gourp', 'data' => null], Response::HTTP_FORBIDDEN);
    }
}
