<?php

namespace App\Http\Middleware;

use Closure;
use App\Urls;
use Carbon\Carbon;

class Expires
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {    
        $url = Urls::where('uuid', $request->route('uuid'))->first();
        $url_date = Carbon::parse($url->created_at)->timestamp;
        $now = Carbon::now()->timestamp;


        if($now - $url_date > 1800){
            
            return redirect('expired');
        } 

        return $next($request);
    }
}
