<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Config;

class LanguageTranslator
{
    /**
     * Handle an incoming request.
     *
     * param  \Illuminate\Http\Request  $request
     * param  \Closure  $next
     * return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Session::has('local')){
            $lang=session('local');
        } else {
            $lang="en";
        }
        Config::set('languageTranslator', $lang);
        return $next($request);
    }
}
