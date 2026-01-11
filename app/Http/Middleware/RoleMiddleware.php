<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        //si l'user pas connecter
        if(!Auth::check()) {
            return redirect('/login');
        }
        $userRole = Auth::user()->role;

        if($role == 'admin' && $userRole != 'admin') {
            abort(403, "Accès interdit ! Réservé aux administrateurs.");
        }
        if($role == 'responsable' &&  !in_array($userRole, ['admin', 'responsable'])) {
            abort(403, "Accès interdit ! Réservé aux responsables.");
        }


        return $next($request);
    }
}
