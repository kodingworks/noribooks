<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * showLoginForm
     *
     * @return void
     */
    public function showLoginForm()
    {
        return Inertia::render('admin/auth/login', [
            "title" => 'Login'
        ]);
    }

    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            return response()->json([
                "status" => 422,
                "message" => "Sorry! Too many login attempts, please try again after 10 minutes",
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $this->clearLoginAttempts($request);

            // Logout if user didnt have access to dashboard
            if (!auth()->user()->can('view_general_dashboard')) {
                $this->guard()->logout();

                return response()->json([
                    "status" => 403,
                    "message" => "You didnt have access to dashboard, please contact your administrator",
                ], 403);
            }

            /*Initialization Access Module*/
            return response()->json([
                "status" => 200,
                "message" => "Success",
            ], 200);
        }

        $this->incrementLoginAttempts($request);
        return response()->json([
            "status" => 422,
            "message" => "Whoops! Login Error Occurred, Check Your Username And Password Again",
        ], 422);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return response()->json([
            "status" => 200,
            "message" => "Success",
        ], 200);
    }
}
