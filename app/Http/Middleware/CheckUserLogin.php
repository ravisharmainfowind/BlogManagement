<?php

namespace App\Http\Middleware;

use Closure, Session, Redirect;

class CheckUserLogin {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $sessionArray = Session::get('user');
        //$request->session()->has('users')
        
        //$segment = $request->segment('1');

        if (empty($sessionArray['id'])) {
     
            return redirect("/login");
        }
       
        return $next($request);
    }
}
