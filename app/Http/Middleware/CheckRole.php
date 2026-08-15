<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($role === 'admin' && !$user->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($role === 'wali_nagari' && !$user->isWaliNagari() && !$user->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($role === 'news_editor' && !$user->isNewsEditor()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
