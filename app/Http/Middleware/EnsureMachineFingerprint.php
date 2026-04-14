<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\MachineFingerprint;

class EnsureMachineFingerprint
{
    public function handle(Request $request, Closure $next)
    {
        $expected = env('APP_MACHINE_FINGERPRINT');

        // لو مفيش بصمة مسجلة، اقفل التطبيق
        if (!$expected) {
            abort(403, 'Application is not licensed for this machine.');
        }

        $current = MachineFingerprint::current();

        if (!hash_equals($expected, $current)) {
            abort(403, 'This application is licensed for another machine.');
        }

        return $next($request);
    }
}