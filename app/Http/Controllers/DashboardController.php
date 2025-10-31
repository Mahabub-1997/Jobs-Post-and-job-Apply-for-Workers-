<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{
       /**
        * Show the main dashboard.
        */
    public function index()
    {
        return view('backend.layouts.dashboard');
    }
    /**
     * Show the main dashboard.
     */
    public function dashboard()
    {
        return view('backend.layouts.dashboard');
    }
}
