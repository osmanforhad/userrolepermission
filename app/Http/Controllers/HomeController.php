<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    } //end of the constructor method

    public function redirectAdmin()
    {
        return redirect()->route('admin.dashboard');
    } //end of the redirectAdmin method

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    } //end of the index method

} //end of the HomeController class