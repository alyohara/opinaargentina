<?php

namespace App\Http\Controllers;

use App\Models\Export;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        $exports = Export::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('exports.index', compact('exports'));
    }
}
