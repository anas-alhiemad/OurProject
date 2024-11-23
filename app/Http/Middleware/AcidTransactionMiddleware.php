<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class AcidTransactionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        DB::beginTransaction();

        try {
        
        $response = $next($request);
        
        if(isset($response->exception)){
        
        throw $response->exception;
        
        }
        
        DB::commit();
        
        return $response;
        
        }  catch(QueryException $e)
        {
            DB::rollBack();
            return $e;
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
            }
}
