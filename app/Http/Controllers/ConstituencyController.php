<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Constituency;
use DB;
use Session;

class ConstituencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $consts=DB::table('constituency')
        ->Join('county', 'constituency.cont_id', '=', 'county.id')
        ->select('constituency.*', 'county.county')
        ->get();
        return view('constituency.index')->with('consts',$consts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $counties = DB::table('counties')->get();
        return view('constituency.create')->with('counties',$counties);
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
          'county_id'=>'required',
          'name'=>'required|max:255',

  ));
      $constituency= new Constituency();
      $constituency->county_id=$request->county_id;
      $constituency->name=$request->name;
      $constituency->save();

      Session::flash('success','The Constituency was successfully added!!');


     return redirect()->route('constituency.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $consts=Constituency::find($id);
        return view('constituency.edit')->with('consts',$consts);
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
        //
    }
}
