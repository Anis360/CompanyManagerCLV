<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = DB::select('select * from sessions');

        if ((Auth::user()->	password_changed_at == NULL))
        {
            return redirect(route('changePassword'));
        }
        else
        {
            return view('home')->with('sessions', $sessions);
        }
    }
}
