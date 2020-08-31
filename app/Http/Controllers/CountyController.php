<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\County;
use App\Http\Controllers\Controller;
use Session;
use DB;
class CountyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counties=DB::table('county')->get();
        return view('county.index')->with('counties',$counties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('county.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,array(
          'name'=>'required|max:255',

  ));
      $county= new County();
      $county->name=$request->name;
      $county->save();




      Session::flash('success','The County was successfully added!!');


     return redirect()->route('county.index');
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
        $county=County::find($id);
        return view('county.edit')->with('county',$county);
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
      $this->validate($request,array(
        'name'=>'required|max:255',
      ));

$county=County::find($id);
$county->name=$request->name;
$county->save();
Session::flash('success','The County was successfully updated!!');


return redirect()->route('county.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  /** public function destroy($id)
    {
      County::destroy($id);
      Session::flash('success','The county was successfully deleted!!');
     return redirect()->route('county.index');
    }
  }*/
}
