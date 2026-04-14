<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Auth;
use App\Support\MachineFingerprint;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate; // Import the Gate facade
use Carbon\Carbon;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        attemptLogin as baseAttemptLogin;
    }

    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        
        if (Auth::user()->team_id == 1 || Auth::user()->team_id == 11 || Auth::user()->team_id == 13 || Auth::user()->team_id == 2 || Auth::user()->team_id == 8) {
            return RouteServiceProvider::HOME;
        } else {
            return RouteServiceProvider::HOME2;
        }
    }

  
    protected function attemptLogin(Request $request)
    {
     
        config(['database.connections.mysql.database' => $request->database]);
        
        return $this->baseAttemptLogin($request);
    }

    protected function authenticated(Request $request, $user)
    {
                // $startDate = Carbon::create(2024, 4, 15);
                // $endDate = Carbon::create(2025, 6, 1);
                // $currentDate = Carbon::now();
        
                // if ($currentDate->lt($startDate) || $currentDate->gte($endDate)) {
                //     // If current date is outside the allowed period, log the user out
                //     Auth::logout();
                //     return redirect()->route('login')->with('error', ' Please Call With (  ERP Developer team ) ');
                // }

        $expected = env('APP_MACHINE_FINGERPRINT');
        $current = MachineFingerprint::current();

        if (!$expected || !hash_equals($expected, $current)) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');

        }        

        session(['database' => $request->database]);
    }



    public function username()
    {
        return 'username';
    }

    protected function sendFailedLoginResponse(Request $request)
{
    // Set your custom error message
    $message = ' .يرجى التأكد من اسم المستخدم وكلمة المرور';

    // Check if the request expects a JSON response
    if ($request->expectsJson()) {
        throw new HttpResponseException(response()->json([
            'message' => $message
        ], 422));
    }

    // For non-JSON responses (like regular form submissions)
    return redirect()->back()
        ->withInput($request->only($this->username(), 'remember'))
        ->withErrors([$this->username() => $message]);
}
}
