<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\{User};
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout()
    {
        auth()->logout();
        return redirect('login');
    }
    public function username()
    {
        return 'username';
    }

    public function custom_login(Request $request)
    {
        // Retrieve the user with the given username
        $user = User::where('username', $request->username)->first();

        if ($user) {
            // Check if the passwords match
            if ($user->password == $request->password) {
                // Log in the user
                Auth::login($user);

                // Authentication successful
                return redirect()->intended('/admin/home');
            } else {
                // Authentication failed
                return back()->withInput()->withErrors(['username' => 'Invalid credentials']);
            }
        } else {
            // User not found
            return back()->withInput()->withErrors(['username' => 'User not found']);
        }
    }

}
