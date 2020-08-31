<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Illness;
use DB;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class IllnessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      $illnesses=DB::table('illnesses')
            ->get();
      return view('illness.index')->with('illnesses',$illnesses);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('illness.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $illness=$request->illness;
      DB::table('illnesses')->insert(
      ['name' => $illness,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()


      ]
      );


     return redirect()->route('illness.index');
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
      $illness=Illness::find($id);
      return view('illness.edit')->with('illness',$illness);
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
        'name'=>'required|max:250',
      ));

$illness=Illness::find($id);
$illness->name=$request->name;
$illness->save();
Session::flash('success','The illness was successfully updated!!');


return redirect()->route('illness.index');
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
