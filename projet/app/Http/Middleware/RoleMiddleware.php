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
    public function handle(Request $request, Closure $next, ...$roles)
    {
        //si l'user pas connecter
        if(!Auth::check()) {
            return redirect('/login');
        }
        $user = Auth::user();

        // 2. CAS SPÉCIAL : Si je suis ADMIN, je passe partout !
         if ($user->role === 'admin') {
            return $next($request);
        }
        // 3. CAS NORMAL : Est-ce que mon rôle est dans la liste autorisée ?
         if (in_array($user->role, $roles)) {
            return $next($request);
        }


          // 4. Sinon, dehors !
        abort(403, "ACCÈS INTERDIT : Vous n'avez pas le bon rôle.");
    }
}
