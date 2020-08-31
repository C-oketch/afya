<?php

namespace App\Http\Controllers;
use App\Testprice;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
use App\Link;
use App\Ctscan;
use App\Testpricexray;
use App\Testpriceultra;
use App\Testpricemri;


class FacilityAdminController2 extends Controller
{

  //LAB TESTS
  public function addItem(Request $request)
    {
      $fac = DB::table('facility_admin')
          ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
          ->first();
          $tid=$request->tests_id;
          $user_id=$fac->user_id;
          $facility_id=$fac->facilitycode;
          $amount1=$request->amount1;
          $amount2=$request->amount2;
          $amount3=$request->amount3;
          $amount4=$request->amount4;
          $option1=$request->option1;
          $option2=$request->option2;
          $option3=$request->option3;
          $option4=$request->option4;

        $insertedId = DB::table('test_price')->insertGetId([
               'tests_id'=>$tid,
               'facility_id'=>$facility_id,
               'user_id'=>$user_id,
          ]);
      if($amount1){
      DB::table('testprice_lab_option')->insert([
           'tp_id'=>$insertedId,
           'amount'=>$amount1,
           'name'=>$option1,
           'status'=>1,
            ]);
      }
      if($amount2){
        DB::table('testprice_lab_option')->insert([
             'tp_id'=>$insertedId,
           'amount'=>$amount2,
           'name'=>$option2,
           'status'=>1,
            ]);
      }
      if($amount3){
        DB::table('testprice_lab_option')->insert([
           'tp_id'=>$insertedId,
           'amount'=>$amount3,
           'name'=>$option3,
           'status'=>1,
            ]);
      }
      if($amount4){
        DB::table('testprice_lab_option')->insert([
          'tp_id'=>$insertedId,
           'amount'=>$amount4,
           'name'=>$option4,
           'status'=>1,
            ]);
      }
      return redirect()->action('FacilityAdminController2@readItems');
    }

    public function readItems(Request $req)
    {
    $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
        ->select('facilitycode')->first();
      $facility_id= $admin->facilitycode;

      $data['tests'] =DB::table('tests')
      ->select('name','id as testId')->get();


      $data['factest'] =DB::table('test_price')
      ->Join('tests', 'test_price.tests_id', '=', 'tests.id')
      ->leftJoin('testprice_lab_option', 'test_price.id', '=', 'testprice_lab_option.tp_id')
      ->select('tests.name','tests.id as testId','test_price.id',
       'testprice_lab_option.id as tpoid','testprice_lab_option.amount','testprice_lab_option.name as tponame','testprice_lab_option.status')
      ->where('test_price.facility_id',$facility_id)
      ->get();


      return view('facilityadmin.testprice',$data);
    }

    public function alltests(Request $req)
    {
      $facility = DB::table('facility_admin')
                ->join('facilities','facility_admin.facilitycode','=','facilities.FacilityCode')
                ->select('facility_admin.facilitycode','facilities.set_up')
                ->where('user_id', Auth::id())
                ->first();
    $facilitycode = $facility->facilitycode;
      $fsetup = $facility->set_up;
  $data['lab']=DB::table('test_price')->distinct('tests_id')->where('facility_id', $facilitycode)->count('tests_id');
  $data['ct']=DB::table('test_prices_ct_scan')->distinct('ct_scan_id')->where('facility_id', $facilitycode)->count('ct_scan_id');
  $data['xray']=DB::table('test_prices_xray')->distinct('xray_id')->where('facility_id', $facilitycode)->count('xray_id');
  $data['other']=DB::table('test_prices_other')->distinct('other_id')->where('facility_id', $facilitycode)->count('other_id');
  $data['ultra']=DB::table('test_prices_ultrasound')->distinct('ultrasound_id')->where('facility_id', $facilitycode)->count('ultrasound_id');
  $data['mri']=DB::table('test_prices_mri')->distinct('mri_id')->where('facility_id', $facilitycode)->count('mri_id');

  $data['card']=DB::table('testprice_cardiac')->distinct('tests_id')->where('facility_id', $facilitycode)->count('tests_id');
  $data['neuro']=DB::table('testprice_neurology')->distinct('tests_id')->where('facility_id', $facilitycode)->count('tests_id');
  $data['proc']=DB::table('procedure_prices')->distinct('procedure_id')->where('facility_id', $facilitycode)->count('procedure_id');


      return view('facilityadmin.alltests',$data);
    }

    public function editItem(Request $req)
    {
      $tpid=$req->tests_id;
      $availability = $req->availability;
      $amount = $req->amount;
      $tpoid =$req->tpoid;
      $optionp=$req->optionp;

      $updates = DB::table('test_price')->where('id',$tpid)
      ->update([
               'user_id'=>Auth::user()->id,
               'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);
    $updates2 = DB::table('testprice_lab_option')->where('id',$tpoid)
    ->update([
             'amount'=>$amount,
             'name'=>$optionp,
             'status'=>$availability,
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
              ]);


  return redirect()->action('FacilityAdminController2@readItems');
    }


public function RemoveItem($id)
  {

DB::table('testprice_lab_option')->where('id', '=', $id)->delete();

  return redirect()->action('FacilityAdminController2@readItems');
}
//CT TESTS
public function addct(Request $request)
  {
    $fac = DB::table('facility_admin')
        ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
        ->first();
        $tid=$request->tests_id;
        $user_id=$fac->user_id;
        $facility_id=$fac->facilitycode;
        $amount1=$request->amount1;
        $amount2=$request->amount2;
        $amount3=$request->amount3;
        $amount4=$request->amount4;
        $option1=$request->option1;
        $option2=$request->option2;
        $option3=$request->option3;
        $option4=$request->option4;

      $insertedId = DB::table('test_prices_ct_scan')->insertGetId([
             'ct_scan_id'=>$tid,
             'facility_id'=>$facility_id,
             'user_id'=>$user_id,
        ]);
  if($amount1){
   DB::table('testprice_ct_option')->insert([
         'tpct_id'=>$insertedId,
         'amount'=>$amount1,
         'name'=>$option1,
         'status'=>1,
          ]);
  }
  if($amount2){
    DB::table('testprice_ct_option')->insert([
          'tpct_id'=>$insertedId,
         'amount'=>$amount2,
         'name'=>$option2,
         'status'=>1,
          ]);
  }
  if($amount3){
    DB::table('testprice_ct_option')->insert([
          'tpct_id'=>$insertedId,
         'amount'=>$amount3,
         'name'=>$option3,
         'status'=>1,
          ]);
  }
  if($amount4){
    DB::table('testprice_ct_option')->insert([
          'tpct_id'=>$insertedId,
         'amount'=>$amount4,
         'name'=>$option4,
         'status'=>1,
          ]);
  }
  return redirect()->action('FacilityAdminController2@readct');
  }
  public function readct()
  {

    $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
      ->select('facilitycode')->first();
    $facility_id= $admin->facilitycode;

    $data['tests'] =DB::table('ct_scan')
    ->select('name','id as testId')->get();


    $data['factest'] =DB::table('ct_scan')
    ->Join('test_prices_ct_scan', 'ct_scan.id', '=', 'test_prices_ct_scan.ct_scan_id')
    ->Join('testprice_ct_option', 'test_prices_ct_scan.id', '=', 'testprice_ct_option.tpct_id')
    ->select('ct_scan.name','ct_scan.id as testId','test_prices_ct_scan.id',
     'testprice_ct_option.id as tpoid','testprice_ct_option.amount','testprice_ct_option.name as tponame','testprice_ct_option.status')
    ->where('test_prices_ct_scan.facility_id',$facility_id)
    ->get();

      return view('facilityadmin.testpricect',$data);
  }
  public function editct(Request $req)
  {
    $tpid=$req->tests_id;
    $availability = $req->availability;
    $amount = $req->amount;
    $tpoid =$req->tpoid;
    $optionp=$req->optionp;

    $updates = DB::table('test_prices_ct_scan')->where('id',$tpid)
    ->update([
             'user_id'=>Auth::user()->id,
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
              ]);


  $updates2 = DB::table('testprice_ct_option')->where('id',$tpoid)
  ->update([
           'amount'=>$amount,
           'name'=>$optionp,
           'status'=>$availability,
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);


  return redirect()->action('FacilityAdminController2@readct');
  }

public function RemoveCt($id)
  {
DB::table('testprice_ct_option')->where('id', '=', $id)->delete();
  return redirect()->action('FacilityAdminController2@readct');
}
  //xray TESTS
  public function addxray(Request $request)
  {
    $fac = DB::table('facility_admin')
        ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
        ->first();
        $tid=$request->tests_id;
        $user_id=$fac->user_id;
        $facility_id=$fac->facilitycode;
        $amount1=$request->amount1;
        $amount2=$request->amount2;
        $amount3=$request->amount3;
        $amount4=$request->amount4;
        $option1=$request->option1;
        $option2=$request->option2;
        $option3=$request->option3;
        $option4=$request->option4;

      $insertedId = DB::table('test_prices_xray')->insertGetId([
             'xray_id'=>$tid,
             'facility_id'=>$facility_id,
             'user_id'=>$user_id,
        ]);
    if($amount1){
    DB::table('testprice_xray_option')->insert([
         'tpxray_id'=>$insertedId,
         'amount'=>$amount1,
         'name'=>$option1,
         'status'=>1,
          ]);
    }
    if($amount2){
      DB::table('testprice_xray_option')->insert([
           'tpxray_id'=>$insertedId,
         'amount'=>$amount2,
         'name'=>$option2,
         'status'=>1,
          ]);
    }
    if($amount3){
      DB::table('testprice_xray_option')->insert([
           'tpxray_id'=>$insertedId,
         'amount'=>$amount3,
         'name'=>$option3,
         'status'=>1,
          ]);
    }
    if($amount4){
      DB::table('testprice_xray_option')->insert([
           'tpxray_id'=>$insertedId,
         'amount'=>$amount4,
         'name'=>$option4,
         'status'=>1,
          ]);
    }
    return redirect()->action('FacilityAdminController2@readxray');
    }
    public function readxray(Request $req)
    {
      $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
        ->select('facilitycode')->first();
      $facility_id= $admin->facilitycode;

      $data['tests'] =DB::table('xray')
      ->select('name','id as testId')->get();


      $data['factest'] =DB::table('xray')
      ->Join('test_prices_xray', 'xray.id', '=', 'test_prices_xray.xray_id')
      ->Join('testprice_xray_option', 'test_prices_xray.id', '=', 'testprice_xray_option.tpxray_id')
      ->select('xray.name','xray.id as testId','test_prices_xray.id',
       'testprice_xray_option.id as tpoid','testprice_xray_option.amount','testprice_xray_option.name as tponame','testprice_xray_option.status')
      ->where('test_prices_xray.facility_id',$facility_id)
      ->get();

    return view('facilityadmin.testpricexray',$data);
    }

    public function readotherIm(Request $req)
    {

  $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
    ->select('facilitycode')->first();
  $facility_id= $admin->facilitycode;

  $data['tests'] =DB::table('other_tests')
  ->select('other_tests.name','other_tests.id as testId')->get();


  $data['factest'] =DB::table('other_tests')
  ->Join('test_prices_other', 'other_tests.id', '=', 'test_prices_other.other_id')
  ->Join('testprice_other_option', 'test_prices_other.id', '=', 'testprice_other_option.tpo_id')
  ->select('other_tests.name','other_tests.id as testId','test_prices_other.id',
   'testprice_other_option.id as tpoid','testprice_other_option.amount','testprice_other_option.name as tponame','testprice_other_option.status')
  ->where('test_prices_other.facility_id',$facility_id)
  ->get();

    return view('facilityadmin.otherIm',$data);
    }

    public function editxray(Request $req)
    {
      $tpid=$req->tests_id;
      $availability = $req->availability;
      $amount = $req->amount;
      $tpoid =$req->tpoid;
      $optionp=$req->optionp;

      $updates = DB::table('test_prices_xray')->where('id',$tpid)
      ->update([
               'user_id'=>Auth::user()->id,
               'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);


      $updates2 = DB::table('testprice_xray_option')->where('id',$tpoid)
      ->update([
             'amount'=>$amount,
             'name'=>$optionp,
             'status'=>$availability,
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
              ]);


      return redirect()->action('FacilityAdminController2@readxray');
    }

public function Removexray($id)
  {
DB::table('testprice_xray_option')->where('id', '=', $id)->delete();
  return redirect()->action('FacilityAdminController2@readxray');
}


    public function editother(Request $req)
    {

      $tpid=$req->tests_id;
      $availability = $req->availability;
      $amount = $req->amount;
      $tpoid =$req->tpoid;
      $optionp=$req->optionp;

      $updates = DB::table('test_prices_other')->where('id',$tpid)
      ->update([
               'user_id'=>Auth::user()->id,
               'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);


    $updates2 = DB::table('testprice_other_option')->where('id',$tpoid)
    ->update([
             'amount'=>$amount,
             'name'=>$optionp,
             'status'=>$availability,
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
              ]);


return redirect()->action('FacilityAdminController2@readotherIm');

    }
    //xray TESTS
    public function saveother(Request $request)
    {
  $fac = DB::table('facility_admin')
      ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
      ->first();
      $tid=$request->tests_id;
      $user_id=$fac->user_id;
      $facility_id=$fac->facilitycode;
      $amount1=$request->amount1;
      $amount2=$request->amount2;
      $amount3=$request->amount3;
      $amount4=$request->amount4;
      $option1=$request->option1;
      $option2=$request->option2;
      $option3=$request->option3;
      $option4=$request->option4;

    $insertedId = DB::table('test_prices_other')->insertGetId([
           'other_id'=>$tid,
           'facility_id'=>$facility_id,
           'user_id'=>$user_id,
      ]);
if($amount1){
 DB::table('testprice_other_option')->insertGetId([
       'tpo_id'=>$insertedId,
       'amount'=>$amount1,
       'name'=>$option1,
       'status'=>1,
        ]);
}
if($amount2){
 DB::table('testprice_other_option')->insertGetId([
       'tpo_id'=>$insertedId,
       'amount'=>$amount2,
       'name'=>$option2,
       'status'=>1,
        ]);
}
if($amount3){
 DB::table('testprice_other_option')->insertGetId([
       'tpo_id'=>$insertedId,
       'amount'=>$amount3,
       'name'=>$option3,
       'status'=>1,
        ]);
}
if($amount4){
 DB::table('testprice_other_option')->insertGetId([
       'tpo_id'=>$insertedId,
       'amount'=>$amount4,
       'name'=>$option4,
       'status'=>1,
        ]);
}
return redirect()->action('FacilityAdminController2@readotherIm');
      }
    //MRI TESTS
    public function addmri(Request $request)
      {
        $fac = DB::table('facility_admin')
            ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
            ->first();
            $tid=$request->tests_id;
            $user_id=$fac->user_id;
            $facility_id=$fac->facilitycode;
            $amount1=$request->amount1;
            $amount2=$request->amount2;
            $amount3=$request->amount3;
            $amount4=$request->amount4;
            $option1=$request->option1;
            $option2=$request->option2;
            $option3=$request->option3;
            $option4=$request->option4;

          $insertedId = DB::table('test_prices_mri')->insertGetId([
                 'mri_id'=>$tid,
                 'facility_id'=>$facility_id,
                 'user_id'=>$user_id,
            ]);
        if($amount1){
          DB::table('testprice_mri_option')->insert([
            'tpmri_id'=>$insertedId,
             'amount'=>$amount1,
             'name'=>$option1,
             'status'=>1,
              ]);
        }
        if($amount2){
          DB::table('testprice_mri_option')->insert([
               'tpmri_id'=>$insertedId,
             'amount'=>$amount2,
             'name'=>$option2,
             'status'=>1,
              ]);
        }
        if($amount3){
          DB::table('testprice_mri_option')->insert([
               'tpmri_id'=>$insertedId,
             'amount'=>$amount3,
             'name'=>$option3,
             'status'=>1,
              ]);
        }
        if($amount4){
        DB::table('testprice_mri_option')->insert([
             'tpmri_id'=>$insertedId,
             'amount'=>$amount4,
             'name'=>$option4,
             'status'=>1,
              ]);
        }
        return redirect()->action('FacilityAdminController2@readmri');
      }
      public function readmri()
      {

        $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
        ->select('facilitycode')->first();
        $facility_id= $admin->facilitycode;
        $data['tests'] =DB::table('mri_tests')
        ->select('name','id as testId')->get();
        $data['factest'] =DB::table('mri_tests')
        ->Join('test_prices_mri', 'mri_tests.id', '=', 'test_prices_mri.mri_id')
        ->Join('testprice_mri_option', 'test_prices_mri.id', '=', 'testprice_mri_option.tpmri_id')
        ->select('mri_tests.name','mri_tests.id as testId','test_prices_mri.id',
        'testprice_mri_option.id as tpoid','testprice_mri_option.amount','testprice_mri_option.name as tponame','testprice_mri_option.status')
        ->where('test_prices_mri.facility_id',$facility_id)
        ->get();
        return view('facilityadmin.testpricemri',$data);
      }

      public function upimages()
      {

            $data =DB::table('mri_tests')
                  ->select('mri_tests.name','mri_tests.id as testId')
                  ->get();
return view('facilityadmin.upimages')->with('data',$data);
      }

      public function upimagespst(Request $request) {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

      $destinatonPath = '';
      $filename = '';
      $facid= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)->first();
    $facility=$facid->facilitycode;

      $file = Input::file('image');
      $destinationPath = public_path().'/img/logos/';
      $filename = str_random(6).'_'.$file->getClientOriginalName();
      $uploadSuccess = $file->move($destinationPath, $filename);


      if(Input::hasFile('image')){

$insertedId = DB::table('logo_imgs')->insertGetId([
'facility' => $facility,
'directory' => $filename,
'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]);
}



return view('facilityadmin.upimages');
        }






      public function editmri(Request $req)
      {
        $tpid=$req->tests_id;
        $availability = $req->availability;
        $amount = $req->amount;
        $tpoid =$req->tpoid;
        $optionp=$req->optionp;

        $updates = DB::table('test_prices_mri')->where('id',$tpid)
        ->update([
                 'user_id'=>Auth::user()->id,
                 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                  ]);


        $updates2 = DB::table('testprice_mri_option')->where('id',$tpoid)
        ->update([
               'amount'=>$amount,
               'name'=>$optionp,
               'status'=>$availability,
               'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);


        return redirect()->action('FacilityAdminController2@readmri');
      }

public function Removemri($id)
  {
DB::table('testprice_mri_option')->where('id', '=', $id)->delete();
  return redirect()->action('FacilityAdminController2@readmri');
}
      //ULTRA TESTS
      public function addultra(Request $request)
        {
          $fac = DB::table('facility_admin')
              ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
              ->first();
              $tid=$request->tests_id;
              $user_id=$fac->user_id;
              $facility_id=$fac->facilitycode;
              $amount1=$request->amount1;
              $amount2=$request->amount2;
              $amount3=$request->amount3;
              $amount4=$request->amount4;
              $option1=$request->option1;
              $option2=$request->option2;
              $option3=$request->option3;
              $option4=$request->option4;

            $insertedId = DB::table('test_prices_ultrasound')->insertGetId([
                   'ultrasound_id'=>$tid,
                   'facility_id'=>$facility_id,
                   'user_id'=>$user_id,
              ]);
          if($amount1){
            DB::table('testprice_ultra_option')->insert([
                 'tpultra_id'=>$insertedId,
               'amount'=>$amount1,
               'name'=>$option1,
               'status'=>1,
                ]);
          }
          if($amount2){
            DB::table('testprice_ultra_option')->insert([
             'tpultra_id'=>$insertedId,
               'amount'=>$amount2,
               'name'=>$option2,
               'status'=>1,
                ]);
          }
          if($amount3){
            DB::table('testprice_ultra_option')->insert([
                 'tpultra_id'=>$insertedId,
               'amount'=>$amount3,
               'name'=>$option3,
               'status'=>1,
                ]);
          }
          if($amount4){
          DB::table('testprice_ultra_option')->insert([
               'tpultra_id'=>$insertedId,
               'amount'=>$amount4,
               'name'=>$option4,
               'status'=>1,
                ]);
          }
          return redirect()->action('FacilityAdminController2@readultra');
        }
        public function readultra()
        {
          $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
            ->select('facilitycode')->first();
          $facility_id= $admin->facilitycode;

          $data['tests'] =DB::table('ultrasound')
          ->select('name','id as testId')->get();


          $data['factest'] =DB::table('ultrasound')
          ->Join('test_prices_ultrasound', 'ultrasound.id', '=', 'test_prices_ultrasound.ultrasound_id')
          ->Join('testprice_ultra_option', 'test_prices_ultrasound.id', '=', 'testprice_ultra_option.tpultra_id')
          ->select('ultrasound.name','ultrasound.id as testId','test_prices_ultrasound.id',
           'testprice_ultra_option.id as tpoid','testprice_ultra_option.amount','testprice_ultra_option.name as tponame','testprice_ultra_option.status')
          ->where('test_prices_ultrasound.facility_id',$facility_id)
          ->get();
            return view('facilityadmin.testpriceultra',$data);
        }
        public function editultra(Request $req)
        {
          $tpid=$req->tests_id;
          $availability = $req->availability;
          $amount = $req->amount;
          $tpoid =$req->tpoid;
          $optionp=$req->optionp;

          $updates = DB::table('test_prices_ultrasound')->where('id',$tpid)
          ->update([
                   'user_id'=>Auth::user()->id,
                   'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                    ]);

          $updates2 = DB::table('testprice_ultra_option')->where('id',$tpoid)
          ->update([
                 'amount'=>$amount,
                 'name'=>$optionp,
                 'status'=>$availability,
                 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                  ]);

return redirect()->action('FacilityAdminController2@readultra');
        }

        public function Removeultra($id)
          {
        DB::table('testprice_ultra_option')->where('id', '=', $id)->delete();
          return redirect()->action('FacilityAdminController2@readultra');
        }



public function Discounts($id)
{

  $data =DB::table('tests')
  ->leftjoin('test_price','tests.id','=','test_price.tests_id')
  ->leftjoin('test_subcategories','tests.sub_categories_id','=','test_subcategories.id')
  ->select('tests.name','tests.id as testId','test_price.id','test_price.availability','test_price.amount',
  'test_subcategories.name as sub','test_price.facility_id')
  ->Where('tests.id',$id)
  ->first();
    return view('facilityadmin.discount')->with('data',$data);
}
public function adddiscounts(Request $request)
  {
    $reason=$request->reason;
    $amount=$request->amount;
    $test_price_id=$request->test_price_id;
    $facility_id=$request->facility_id;
    $user_id=$request->user_id;
    $status=$request->status;
    $testId=$request->testId;

$discount = DB::table('lab_test_discount')->insert([
        'reason'=>$reason,
         'amount'=>$amount,
         'test_price_id'=>$test_price_id,
         'facility_id'=>$facility_id,
         'user_id'=>$user_id,
          'status'=>$status,
          'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);
  return redirect()->action('FacilityAdminController2@Discounts', ['id' => $testId]);
}

public function discountupdate(Request $request)
  {
    $user_id=Auth::user()->id;
$amount=$request->amount;
    $test_discount_id=$request->test_discount_id;
    $status=$request->status;
    $testId=$request->testId;

$discount = DB::table('lab_test_discount')->where('id',$test_discount_id)
->update([
         'amount'=>$amount,
         'user_id'=>$user_id,
        'status'=>$status,
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
          ]);
  return redirect()->action('FacilityAdminController2@Discounts', ['id' => $testId]);
}

public function RemoverOop($id)
  {

DB::table('testprice_other_option')->where('id', '=', $id)->delete();

  return redirect()->action('FacilityAdminController2@readotherIm');
}
public function readcardiac()
{

  $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
  ->select('facilitycode')->first();
  $facility_id= $admin->facilitycode;

  $data['tests'] =DB::table('tests_cardiac')
  ->select('name','id as testId')->get();

  $data['factest'] =DB::table('tests_cardiac')
  ->Join('testprice_cardiac', 'tests_cardiac.id', '=', 'testprice_cardiac.tests_id')
  ->Join('testprice_cardiac_option', 'testprice_cardiac.id', '=', 'testprice_cardiac_option.tp_id')
  ->select('tests_cardiac.name','tests_cardiac.id as testId','testprice_cardiac.id',
  'testprice_cardiac_option.id as tpoid','testprice_cardiac_option.amount','testprice_cardiac_option.name as tponame','testprice_cardiac_option.status')
  ->where('testprice_cardiac.facility_id',$facility_id)
  ->get();
  return view('facilityadmin.tests.testpricecardiac',$data);
  }
public function readneurology()
{

  $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
  ->select('facilitycode')->first();
  $facility_id= $admin->facilitycode;

  $data['tests'] =DB::table('tests_neurology')->select('name','id as testId')->get();

  $data['factest'] =DB::table('tests_neurology')
  ->Join('testprice_neurology', 'tests_neurology.id', '=', 'testprice_neurology.tests_id')
  ->Join('testprice_neurology_option', 'testprice_neurology.id', '=', 'testprice_neurology_option.tp_id')
  ->select('tests_neurology.name','tests_neurology.id as testId','testprice_neurology.id',
  'testprice_neurology_option.id as tpoid','testprice_neurology_option.amount','testprice_neurology_option.name as tponame','testprice_neurology_option.status')
  ->where('testprice_neurology.facility_id',$facility_id)
  ->get();
  return view('facilityadmin.tests.testpriceneurology',$data);
}
public function readprocedure()
{

  $admin= DB::table('facility_admin')->where('user_id', '=', Auth::user()->id)
  ->select('facilitycode')->first();
  $facility_id= $admin->facilitycode;

  $data['tests'] =DB::table('procedures')->select('name','id as testId')->get();

  $data['factest'] =DB::table('procedures')
  ->Join('procedure_prices', 'procedures.id', '=', 'procedure_prices.procedure_id')
  ->Join('procedure_option', 'procedure_prices.id', '=', 'procedure_option.tp_id')
  ->select('procedures.name','procedures.id as testId','procedure_prices.id',
  'procedure_option.id as tpoid','procedure_option.amount','procedure_option.name as tponame','procedure_option.status')
  ->where('procedure_prices.facility_id',$facility_id)
  ->get();
  return view('facilityadmin.tests.procedure',$data);
}
public function addCardiac(Request $request)
  {
    $fac = DB::table('facility_admin')
        ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
        ->first();
        $tid=$request->tests_id;
        $user_id=$fac->user_id;
        $facility_id=$fac->facilitycode;
        $amount1=$request->amount1;
        $amount2=$request->amount2;
        $amount3=$request->amount3;
        $amount4=$request->amount4;
        $option1=$request->option1;
        $option2=$request->option2;
        $option3=$request->option3;
        $option4=$request->option4;

      $insertedId = DB::table('testprice_cardiac')->insertGetId([
             'tests_id'=>$tid,
             'facility_id'=>$facility_id,
             'user_id'=>$user_id,
        ]);
    if($amount1){
    DB::table('testprice_cardiac_option')->insert([
         'tp_id'=>$insertedId,
         'amount'=>$amount1,
         'name'=>$option1,
         'status'=>1,
          ]);
    }
    if($amount2){
      DB::table('testprice_cardiac_option')->insert([
           'tp_id'=>$insertedId,
         'amount'=>$amount2,
         'name'=>$option2,
         'status'=>1,
          ]);
    }
    if($amount3){
      DB::table('testprice_cardiac_option')->insert([
         'tp_id'=>$insertedId,
         'amount'=>$amount3,
         'name'=>$option3,
         'status'=>1,
          ]);
    }
    if($amount4){
      DB::table('testprice_cardiac_option')->insert([
        'tp_id'=>$insertedId,
         'amount'=>$amount4,
         'name'=>$option4,
         'status'=>1,
          ]);
    }
    return redirect()->action('FacilityAdminController2@readcardiac');
  }
  public function editcardiac(Request $req)
  {
    $tpid=$req->tests_id;
    $availability = $req->availability;
    $amount = $req->amount;
    $tpoid =$req->tpoid;
    $optionp=$req->optionp;

    $updates = DB::table('testprice_cardiac')->where('id',$tpid)
    ->update([
             'user_id'=>Auth::user()->id,
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
              ]);
  $updates2 = DB::table('testprice_cardiac_option')->where('id',$tpoid)
  ->update([
           'amount'=>$amount,
           'name'=>$optionp,
           'status'=>$availability,
           'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);


  return redirect()->action('FacilityAdminController2@readcardiac');
  }
  public function Removecardiac($id)
    {

  DB::table('testprice_cardiac_option')->where('id', '=', $id)->delete();

    return redirect()->action('FacilityAdminController2@readcardiac');
  }

  public function addneurology(Request $request)
    {
      $fac = DB::table('facility_admin')
          ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
          ->first();
          $tid=$request->tests_id;
          $user_id=$fac->user_id;
          $facility_id=$fac->facilitycode;
          $amount1=$request->amount1;
          $amount2=$request->amount2;
          $amount3=$request->amount3;
          $amount4=$request->amount4;
          $option1=$request->option1;
          $option2=$request->option2;
          $option3=$request->option3;
          $option4=$request->option4;

        $insertedId = DB::table('testprice_neurology')->insertGetId([
               'tests_id'=>$tid,
               'facility_id'=>$facility_id,
               'user_id'=>$user_id,
          ]);
      if($amount1){
      DB::table('testprice_neurology_option')->insert([
           'tp_id'=>$insertedId,
           'amount'=>$amount1,
           'name'=>$option1,
           'status'=>1,
            ]);
      }
      if($amount2){
        DB::table('testprice_neurology_option')->insert([
             'tp_id'=>$insertedId,
           'amount'=>$amount2,
           'name'=>$option2,
           'status'=>1,
            ]);
      }
      if($amount3){
        DB::table('testprice_neurology_option')->insert([
           'tp_id'=>$insertedId,
           'amount'=>$amount3,
           'name'=>$option3,
           'status'=>1,
            ]);
      }
      if($amount4){
        DB::table('testprice_neurology_option')->insert([
          'tp_id'=>$insertedId,
           'amount'=>$amount4,
           'name'=>$option4,
           'status'=>1,
            ]);
      }
      return redirect()->action('FacilityAdminController2@readneurology');
    }
    public function editneurology(Request $req)
    {
      $tpid=$req->tests_id;
      $availability = $req->availability;
      $amount = $req->amount;
      $tpoid =$req->tpoid;
      $optionp=$req->optionp;

      $updates = DB::table('testprice_neurology')->where('id',$tpid)
      ->update([
               'user_id'=>Auth::user()->id,
               'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);
    $updates2 = DB::table('testprice_neurology_option')->where('id',$tpoid)
    ->update([
             'amount'=>$amount,
             'name'=>$optionp,
             'status'=>$availability,
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
              ]);
    return redirect()->action('FacilityAdminController2@readneurology');
    }

    public function Removeneurology($id)
      {
    DB::table('testprice_neurology_option')->where('id', '=', $id)->delete();
      return redirect()->action('FacilityAdminController2@readneurology');
    }

    public function addprocedure(Request $request)
      {
        $fac = DB::table('facility_admin')
            ->select('user_id','facilitycode')->where('user_id', Auth::user()->id)
            ->first();
            $tid=$request->tests_id;
            $user_id=$fac->user_id;
            $facility_id=$fac->facilitycode;
            $amount1=$request->amount1;
            $amount2=$request->amount2;
            $amount3=$request->amount3;
            $amount4=$request->amount4;
            $option1=$request->option1;
            $option2=$request->option2;
            $option3=$request->option3;
            $option4=$request->option4;

          $insertedId = DB::table('procedure_prices')->insertGetId([
                 'procedure_id'=>$tid,
                 'facility_id'=>$facility_id,
                 'user_id'=>$user_id,
            ]);
        if($amount1){
        DB::table('procedure_option')->insert([
             'tp_id'=>$insertedId,
             'amount'=>$amount1,
             'name'=>$option1,
             'status'=>1,
              ]);
        }
        if($amount2){
          DB::table('procedure_option')->insert([
               'tp_id'=>$insertedId,
             'amount'=>$amount2,
             'name'=>$option2,
             'status'=>1,
              ]);
        }
        if($amount3){
          DB::table('procedure_option')->insert([
             'tp_id'=>$insertedId,
             'amount'=>$amount3,
             'name'=>$option3,
             'status'=>1,
              ]);
        }
        if($amount4){
          DB::table('procedure_option')->insert([
            'tp_id'=>$insertedId,
             'amount'=>$amount4,
             'name'=>$option4,
             'status'=>1,
              ]);
        }
        return redirect()->action('FacilityAdminController2@readprocedure');
      }
      public function editprocedure(Request $req)
      {
        $tpid=$req->tests_id;
        $availability = $req->availability;
        $amount = $req->amount;
        $tpoid =$req->tpoid;
        $optionp=$req->optionp;

        $updates = DB::table('procedure_prices')->where('id',$tpid)
        ->update([
                 'user_id'=>Auth::user()->id,
                 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                  ]);
      $updates2 = DB::table('procedure_option')->where('id',$tpoid)
      ->update([
               'amount'=>$amount,
               'name'=>$optionp,
               'status'=>$availability,
               'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);


      return redirect()->action('FacilityAdminController2@readprocedure');
      }
      public function Removeprocedure($id)
        {

      DB::table('procedure_option')->where('id', '=', $id)->delete();

        return redirect()->action('FacilityAdminController2@readprocedure');
      }


}
