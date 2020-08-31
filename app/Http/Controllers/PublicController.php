<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Redirect;
use App\Facility;
use App\Doctor;
use App\Test;
use Session;
use App\Pharmacy;
use App\Afya_user;
use App\Appointment;
use App\Facility_doctor;
use App\Manufacturer;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    public function index()
    {
      return view('public.index');

    }




}
