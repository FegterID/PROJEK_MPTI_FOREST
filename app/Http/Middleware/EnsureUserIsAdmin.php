<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Setara requireAdmin() pada includes/auth.php lama.
 * requireLogin() lama sudah tercakup middleware bawaan Laravel: 'auth'.
 * Middleware ini dipasang setelah 'auth', jadi saat sampai sini user
 * dipastikan sudah login lewat guard 'web'.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
