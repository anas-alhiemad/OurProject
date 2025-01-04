<?php

namespace App\Http\Middleware;

use App\Models\FileOperation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogOperations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $operation = explode('/', $request->path())[2];
        if ($operation == "delete" || $operation == "update") {
            $fileId = $request->route()->parameters()["file"]->id;
            FileOperation::create(['file_id' => $fileId, 'operation' => $operation, 'user_id' => auth()->user()->id]);
        } else if ($operation == "get") {
        } else {
            $files = $request->input('file_ids', []);
            if (is_array($files)) {
                foreach ($files as $file) {
                    FileOperation::create(['file_id' => $file, 'operation' => $operation, 'user_id' => auth()->user()->id]);
                }
            }
        }
        return $next($request);
    }
}
