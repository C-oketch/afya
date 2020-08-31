<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use DB;
use App\PatientNhif;
use App\Document;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Input;


class PatientNhifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

      public function store(Request $request) {
        $this->validate($request, [
            'id_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

    $destinatonPath = '';
    $filename = '';

    $destinatonPath1 = '';
    $filename1 = '';

    $destinatonPath2 = '';
    $filename2 = '';
    $filename22 = '';

    $file = Input::file('id_image');
    $destinationPath = public_path().'/assets/uploads/ids/';
    $filename = str_random(6).'_'.$file->getClientOriginalName();
    $uploadSuccess = $file->move($destinationPath, $filename);

    $file1 = Input::file('photo');
    $destinationPath1 = public_path().'/assets/uploads/passport/';
    $filename1 = str_random(6).'_'.$file1->getClientOriginalName();
    $uploadSuccess1 = $file1->move($destinationPath1, $filename1);

  if(Input::hasFile('marige')){
    $file2 = Input::file('marige');
    $destinationPath2 = public_path().'/assets/uploads/marriage/';
    $filename2 = str_random(6).'_'.$file2->getClientOriginalName();
    $uploadSuccess2 = $file2->move($destinationPath2, $filename2);
    $filename22 ='/assets/uploads/marriage/' . $filename2;
}
    if(Input::hasFile('id_image')){
      $images = new PatientNhif;
      $images->afya_user_id = Input::get('afya_user_id');
      $images->employer_code = Input::get('employer_code');
      $images->employer_name = Input::get('employer_name');
      $images->employer_pin = Input::get('employer_pin');
      $images->nearest_branch = Input::get('branch');
        $images->id_doc = '/assets/uploads/ids/' . $filename;
        $images->photo = '/assets/uploads/passport/' . $filename1;
        $images->marriage_certificate = $filename22;

        $images->save();
        Session::flash('success_insert','<strong>Upload success</strong>');

    }
     $id = Auth::id();
     $patient=DB::table('afya_users')->where('users_id',$id)->first();
return view('patient.nhif')->with('patient',$patient);

  }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
