<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if (!Auth::user()->gtk) {
            return view('dashboard.new-account');
        }

        return view('dashboard.index');
    }
}
