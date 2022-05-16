<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CheckUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission): Response|RedirectResponse|JsonResponse
    {
        if(Auth::user()->hasPermission($permission)) {
            return $next($request);
        } else {
            if (Auth::user()->posts->where('id', $request->segment(2))->count() !== 0 && $permission !== 'Approved Posts') {
                return $next($request);
            }
            abort(ResponseAlias::HTTP_FORBIDDEN);
        }
    }
}
