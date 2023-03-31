<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Sensor;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $bookmarks = Bookmark::with('sensor')->where('user_id', Auth::user()->id)->get();
        $sensors = Sensor::with('user')->where('user_id', Auth::user()->id)->get();
        return view('dashboard', ['bookmarks' => $bookmarks, 'sensors' => $sensors]);
    }
}
