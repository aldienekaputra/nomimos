<?php

namespace App\Http\Controllers;

use App\Models\PaketAcara;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        return view('landing.home');
    }

    public function booking()
    {
        $pakets = PaketAcara::all();
        return view('landing.booking', compact('pakets'));
    }

    public function about()
    {
        return view('landing.about');
    }
}