<?php





namespace App\Http\Middleware;
use Config;
use Closure;
use DB;

class SetDBConnection
{
    public function handle($request, Closure $next)
    {
        if (session('database')) {

            \Config::set('database.connections.mysql.database', session('database'));
            DB::purge('mysql');


        }

        return $next($request);
    }
}