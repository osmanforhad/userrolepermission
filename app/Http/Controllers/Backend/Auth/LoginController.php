<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // } //end of the constructor method

    /**
     *show login form for admin guard
     *@return void
     */
    public function showLoginForm()
    {
        return view('backend.auth.login');
    } //end of the showLoginForm method

    /**
     *method for
     *login to
     *admin guard
     * @param Request $request
     */
    public function login(Request $request)
    {
        //Validate Login Data
        $request->validate([
            'email' => 'required|max:50',
            'password' => 'required',
        ]);
        //Attempt to login using email
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
            //redirect to dashboard
            session()->flash('success', 'Successfully Logged in !');
            return redirect()->intended(route('admin.dashboard'));
        } else {
            //Attempt to login using username
            if (Auth::guard('admin')->attempt(['username' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {
                session()->flash('success', 'Successfully Logged in !');
                return redirect()->intended(route('admin.dashboard'));

            }

            //error
            session()->flash('error', 'Invalid email and password');
            return back();

        }
    } //end of the showLoginForm method

    /**
     * method for
     * logut from
     *  admin guard
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    } //end of the logout method

} //end of the LoginController class