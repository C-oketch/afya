<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class WebController extends Controller
{


    public function Webreg(Request $request)

    {
  $now = Carbon::now();
  $firstname=$request->firstname;
  $surname=$request->surname;
  $email  =$request->email;
  $phone  =$request->phone;
  $pysical_address=$request->address;
  $city  =$request->city;
  $county  =$request->county;
  $country  =$request->country;
  $name_buss  =$request->bss;
  $user_type = $request->user_type;
  $note = $request->note;

  $patemail=DB::table('web_reg')
  ->select('email as patmail')->where('email',$email)->first();
if($patemail->patmail){
  $id=$user_type;

$emailerror= "The user with that email already exist";
return view('web_reg')->with('firstname',$firstname)->with('emailerror',$emailerror)->with('id',$id);
}else{
  DB::table('web_reg')->insert([
'firstname'  => $firstname,
'surname'  => $surname,
'email'  => $email,
'phone'  => $phone,
'pysical_address' => $pysical_address,
'city'  => $city,
'county'  => $county,
'country'  => $country,
'name_buss'  => $name_buss,
'user_type'  => $user_type,
'note'  => $note,
'created_at'  => $now,
'updated_at'  => $now,
  ]);

return view('welcome')->with('firstname',$firstname);
  }
    }
}
