<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use App\Facility;
use App\FacilityAdmin;
use App\FacilityFinance;
use App\FacilityRegistrer;
use App\Facility_doctor;
use App\Prescription_detail;
use App\Prescription;
use App\Test;
use App\TestCategories;
use App\TestSubcategories;
use App\User;
use Mail;
use Auth;
use App\Appointment;
use App\Claim;
use App\Afya_user;
use App\Doctor;


class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;


    public static function patients_claiming_per_hospital($facility){

      return Claim::where('facility_id','=',$facility)->count();

    }

    public static function cost_claimed_per_hospital($facility){

      return Claim::where('facility_id','=',$facility)->sum('cost');

    }

    public static function number_of_patients($facility){

    return Appointment::where('facility_id','=',$facility)->groupBy('afya_user_id')->count();

    }

     public static function number_of_activities($facility){

      return Appointment::where('facility_id','=',$facility)->count();

     }

     public static function number_of_visits($facility,$ptn){

      return Appointment::where('facility_id','=',$facility)
                        ->where('afya_user_id','=',$ptn)->count();

     }







     public static function uploadFile($request){



       if($file = $request->file('thefile')){


        $destinationPath = 'uploads';

        $thefile=$file->move($destinationPath,time().$file->getClientOriginalName());

        return $thefile;
       }else{

        return 1;
       }

     }


     public static function upload_img($file){


        $destinationPath = 'uploads';

        $path=$file->move($destinationPath,time().$file->getClientOriginalName());

        return $path;

     }



     public function send_mail($from,$from_name,$to,$subject,$msg){

      $data = array( 'to' =>$to, 'subject' => $subject, 'from' =>$from,'from_name' =>$from_name,'msg'=>$msg);

        Mail::send([], [], function($message) use ($data) {
            $message->from($data['from'],$data['from_name']);
            $message->to($data['to']);
            $message->subject($data['subject']);
            $message->setBody($data['msg'], 'text/html');
        });
    }



    public static function admin_facility_code(){

        $data = FacilityAdmin::select('*')
               ->where('user_id', '=', Auth::user()->id)
               ->first();

      return $data->facilitycode;

    }

     public static function afya_user($id){

       return Afya_user::find($id);

    }


 public static function afya_user_name($id){

       $data=Afya_user::find($id);

       if(!is_null($data)){

        return $data->firstname.' '.$data->secondName;
       }else{

        return "";
       }

    }

    public static function FileNo($id){

          $data=Afya_user::find($id);

          if(!is_null($data)){

           return $data->file_no;
          }else{

           return "";
          }

       }

 public static function user_name($id){

       $data=User::find($id);

       if(!is_null($data)){

        return $data->name;
       }else{

        return "";
       }

    }


    public static function afya_user_phone($id){

       $data=Afya_user::find($id);

       if(!is_null($data)){

        return $data->msisdn;
       }else{

        return "";
       }

    }


     public static function doctor($id){

       return Doctor::find($id);

    }

    public static function finance_facility_code(){

       $data=FacilityFinance::where('user_id', '=', Auth::user()->id)->first();

       return $data->facilitycode;

    }

    public static function finance_facility(){

        $data = FacilityFinance::select('*')
               ->where('user_id', '=', Auth::user()->id)
               ->get()
               ->first();

      return $data;

    }

     public static function registrer_facility(){

      $data= FacilityRegistrer::where('user_id', '=', Auth::user()->id)->first();

      return Facility::where('FacilityCode','=',$data->facilitycode)->first();

    }

    public static function doctor_facility(){

        $data = Facility_doctor::where('user_id', '=', Auth::user()->id)->first();

        return Facility::where('FacilityCode','=',$data->facilitycode)->first();

    }

    public static function doctor_reg_facility(){

        $data = Facility_doctor::where('user_id', '=', Auth::user()->id)->first();

        if(is_null($data)){

              $data= FacilityRegistrer::where('user_id', '=', Auth::user()->id)->first();

        }


        return Facility::where('FacilityCode','=',$data->facilitycode)->first();

    }


    public static function is_prescribed($app_id,$drug_id){

      $prescription = Prescription::where('appointment_id','=',$app_id)->first();

      if(!is_null( $prescription )){
           $presc=Prescription_detail::where('presc_id',"=",$prescription->id)
                                      ->where('drug_id',"=",$drug_id)
                                      ->where('prescription_details.deleted','=',0)
                                      ->get();

            if(count($presc)>0)return true; else return false;

      }else{

          return false;
      }



    }

    public static function detail_exists($app_id,$drug_id){

      $prescription = Prescription::where('appointment_id','=',$app_id)->first();

      if(!is_null( $prescription )){
           $presc=Prescription_detail::where('presc_id',"=",$prescription->id)
                                      ->where('drug_id',"=",$drug_id)
                                      ->first();

            if(!is_null($presc))return $presc->id; else return false;

      }else{

          return false;
      }



    }

    public static function detail_id($app_id,$drug_id){


      $prescription = Prescription::where('appointment_id', '=',$app_id)->first();

      if(!is_null($prescription)){

      $presc=Prescription_detail::where('presc_id',"=",$prescription->id)
                                ->where('drug_id',"=",$drug_id)
                                ->first();

        if(!is_null($presc))return $presc->id;
      }else{

        return false;
      }

    }


    public static function test_type($test_rec){

      $test=Test::find($test_rec);
      $sub_cat=TestSubcategories::find($test->sub_categories_id);
      $cat=TestCategories::find($sub_cat->categories_id);

       if($cat->overall_test_id==2)return "Lab Test(".$cat->name.")"; else return $cat->name;

    }

    public static function test_type_bycat($test_cat){

      //$test=Test::find($test_rec);
      //$sub_cat=TestSubcategories::find($test_cat);
      //$cat=TestCategories::find($sub_cat->categories_id);

       $cat=TestCategories::find($test_cat);

       return $cat->name;

    }


   public static function gender($gender)
   {

    if($gender=='1')return "Male"; elseif($gender=='2')return "Female"; else return "Not Known";
   }

}
