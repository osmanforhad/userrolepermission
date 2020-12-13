<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.pages.dashboard.index');

    } //end of the index method
} //end of the DashboardController class