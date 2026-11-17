<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Sesi berakhir. Silakan login kembali.'], 401);
            }
            return redirect()->guest(route('admin.login'));
        }

        if (! $user->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}