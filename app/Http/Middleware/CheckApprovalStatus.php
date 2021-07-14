<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
Use Redirect;
use Response;
use Carbon\Carbon;


class CheckApprovalStatus
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
        $response = $next($request);

        //If the status is not approved redirect to not approved parent page
        if(Auth::check() ) {

            $age = (Carbon::parse (Auth::user()->dob)->age);

            if ( Auth::user()->isapproved_byparent <> 1 && $age<=13 ){
             $age = (Carbon::parse (Auth::user()->dob)->age);
             Auth::logout();
            // return Response::make(view());


        }

        }
        return $response;

    }
}
