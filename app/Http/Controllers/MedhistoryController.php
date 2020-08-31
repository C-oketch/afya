<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Medhistory;

use App\Druglist;
use DB;
class MedhistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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



    public function selfmedcreate($id){
      $data['drugs']=Druglist::all();
    return view('private.selfmed' ,$data)->with('id',$id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['afya_user_id']=$id;
        $data['drugs']=Druglist::all();

        return view('nurse.meds',$data);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeprivates(Request $request)
    {
        Medhistory::create($request->all());

        return redirect()->action('privateController@showUser',[$request->afya_user_id]);
    }


    public function chroniccreate($id){

    return view('private.chronic')->with('id',$id);
    }





    public function addchronic(Request $request){


      $id=$request->afya_user_id;
      $chronics=$request->chronic;
     $chrodate=$request->chronic_date;
  DB::table('patient_diagnosis')->insert([
   'afya_user_id'=>$id,
   'disease_id'=>$chronics,
   'chronic'=>'Y',
   'date_diagnosed'=>$chrodate,
   'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);

   return redirect()->action('privateController@showUser',[$request->afya_user_id]);


    }

    public  function add_allergy($id){

         return view('private.allergy')->with('id',$id);
      }

      public function update_allergy(Request $request){
         $id=$request->id;
         $drugs=$request->drugs;
    if($drugs){
    foreach($drugs as $key =>$drug) {
         DB::table('afya_users_allergy')->insert([
        'afya_user_id'=>$id,
        'allergies_type_id'=>$drug,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
     $foods=$request->foods;
     if($foods){
    foreach($foods as $key) {
        DB::table('afya_users_allergy')->insert([
        'afya_user_id'=>$id,
        'allergies_type_id'=>$key,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
     $latexs=$request->latexs;
     if($latexs){
    foreach($latexs as $key) {
       DB::table('afya_users_allergy')->insert([
        'afya_user_id'=>$id,
        'allergies_type_id'=>$key,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
     $molds=$request->molds;
     if($molds){
        foreach($molds as $key) {
       DB::table('afya_users_allergy')->insert([
        'afya_user_id'=>$id,

        'allergies_type_id'=>$key,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    $pets=$request->pets;
    if($pets)
    {
    foreach($pets as $key) {
        DB::table('afya_users_allergy')->insert([
        'afya_user_id'=>$id,
        'allergies_type_id'=>$key,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }

    $pollens=$request->pollens;
    if($pollens) {
    foreach($pollens as $key) {
       DB::table('afya_users_allergy')->insert([
        'afya_user_id'=>$id,
        'allergies_type_id'=>$key,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    $insects=$request->insects;
    if($insects){
    foreach($insects as $key) {
        DB::table('afya_users_allergy')->insert([
        'afya_user_id'=>$id,
        'allergies_type_id'=>$key,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
    }
    }
    return redirect()->action('privateController@showUser',[$id]);


      }

}
