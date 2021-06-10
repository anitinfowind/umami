<?php

namespace App\Http\Middleware;

use Closure;
/**
 * Class SessionTimeout.
 */
class ProductApprove
{
    
    public function handle($request, Closure $next) {
     if(auth()->user()['isApprovedRestaurant'] || auth()->user()->isManager()) {
         return $next($request);
     }

     return redirect()->to('/');
      
   }
}
