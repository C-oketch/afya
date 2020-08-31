<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Druglist;

use App\Manufacturer;
use App\Http\Requests;
use Session;
use DB;

class DruglistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $druglists = DB::table('druglists')
      ->leftJoin('manufacturers', 'druglists.manufacturer_id', '=', 'manufacturers.id')
      ->get();


        return view('druglist.index')->with('druglists',$druglists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      $manufacturers=Manufacturer::get();
      return view('druglist.create')->with('manufacturers',$manufacturers);

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

          'drugname'=>'required|max:255',
          'regno'=>'required|max:255',
          'dosageform'=>'required|max:255',
          'ingredients'=>'required|max:255',
          'manufacturer_id'=>'required|max:255',

  ));
      $druglist= new Druglist();
      $druglist->drugname=$request->drugname;
      $druglist->regno=$request->regno;
      $druglist->dosageform=$request->dosageform;
      $druglist->ingredients=$request->ingredients;
      $druglist->manufacturer_id=$request->manufacturer_id;

      $druglist->save();




      Session::flash('success','The druglist was successfully added!!');


     return redirect()->route('druglist.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $druglists = DB::table('druglists')->where('manufacturer_id', '=',$id)->get();
      $manufacturer = DB::table('manufacturers')->where('id', '=',$id)->first();

      return view('druglist.show')->with('druglists',$druglists)->with('manufacturer',$manufacturer);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $druglist=Druglist::find($id);
        return view('druglist.edit')->with('druglist',$druglist);
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

$druglist=Druglist::find($id);
$druglist->name=$request->name;
$druglist->save();
Session::flash('success','The druglist was successfully updated!!');


return redirect()->route('druglist.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Druglist::destroy($id);
        Session::flash('success','The druglist was successfully Deleted!!');


        return redirect()->route('druglist.index');

    }
}
