<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analytics;

class DashboardController extends Controller
{
    public function index()
    {
        $analytics = Analytics::latest()->first();
        return view('dashboard', compact('analytics'));
    }
}
