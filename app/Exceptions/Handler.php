<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // keep any existing registrations...

        $this->renderable(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 403) {

                // If AJAX/JSON request -> return JSON 401 (so front-end can handle)
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Session expired or unauthorized. Please log in.'
                    ], 401);
                }

                // Make sure to logout & invalidate old session (defensive)
                try {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                } catch (Throwable $ex) {
                    // ignore
                }

                // Redirect to named login route (adjust name if different)
                return redirect()->route('login')->with('message', 'Session expired — please log in again.');
            }
        });
    }
}
