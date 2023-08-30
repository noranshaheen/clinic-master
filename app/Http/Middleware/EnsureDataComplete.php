<?php

namespace App\Http\Middleware;

use App\Models\Clinic;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDataComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if 
        (
            $request->route()->getName() === 'setup.demo.step1' ||
            $request->route()->getName() === 'setup.demo.step2' ||
            $request->route()->getName() === 'setup.actual.step2' ||
            $request->route()->getName() === 'setup.actual.step2'
        )   
        {
            return $next($request);
        }

        $clinics = Clinic::all()->count();
        if($clinics == 0){
            return redirect()->route('setup');
        }else{
            return $next($request);
        }


        // return $next($request);
    }
}
