<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ClerkController extends Controller
{
    public function __construct(){
    	$this->middleware('clerk');
    }

    public function index(){
    // return Auth::guard('admin')->user();
    	return view('clerk.dashboard');
    }
}
