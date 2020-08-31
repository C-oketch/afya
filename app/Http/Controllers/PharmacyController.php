<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Carbon\Carbon;
use Auth;
use App\Druglist;
use App\Doctor;
use App\Inventory;
use App\DrugSuppliers;
use Response;
use PDF;
class PharmacyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $person_treated = ''; // global variable
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        $today2 = $today->toDateString();

        $user_id = Auth::user()->id;

        $data = DB::table('pharmacists')
                  ->where('user_id', $user_id)
                  ->first();

        $facility = $data->premiseid;

        $results = DB::table('afya_users')
                ->join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
                ->join('appointments', 'appointments.afya_user_id', '=', 'afya_users.id')
                ->join('prescriptions', 'prescriptions.appointment_id', '=', 'appointments.id')
                ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
                ->join('doctors', 'doctors.id', '=', 'appointments.doc_id')
                ->select('afya_users.*','prescriptions.created_at AS presc_date','prescriptions.id AS presc_id',
                'doctors.name', 'appointments.persontreated', 'afya_users.id AS af_id')
                ->where('afyamessages.facilityCode', '=', $facility)
                //->whereNotNull('afya_users.dob')
                ->whereDate('afyamessages.created_at','=',$today2)
                ->whereIn('prescriptions.filled_status', [0, 2])
                ->orWhere(function ($query) use ($facility,$today2){
                $query->where('afyamessages.facilityCode', '=', $facility)
                      //->whereNotNull('afya_users.dob')
                      ->whereDate('afyamessages.created_at','=',$today2)
                      ->where('prescriptions.filled_status', '=', 0);
                })
                ->groupBy('appointments.id')
                ->get();



                $drugs = DB::table('druglists')->distinct()->get(['drugname']);

                $alternatives  = NULL; //to be changed back later

        // $alternatives = DB::table('afya_users')
        //               ->join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
        //               ->select('afya_users.*','afyamessages.created_at AS created_at')
        //               ->where('afyamessages.facilityCode', '=', $facility)
        //               ->whereDate('afyamessages.created_at','=',$today2)
        //               ->whereNull('afya_users.dob')
        //               ->whereNull('afyamessages.status')
        //               ->get();

        // $old_alternatives = DB::table('afya_users')
        //               ->join('afyamessages', 'afya_users.msisdn', '=', 'afyamessages.msisdn')
        //               ->select('afya_users.*','afyamessages.created_at AS created_at')
        //               ->where([
        //                 ['afyamessages.facilityCode', '=', $facility],
        //                 ['afyamessages.patient_state', '=', '20'],
        //               ])
        //               ->whereDate('afyamessages.created_at','=',$today2)
        //               ->whereNull('afyamessages.status')
        //               ->whereNotNull('afya_users.dob')
        //               ->get();


        return view('pharmacy.home')->with('results',$results)->with('drugs', $drugs)
        ->with('alternatives',$alternatives);

    }

    public function showAlternative($id)
    {
      $id = $id;
      return view('pharmacy.alternative_home')->with('id',$id);
    }

    public function showParent($id)
    {
      $id = $id;
      return view('pharmacy.parent_form')->with('id',$id);
    }

    public function showDependant($id)
    {
      $dependants = DB::table('dependant')
                ->join('dependant_parent','dependant_parent.dependant_id','=','dependant.id')
                ->select('dependant.*', 'dependant_parent.relationship')
                ->where('dependant_parent.afya_user_id',$id)
                ->get();

      return view('pharmacy.patient_dependants')->with('dependants',$dependants)->with('id',$id);
    }

    public function addDependant($id)
    {
      return view('pharmacy.dependant_form')->with('id',$id);
    }

    public function getDepPresc($id)
    {
      $dep_id = $id;
      $parent = DB::table('dependant_parent')
              ->select('afya_user_id')
              ->where('dependant_id', '=', $dep_id)
              ->first();
      $parent_id = $parent->afya_user_id;

      return view('pharmacy.dependant_prescription')->with('dep_id',$dep_id)->with('parent_id',$parent_id);
    }

    public function editParo(Request $request)
    {
      $id = $request->afya_user_id;

      return view('pharmacy.update_parent_form')->with('id',$id);
    }

    public function insertParent(Request $request )
    {
      $dob = $request->dob;
      $id = $request->afya_user_id;

      DB::table('afya_users')
      ->where('id', '=', $id)
      ->update([
        'dob' => $dob,
        'updated_at' => Carbon::now()
      ]);

      return view('pharmacy.parent_form')->with('id',$id);
    }

    public function insertDependant(Request $request )
    {
      $id = $request->id;
      $birth_place = $request->birth_place;
      $dep_dob = $request->dep_dob;
      $blood_type = $request->blood;
      $fname = $request->first;
      $sname = $request->second;
      $gender = $request->gender;
      $relation = $request->relationship;

      $parent = DB::table('afya_users')->where('id', '=', $id)->first();
      $phone = $parent->msisdn;

      $dep_id = DB::table('dependant')
              ->insertGetId([
                'firstName' => $fname,
                'secondName' => $sname,
                'gender' => $gender,
                'blood_type' => $blood_type,
                'dob' => $dep_dob,
                'pob' => $birth_place
              ]);

      DB::table('dependant_parent')
      ->insert([
        'dependant_id' => $dep_id,
        'afya_user_id' => $id,
        'relationship' => $relation,
        'phone' => $phone,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()

      ]);

      return view('pharmacy.dependant_prescription')->with('dep_id',$dep_id);
    }

    public function updateParent(Request $request )
    {
      $dob = $request->dob;
      $id = $request->afya_user_id;

      DB::table('afya_users')
      ->where('id', '=', $id)
      ->update([
        'dob' => $dob,
        'updated_at' => Carbon::now()
      ]);

      return view('pharmacy.parent_form')->with('id',$id);
    }

    public function insertPresc(Request $request )
    {
      $id = $request->id;
      $pharmacist = $request->pharmacist;
      $presc = $request->prescription;
      $presc_date = date("Y-m-d");
      $strength = $request->strength;
      $strength_unit = $request->strength_unit;
      $route = $request->routes;
      $frequency = $request->frequency;
      $complaints = $request->patient_complaints;
      $duration = $request->patient_complaints_duration;
      $doctor = $request->doctor;

      $afya_user_id = $request->afya_user_id;
      $new_presc ='';


      if(isset($complaints) && isset($duration))
      {
        $new_presc = DB::table('prescriptions')
        ->insertGetId([
          'prescribing_pharmacist' => $pharmacist,
          'date_prescribed' => $presc_date,
          'afya_user_id' => $afya_user_id,
          'patient_complaints' => $complaints,
          'complaint_duration' => $duration,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
      }

      elseif($request->is_drug_known == 'yes')
      {
        $new_presc = DB::table('prescriptions')
        ->insertGetId([
          'prescribing_pharmacist' => $pharmacist,
          'date_prescribed' => $presc_date,
          'afya_user_id' => $afya_user_id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
      }

      else
      {
        $new_presc = DB::table('prescriptions')
        ->insertGetId([
          'prescribing_doctor' => $doctor,
          'date_prescribed' => $request->date_prescribed,
          'afya_user_id' => $afya_user_id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
      }

      DB::table('prescription_details')
      ->insert([
        'presc_id' => $new_presc,
        'drug_id' => $presc,
        'strength' => $strength,
        'strength_unit' => $strength_unit,
        'routes' => $route,
        'frequency' => $frequency,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
      ]);


    return redirect()->action('PharmacyController@show',[$new_presc]);

    }

    public function insertDependantPresc(Request $request )
    {
      //$id = $request->id;
      $doctor = $request->doctor;
      $presc = $request->prescription;
      $presc_date = date("Y-m-d");
      $strength = $request->strength;
      $strength_unit = $request->strength_unit;
      $route = $request->routes;
      $frequency = $request->frequency;

      $dep_id = $request->dependant_id;

      $paro = DB::table('dependant_parent')
            ->join('afya_users', 'afya_users.id', '=', 'dependant_parent.afya_user_id')
            ->where('dependant_parent.dependant_id', '=', $dep_id)
            ->first();
      $parent_id = $paro->afya_user_id;

      $complaints = $request->patient_complaints;
      $duration = $request->patient_complaints_duration;
      $pharmacist = $request->pharmacist;
      $new_presc ='';

      if(isset($complaints) && isset($duration))
      {
        $new_presc = DB::table('prescriptions')
        ->insertGetId([
          'prescribing_pharmacist' => $pharmacist,
          'date_prescribed' => $presc_date,
          'afya_user_id' => $parent_id,
          'dependant_id' => $dep_id,
          'patient_complaints' => $complaints,
          'complaint_duration' => $duration,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
      }

      elseif($request->is_drug_known == 'yes')
      {
        $new_presc = DB::table('prescriptions')
        ->insertGetId([
          'prescribing_pharmacist' => $pharmacist,
          'date_prescribed' => $presc_date,
          'afya_user_id' => $parent_id,
          'dependant_id' => $dep_id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
      }

      else
      {
        $new_presc = DB::table('prescriptions')
        ->insertGetId([
          'prescribing_doctor' => $doctor,
          'date_prescribed' => $request->date_prescribed,
          'afya_user_id' => $parent_id,
          'dependant_id' => $dep_id,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now()
        ]);
      }

      DB::table('prescription_details')
      ->insert([
        'presc_id' => $new_presc,
        'drug_id' => $presc,
        'strength' => $strength,
        'strength_unit' => $strength_unit,
        'routes' => $route,
        'frequency' => $frequency,
        'created_at' => Carbon::now(),

        'updated_at' => Carbon::now()
      ]);


    return redirect()->action('PharmacyController@show',[$new_presc]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $today = Carbon::today();
      $today2 = $today->toDateString();
      $user_id = Auth::user()->id;
      $id = $id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;

      //For normal route patients (register-nurse-doctor-pharmacy)
      $patients = DB::table('prescriptions')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
        ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
        ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
        //->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
        //->join('route', 'prescription_details.routes', '=', 'route.id')
        ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
        ->select('druglists.drugname', 'druglists.id AS drug_id', 'prescriptions.*','prescription_details.*',
        'afya_users.*','prescription_details.id AS presc_id','prescriptions.id AS the_id',
        'appointments.persontreated',  'afya_users.id AS af_id')
        ->where([
          ['prescriptions.id', '=', $id],
          ['afyamessages.facilityCode', '=', $facility],
          ['prescription_details.is_filled', '=', 2]
        ])
        ->whereDate('afyamessages.created_at','=',$today2)
        ->orWhere(function ($query) use($id,$facility,$today2)
        {
        $query->where('prescription_details.is_filled', '=', 0)
              ->where('prescriptions.id', '=', $id)
              ->where('afyamessages.facilityCode', '=', $facility)
              ->whereDate('afyamessages.created_at','=',$today2);
        })
        ->groupBy('prescription_details.id')
        ->get();

        //For alternative route adult patients (prescription not in the system)
        $alt_patients = DB::table('prescriptions')
          ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
          ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
          ->join('afya_users', 'afya_users.id', '=', 'prescriptions.afya_user_id')
          ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
          ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
          ->join('route', 'prescription_details.routes', '=', 'route.id')
          ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
          ->select('druglists.drugname', 'druglists.id AS drug_id', 'prescriptions.*','prescription_details.*',
          'afya_users.*', 'route.name','prescription_details.id AS presc_id','prescriptions.id AS the_id',
          'frequency.name AS freq_name', 'afya_users.id AS af_id')
          ->where([
            ['prescriptions.id', '=', $id],
            ['afyamessages.facilityCode', '=', $facility],
            ['prescription_details.is_filled', '=', 2]
          ])
          ->whereDate('afyamessages.created_at','=',$today2)
          ->orWhere(function ($query) use($id,$facility,$today2)
          {
          $query->where('prescription_details.is_filled', '=', 0)
                ->where('prescriptions.id', '=', $id)
                ->where('afyamessages.facilityCode', '=', $facility)
                ->whereDate('afyamessages.created_at','=',$today2);
          })
          ->groupBy('prescription_details.id')
          ->get();


      return view('pharmacy.show')->with('patients',$patients)->with('alt_patients',$alt_patients);
    }

/**
* Get prescription details from show.blade.php
*/

    public function fillPresc($id)
    {

      $today = Carbon::today();

      $results = DB::table('prescriptions')
        ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
        //->join('route', 'prescription_details.routes', '=', 'route.id')
        ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
        ->select('druglists.drugname', 'druglists.id AS drug_id', 'prescriptions.*','prescription_details.*',
         'prescription_details.id AS presc_id','prescriptions.id AS the_id',
         'prescriptions.appointment_id','appointments.persontreated','appointments.afya_user_id')
        ->where([
          ['prescription_details.id', '=', $id]
        ])
        ->groupBy('prescription_details.id')
        ->first();

        $user_id = Auth::id();
        $data = DB::table('pharmacists')
                  ->where('user_id', $user_id)
                  ->first();

        $facility = $data->premiseid;

        $am = DB::table('prescriptions')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
        ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
        ->select('afyamessages.id AS mid')
        ->where('prescription_details.id', '=', $id)
        ->where('afyamessages.facilityCode', '=', $facility)
        ->whereDate('afyamessages.created_at','=',$today)
        ->first();
        $afyamessage_id = $am->mid;

        //$appointment_id = $results->appointment_id;

        $person_treated = $results->persontreated;
        $afya_user_id = ''; //Initializing variable to make it global
        $drugs = ''; //just making this variable global for later use

        if($person_treated === 'Self')
        {

        $afya_user_id = $results->afya_user_id;

        $drugs = DB::table('prescriptions')
          ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
          ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
          ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
          ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
          //->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
          //->join('route', 'prescription_details.routes', '=', 'route.id')
          ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
          ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
           'prescription_details.id AS presc_id')
          ->where([
            ['afya_users.id', '=', $afya_user_id],
            ['prescription_filled_status.end_date', '>=', $today],
          ])
          ->groupBy('prescription_details.id')
          ->get();

        }
        else
        {
          $afya_user_id = $person_treated;

          $drugs = DB::table('prescriptions')
            ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
            ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
            ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
            //->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            //->join('route', 'prescription_details.routes', '=', 'route.id')
            ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
            'prescription_details.id AS presc_id')
            ->where([
              ['dependant_parent.dependant_id', '=', $afya_user_id],
              ['prescription_filled_status.end_date', '>=', $today],
            ])
            ->groupBy('prescription_details.id')
            ->get();

        }

        if($person_treated === 'Self')
        {

        $afya_user_id = $results->afya_user_id;
        //
        // $diseases = DB::table('patient_diagnosis')
        //           ->join('diseases', 'patient_diagnosis.disease_id', '=', 'diseases.id')
        //           ->join('appointments', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
        //           ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        //           ->select('diseases.name AS disease','patient_diagnosis.date_diagnosed')
        //           ->where('appointments.afya_user_id', '=' , $afya_user_id)
        //           ->get();
        }
        else
        {

        $afya_user_id = $person_treated;

        // $diseases = DB::table('patient_diagnosis')
        //           ->join('diseases', 'patient_diagnosis.disease_id', '=', 'diseases.id')
        //           ->join('appointments', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
        //           ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        //           ->select('diseases.name AS disease','patient_diagnosis.date_diagnosed')
        //           ->where('appointments.afya_user_id', '=' , $afya_user_id)
        //           ->get();
        }

        if($person_treated === 'Self')
        {

        $afya_user_id = $results->afya_user_id;

        // $allergies = DB::table('allergies')
        //           ->join('allergies_type', 'allergies.id', '=', 'allergies_type.allergies_id')
        //           ->join('afya_users_allergy', 'afya_users_allergy.allergies_type_id', '=', 'allergies_type.id')
        //           ->select('afya_users_allergy.created_at','allergies.name','allergies_type.name AS a_name')
        //           ->where('afya_users_allergy.afya_user_id', '=' , $afya_user_id)
        //           ->get();
        }
        else
        {

        $afya_user_id = $person_treated;

        // $allergies = DB::table('allergies')
        //           ->join('allergies_type', 'allergies.id', '=', 'allergies_type.allergies_id')
        //           ->join('afya_users_allergy', 'afya_users_allergy.allergies_type_id', '=', 'allergies_type.id')
        //           ->select('afya_users_allergy.created_at','allergies.name','allergies_type.name AS a_name')
        //           ->where('afya_users_allergy.afya_user_id', '=' , $afya_user_id)
        //           ->get();
        }

      if(empty($results))
      {
        return redirect()->route('pharmacy');
      }
      else
      {
        return view('pharmacy.fill_prescription')->with('results',$results)
        ->with('drugs',$drugs)->with('afyamessage_id',$afyamessage_id);
      }
    }

    //Alternative fill prescription
    public function altFillPresc($id)
    {

      $today = Carbon::today();

      $user_id = Auth::id();
      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;
    //Get afyamessages id
        $am = DB::table('prescriptions')
            ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
            ->join('afya_users', 'afya_users.id', '=', 'prescriptions.afya_user_id')
            ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
            ->select('afyamessages.id AS mid')
            ->where('prescription_details.id', '=', $id)
            ->where('afyamessages.facilityCode', '=', $facility)
            ->whereDate('afyamessages.created_at','=',$today)
            ->first();
            $afyamessage_id = $am->mid;

      $results = DB::table('prescriptions')
        ->join('afya_users', 'prescriptions.afya_user_id', '=', 'afya_users.id')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
        ->join('route', 'prescription_details.routes', '=', 'route.id')
        ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
        ->select('druglists.drugname', 'druglists.id AS drug_id', 'prescriptions.*','prescription_details.*',
         'route.name','prescription_details.id AS presc_id','prescriptions.id AS the_id',
         'prescriptions.afya_user_id')
        ->where([
          ['prescription_details.id', '=', $id]
        ])
        ->groupBy('prescription_details.id')
        ->first();

        $person_treated = DB::table('prescriptions')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('dependant', 'dependant.id', '=', 'prescriptions.dependant_id')
        ->select('prescriptions.dependant_id')
        ->where('prescription_details.id', '=', $id)
        ->first();

        $afya_user_id = ''; //Initializing variable to make it global
        $drugs = ''; //just making this variable global for later use

        if(! isset($person_treated))
        {

        $afya_user_id = $results->afya_user_id;

        $drugs = DB::table('prescriptions')
          ->join('afya_users', 'afya_users.id', '=', 'prescriptions.afya_user_id')
          ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
          ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
          ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
          ->join('route', 'prescription_details.routes', '=', 'route.id')
          ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
          ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
           'route.name AS route_name','prescription_details.id AS presc_id','frequency.name AS freq_name')
          ->where([
            ['afya_users.id', '=', $afya_user_id],
            ['prescription_filled_status.end_date', '>=', $today],
          ])
          ->groupBy('prescription_details.id')
          ->get();

          if(! isset($drugs))
          {
            $drugs = DB::table('prescriptions')
              ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
              ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
              ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
              ->join('route', 'prescription_details.routes', '=', 'route.id')
              ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
              ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
               'route.name AS route_name','prescription_details.id AS presc_id','frequency.name AS freq_name')
              ->where([
                ['afya_users.id', '=', $afya_user_id],
                ['prescription_filled_status.end_date', '>=', $today],
              ])
              ->groupBy('prescription_details.id')
              ->get();
          }

        }
        else
        {
          $afya_user_id = $person_treated->dependant_id;

          $drugs = DB::table('prescriptions')
            ->join('afya_users', 'afya_users.id', '=', 'prescriptions.afya_user_id')
            ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
            ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
            ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->join('route', 'prescription_details.routes', '=', 'route.id')
            ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
             'route.name AS route_name','prescription_details.id AS presc_id','frequency.name AS freq_name')
            ->where([
              ['dependant_parent.dependant_id', '=', $afya_user_id],
              ['prescription_filled_status.end_date', '>=', $today],
            ])
            ->groupBy('prescription_details.id')
            ->get();

            if(! isset($drugs))
            {
              $drugs = DB::table('prescriptions')
                ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
                ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
                ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
                ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
                ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
                ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
                ->join('route', 'prescription_details.routes', '=', 'route.id')
                ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
                 'route.name AS route_name','prescription_details.id AS presc_id','frequency.name AS freq_name')
                ->where([
                  ['dependant_parent.dependant_id', '=', $afya_user_id],
                  ['prescription_filled_status.end_date', '>=', $today],
                ])
                ->groupBy('prescription_details.id')
                ->get();
            }

        }

        if(! isset($person_treated))
        {

        $afya_user_id = $results->afya_user_id;

        $diseases = DB::table('patient_diagnosis')
                  ->join('diseases', 'patient_diagnosis.disease_id', '=', 'diseases.id')
                  ->join('appointments', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
                  ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
                  ->select('diseases.name AS disease','patient_diagnosis.date_diagnosed')
                  ->where('appointments.afya_user_id', '=' , $afya_user_id)
                  ->get();
        }
        else
        {

        $afya_user_id = $person_treated->dependant_id;

        $diseases = DB::table('patient_diagnosis')
                  ->join('diseases', 'patient_diagnosis.disease_id', '=', 'diseases.id')
                  ->join('appointments', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
                  ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
                  ->select('diseases.name AS disease','patient_diagnosis.date_diagnosed')
                  ->where('dependant_parent.dependant_id.afya_user_id', '=' , $afya_user_id)
                  ->get();
        }

        if(! isset($person_treated))
        {

        $afya_user_id = $results->afya_user_id;

        $allergies = DB::table('allergies')
                  ->join('allergies_type', 'allergies.id', '=', 'allergies_type.allergies_id')
                  ->join('afya_users_allergy', 'afya_users_allergy.allergies_type_id', '=', 'allergies_type.id')
                  ->select('afya_users_allergy.created_at','allergies.name','allergies_type.name AS a_name')
                  ->where('afya_users_allergy.afya_user_id', '=' , $afya_user_id)
                  ->get();
        }
        else
        {

        $afya_user_id = $person_treated->dependant_id;

        $allergies = DB::table('allergies')
                  ->join('allergies_type', 'allergies.id', '=', 'allergies_type.allergies_id')
                  ->join('afya_users_allergy', 'afya_users_allergy.allergies_type_id', '=', 'allergies_type.id')
                  ->select('afya_users_allergy.created_at','allergies.name','allergies_type.name AS a_name')
                  ->where('afya_users_allergy.dependant_id', '=' , $afya_user_id)
                  ->get();
        }

      if(empty($results))
      {
        return redirect()->route('pharmacy');
      }
      else
      {
        return view('pharmacy.fill_prescription')->with('results',$results)
        ->with('drugs',$drugs)->with('diseases',$diseases)->with('allergies',$allergies)
        ->with('afyamessage_id',$afyamessage_id);
      }
    }

    /**
    *  Substitute drug
    */
    public function subPresc($id)
{
  $today = Carbon::today();

  $user_id = Auth::id();
  $data = DB::table('pharmacists')
            ->where('user_id', $user_id)
            ->first();

  $facility = $data->premiseid;
//Get afyamessages id
    $am = DB::table('prescriptions')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
        ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
        ->select('afyamessages.id AS mid')
        ->where('prescription_details.id', '=', $id)
        ->where('afyamessages.facilityCode', '=', $facility)
        ->whereDate('afyamessages.created_at','=',$today)
        ->first();
        $afyamessage_id = $am->mid;


      $results = DB::table('prescriptions')
        ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
        //->join('route', 'prescription_details.routes', '=', 'route.id')
        ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
        ->select('druglists.drugname', 'druglists.id AS drug_id', 'prescriptions.*','prescription_details.*',
         'prescription_details.id AS presc_id','prescriptions.id AS the_id',
         'prescriptions.appointment_id','appointments.persontreated','appointments.afya_user_id')
        ->where([
          ['prescription_details.id', '=', $id]
        ])
        ->groupBy('prescription_details.id')
        ->first();

        //$appointment_id = $results->appointment_id;

        $person_treated = $results->persontreated;
        $afya_user_id = ''; //Initializing variable to make it global
        $drugs = ''; //just making this variable global for later use

        if($person_treated === 'Self')
        {

        $afya_user_id = $results->afya_user_id;

        $drugs = DB::table('prescriptions')
          ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
          ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
          ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
          ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
          //->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
          //->join('route', 'prescription_details.routes', '=', 'route.id')
          ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
          ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
           'prescription_details.id AS presc_id')
          ->where([
            ['afya_users.id', '=', $afya_user_id],
            ['prescription_filled_status.end_date', '>=', $today],
          ])
          ->groupBy('prescription_details.id')
          ->get();

        }
        else
        {
          $afya_user_id = $person_treated;

          $drugs = DB::table('prescriptions')
            ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
            ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
            ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
            //->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            //->join('route', 'prescription_details.routes', '=', 'route.id')
            ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
            'prescription_details.id AS presc_id')
            ->where([
              ['dependant_parent.dependant_id', '=', $afya_user_id],
              ['prescription_filled_status.end_date', '>=', $today],
            ])
            ->groupBy('prescription_details.id')
            ->get();

        }

        if($person_treated === 'Self')
        {

        $afya_user_id = $results->afya_user_id;

        // $diseases = DB::table('patient_diagnosis')
        //           ->join('diseases', 'patient_diagnosis.disease_id', '=', 'diseases.id')
        //           ->join('appointments', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
        //           ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
        //           ->select('diseases.name AS disease','patient_diagnosis.date_diagnosed')
        //           ->where('appointments.afya_user_id', '=' , $afya_user_id)
        //           ->get();
        }
        else
        {

        $afya_user_id = $person_treated;

        // $diseases = DB::table('patient_diagnosis')
        //           ->join('diseases', 'patient_diagnosis.disease_id', '=', 'diseases.id')
        //           ->join('appointments', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
        //           ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
        //           ->select('diseases.name AS disease','patient_diagnosis.date_diagnosed')
        //           ->where('dependant_parent.dependant_id.afya_user_id', '=' , $afya_user_id)
        //           ->get();
        }

        if($person_treated === 'Self')
        {

        $afya_user_id = $results->afya_user_id;

        // $allergies = DB::table('allergies')
        //           ->join('allergies_type', 'allergies.id', '=', 'allergies_type.allergies_id')
        //           ->join('afya_users_allergy', 'afya_users_allergy.allergies_type_id', '=', 'allergies_type.id')
        //           ->select('afya_users_allergy.created_at','allergies.name','allergies_type.name AS a_name')
        //           ->where('afya_users_allergy.afya_user_id', '=' , $afya_user_id)
        //           ->get();
        }
        else
        {

        $afya_user_id = $person_treated;

        // $allergies = DB::table('allergies')
        //           ->join('allergies_type', 'allergies.id', '=', 'allergies_type.allergies_id')
        //           ->join('afya_users_allergy', 'afya_users_allergy.allergies_type_id', '=', 'allergies_type.id')
        //           ->select('afya_users_allergy.created_at','allergies.name','allergies_type.name AS a_name')
        //           ->where('afya_users_allergy.dependant_id', '=' , $afya_user_id)
        //           ->get();
        }

      if(empty($results))
      {
        return redirect()->route('pharmacy');
      }
      else
      {
        return view('pharmacy.substitution')->with('results',$results)
        ->with('drugs',$drugs)->with('afyamessage_id',$afyamessage_id);

      }
    }


    /**
    *  Substitute drug for alternative patients
    */
    public function subPrescAlternative($id)
    {
      $today = Carbon::today();

      $user_id = Auth::id();
      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;
    //Get afyamessages id
        $am = DB::table('prescriptions')
            ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
            ->join('afya_users', 'afya_users.id', '=', 'prescriptions.afya_user_id')
            ->join('afyamessages', 'afyamessages.msisdn', '=', 'afya_users.msisdn')
            ->select('afyamessages.id AS mid')
            ->where('prescription_details.id', '=', $id)
            ->where('afyamessages.facilityCode', '=', $facility)
            ->whereDate('afyamessages.created_at','=',$today)
            ->first();
            $afyamessage_id = $am->mid;

      $results = DB::table('prescriptions')
        ->join('afya_users', 'prescriptions.afya_user_id', '=', 'afya_users.id')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
        ->join('route', 'prescription_details.routes', '=', 'route.id')
        ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
        ->select('druglists.drugname', 'druglists.id AS drug_id', 'prescriptions.*','prescription_details.*',
         'route.name','prescription_details.id AS presc_id','prescriptions.id AS the_id',
         'prescriptions.afya_user_id')
        ->where([
          ['prescription_details.id', '=', $id]
        ])
        ->groupBy('prescription_details.id')
        ->first();

        $person_treated = DB::table('prescriptions')
        ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
        ->join('dependant', 'dependant.id', '=', 'prescriptions.dependant_id')
        ->select('prescriptions.dependant_id')
        ->where('prescription_details.id', '=', $id)
        ->first();

        $afya_user_id = ''; //Initializing variable to make it global
        $drugs = ''; //just making this variable global for later use

        if(! isset($person_treated))
        {

        $afya_user_id = $results->afya_user_id;

        $drugs = DB::table('prescriptions')
          ->join('afya_users', 'afya_users.id', '=', 'prescriptions.afya_user_id')
          ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
          ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
          ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
          ->join('route', 'prescription_details.routes', '=', 'route.id')
          ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
          ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
           'route.name AS route_name','prescription_details.id AS presc_id','frequency.name AS freq_name')
          ->where([
            ['afya_users.id', '=', $afya_user_id],
            ['prescription_filled_status.end_date', '>=', $today],
          ])
          ->groupBy('prescription_details.id')
          ->get();

          if(! isset($drugs))
          {
            $drugs = DB::table('prescriptions')
              ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
              ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
              ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
              ->join('route', 'prescription_details.routes', '=', 'route.id')
              ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
              ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
               'route.name AS route_name','prescription_details.id AS presc_id','frequency.name AS freq_name')
              ->where([
                ['afya_users.id', '=', $afya_user_id],
                ['prescription_filled_status.end_date', '>=', $today],
              ])
              ->groupBy('prescription_details.id')
              ->get();
          }

        }
        else
        {
          $afya_user_id = $person_treated->dependant_id;

          $drugs = DB::table('prescriptions')
            ->join('afya_users', 'afya_users.id', '=', 'prescriptions.afya_user_id')
            ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
            ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
            ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->join('route', 'prescription_details.routes', '=', 'route.id')
            ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
             'route.name AS route_name','prescription_details.id AS presc_id','frequency.name AS freq_name')
            ->where([
              ['dependant_parent.dependant_id', '=', $afya_user_id],
              ['prescription_filled_status.end_date', '>=', $today],
            ])
            ->groupBy('prescription_details.id')
            ->get();

            if(! isset($drugs))
            {
              $drugs = DB::table('prescriptions')
                ->join('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
                ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
                ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'afya_users.id')
                ->join('prescription_details', 'prescription_details.presc_id', '=', 'prescriptions.id')
                ->join('frequency', 'frequency.id', '=', 'prescription_details.frequency')
                ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
                ->join('route', 'prescription_details.routes', '=', 'route.id')
                ->leftJoin('prescription_filled_status', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
                ->select('druglists.drugname', 'prescription_filled_status.*','prescription_details.*',
                 'route.name AS route_name','prescription_details.id AS presc_id','frequency.name AS freq_name')
                ->where([
                  ['dependant_parent.dependant_id', '=', $afya_user_id],
                  ['prescription_filled_status.end_date', '>=', $today],
                ])
                ->groupBy('prescription_details.id')
                ->get();
            }

        }

        if(! isset($person_treated))
        {

        $afya_user_id = $results->afya_user_id;

        $diseases = DB::table('patient_diagnosis')
                  ->join('diseases', 'patient_diagnosis.disease_id', '=', 'diseases.id')
                  ->join('appointments', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
                  ->join('afya_users', 'afya_users.id', '=', 'appointments.afya_user_id')
                  ->select('diseases.name AS disease','patient_diagnosis.date_diagnosed')
                  ->where('appointments.afya_user_id', '=' , $afya_user_id)
                  ->get();
        }
        else
        {

        $afya_user_id = $person_treated->dependant_id;

        $diseases = DB::table('patient_diagnosis')
                  ->join('diseases', 'patient_diagnosis.disease_id', '=', 'diseases.id')
                  ->join('appointments', 'appointments.id', '=', 'patient_diagnosis.appointment_id')
                  ->join('dependant_parent', 'dependant_parent.afya_user_id', '=', 'appointments.afya_user_id')
                  ->select('diseases.name AS disease','patient_diagnosis.date_diagnosed')
                  ->where('dependant_parent.dependant_id', '=' , $afya_user_id)
                  ->get();
        }

        if(! isset($person_treated))
        {

        $afya_user_id = $results->afya_user_id;

        $allergies = DB::table('allergies')
                  ->join('allergies_type', 'allergies.id', '=', 'allergies_type.allergies_id')
                  ->join('afya_users_allergy', 'afya_users_allergy.allergies_type_id', '=', 'allergies_type.id')
                  ->select('afya_users_allergy.created_at','allergies.name','allergies_type.name AS a_name')
                  ->where('afya_users_allergy.afya_user_id', '=' , $afya_user_id)
                  ->get();
        }
        else
        {

        $afya_user_id = $person_treated->dependant_id;

        $allergies = DB::table('allergies')
                  ->join('allergies_type', 'allergies.id', '=', 'allergies_type.allergies_id')
                  ->join('afya_users_allergy', 'afya_users_allergy.allergies_type_id', '=', 'allergies_type.id')
                  ->select('afya_users_allergy.created_at','allergies.name','allergies_type.name AS a_name')
                  ->where('afya_users_allergy.dependant_id', '=' , $afya_user_id)
                  ->get();
        }

      if(empty($results))
      {
        return redirect()->route('pharmacy');
      }
      else
      {
        return view('pharmacy.substitution')->with('results',$results)->with('drugs',$drugs)
        ->with('diseases',$diseases)->with('allergies',$allergies)->with('afyamessage_id',$afyamessage_id);
      }

    }

    public function FilledPresc()
    {

      $user_id = Auth::id();

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;

      $prescs = DB::table('prescription_filled_status')
            ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
            ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
            ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
            ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
            'prescription_details.*', 'prescription_filled_status.created_at AS date_filled', 'doctors.name AS doc', 'prescriptions.*',
            'prescriptions.created_at AS prescription_date', 'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id',
            'prescription_details.id AS pdetails_id', 'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
            ->where('prescription_filled_status.outlet_id', '=', $facility)
            ->groupBy('prescription_filled_status.id')
            ->get();

        /* Get today's sales*/
    $todays = DB::table('prescription_filled_status')
            ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
            ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
            ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
            ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
            'prescription_details.*', 'prescription_filled_status.created_at AS date_filled', 'doctors.name AS doc', 'prescriptions.*',
            'prescriptions.created_at AS prescription_date', 'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id',
            'prescription_details.id AS pdetails_id', 'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
            ->where([
              ['prescription_filled_status.outlet_id', '=', $facility],
            ])
            ->whereRaw('date(prescription_filled_status.created_at) = CURDATE()')
            ->orderby('prescription_filled_status.created_at','desc')
            ->groupBy('prescription_filled_status.id')
            ->get();

          /* Get this week's sales*/
    $weeks = DB::table('prescription_filled_status')
            ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
            ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
            ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
            ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
            ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
            ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
            ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
            'prescription_details.*', 'prescription_filled_status.created_at AS date_filled', 'doctors.name AS doc', 'prescriptions.*',
            'prescriptions.created_at AS prescription_date', 'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id',
            'prescription_details.id AS pdetails_id', 'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
            ->where([
              ['prescription_filled_status.outlet_id', '=', $facility],
            ])
            ->whereBetween('prescription_filled_status.created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
            ])
            ->orderby('prescription_filled_status.created_at','desc')
            ->groupBy('prescription_filled_status.id')
            ->get();

            /* Get this month's sales*/
      $months = DB::table('prescription_filled_status')
              ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
              ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
              ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
              ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
              ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
              'prescription_details.*', 'prescription_filled_status.created_at AS date_filled', 'doctors.name AS doc', 'prescriptions.*',
              'prescriptions.created_at AS prescription_date', 'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id',
              'prescription_details.id AS pdetails_id', 'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
              ->where([
                ['prescription_filled_status.outlet_id', '=', $facility],
              ])
              ->whereBetween('prescription_filled_status.created_at', [
              Carbon::now()->startOfMonth(),
              Carbon::now()->endOfMonth(),
              ])
              ->orderby('prescription_filled_status.created_at','desc')
              ->groupBy('prescription_filled_status.id')
              ->get();


              /* Get this year's sales*/
        $years = DB::table('prescription_filled_status')
              ->join('prescription_details', 'prescription_details.id', '=', 'prescription_filled_status.presc_details_id')
              ->join('prescriptions', 'prescriptions.id', '=', 'prescription_details.presc_id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
              ->leftJoin('appointments', 'prescriptions.appointment_id', '=', 'appointments.id')
              ->leftjoin('doctors', 'doctors.id', '=', 'appointments.doc_id')
              ->select('druglists.drugname','druglists.Manufacturer','prescription_filled_status.*',
              'prescription_details.*', 'prescription_filled_status.created_at AS date_filled', 'doctors.name AS doc', 'prescriptions.*',
              'prescriptions.created_at AS prescription_date', 'inventory.drugname AS inv_drug', 'prescriptions.id AS presc_id',
              'prescription_details.id AS pdetails_id', 'prescription_details.drug_id AS drug1', 'substitute_presc_details.drug_id AS drug2')
              ->where([
                ['prescription_filled_status.outlet_id', '=', $facility],
              ])
              ->whereBetween('prescription_filled_status.created_at', [
              Carbon::now()->startOfYear(),
              Carbon::now()->endOfYear(),
              ])
              ->orderby('prescription_filled_status.created_at','desc')
              ->groupBy('prescription_filled_status.id')
              ->get();


        return view('pharmacy.filled_prescriptions')->with('prescs',$prescs)->with('todays',$todays)
                ->with('weeks',$weeks)->with('months',$months)->with('years',$years);
    }

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $today = Carbon::today();
      $now = Carbon::now()->toDateTimeString();

      $user_id = Auth::user()->id;

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;
      $the_id = $request->p_id;
      $afyamessage_id = $request->afyamessage_id;

      $id = $request->presc_id;
      $dose1 = $request->dose_given1;
      $dose2 = $request->dose_given2;
      $reason = $request->reason22;
      $reason2 = $request->reason; //substitution reason
      $quantity = $request->quantity;
      $price = $request->price;
      $available = $request->availability;
      $total =$request->total;

      if($available == 'Yes')
      {

      $markup = $request->payment_options1;
      }
      else
      {

      $markup = $request->payment_options;
      }

      if(empty($reason))
      {
        $reason = NULL;
      }
      else
      {
        $reason = $reason;
      }

      $strength = $request->dose_given2;
      // $frequency = $request->frequency;
      // $strength_unit = $request->strength_unit;
      // $route = $request->routes;
      $drug = $request->prescription;
      $quantity1 = $request->quantity1;
      $price1 = $request->price1;
      $total1 =$request->total1;

      $start_date1 = date('Y-m-d',strtotime($request->from1));
      $end_date1 = date('Y-m-d',strtotime($request->to1));
      $start_date2 = date('Y-m-d',strtotime($request->from2));
      $end_date2 = date('Y-m-d',strtotime($request->to2));

      $user_id = Auth::id();

      $data = DB::table('pharmacists')
                ->where('user_id', $user_id)
                ->first();

      $facility = $data->premiseid;

      $pay_op = DB::table('payment_options')->distinct()
                   ->join('pharmacy_payment', 'pharmacy_payment.option_id', '=', 'payment_options.id')
                   ->where([
                     ['pharmacy_payment.pharmacy_id', '=', $facility],
                     ['pharmacy_payment.markup', '=', $markup],
                   ])
                   ->first(['payment_options.name']);
      $pay_op = $pay_op->name;


      if($available == 'Yes')
      {

      DB::table('prescription_filled_status')->insert(
      ['presc_details_id'=>$id,
     'available'=>$available,
     'dose_given'=>$dose1,
     'dose_reason'=>$reason,
     'quantity'=>$quantity,
     'price'=>$price,
     'total'=>$total,
     'payment_option'=>$pay_op,
     'markup'=>$markup,
     'outlet_id'=>$facility,
     'submitted_by'=>$user_id,
     'start_date'=>$start_date1,
     'end_date'=>$end_date1,
     'created_at'=>Carbon::now(),
     'updated_at'=> Carbon::now()
     ]
      );

      //Update afyamessages to status 1
      DB::table('afyamessages')
                ->where('id', $afyamessage_id)
                ->update(
                  ['status' => 1, 'updated_at'=> $now]
                );

      /* Get total amount of that specific drug that has been given  */
      $query1 = DB::table('prescription_filled_status')
              ->select(DB::raw('SUM(dose_given) AS total_given'))
              ->where('presc_details_id','=',$id)
              ->first();
      $count1 = $query1->total_given;


      /* Get the prescribed strength of the drug($id) */
      $query2 = DB::table('prescription_details')
              ->where('id', '=', $id)
              ->first();
      $count2 = $query2->strength;

      if($count1 == $count2) //this means the dosage for this drug($id) has been given in full.
      {
        DB::table('prescription_details')
                  ->where('id', $id)
                  ->update(
                    ['is_filled' => 1, 'updated_at'=> $now]
                  );

      $counter1 = DB::table('prescription_details')
                  ->select(DB::raw('count(is_filled) as count1'))
                  ->where([
                    ['presc_id', '=', $the_id],
                    ['is_filled', '=', 2],
                  ])
                  ->orWhere(function ($query) use($the_id) {
                    $query->where('presc_id', '=', $the_id)
                          ->where('is_filled', '=', 0);
                })
                  ->first();

      $counter11 = $counter1->count1;

        if($counter11 > 0)  // There are partially filled drugs in the general prescription
        {
          DB::table('prescriptions')
                    ->where('id', $the_id)
                    ->update(
                      ['filled_status' => 2, 'updated_at'=> $now]
                    );
        }

        else
        {

            DB::table('prescriptions')
                      ->where('id', $the_id)
                      ->update(
                        ['filled_status' => 1, 'updated_at'=> $now]
                      );
          }

      }
      else
      {
        DB::table('prescription_details')
                  ->where('id', $id)
                  ->update(
                    ['is_filled' => 2, 'updated_at'=> $now]
                  );


        $counter1 = DB::table('prescription_details')
                    ->select(DB::raw('count(is_filled) as count1'))
                    ->where('presc_id', '=', $the_id)
                    ->whereIn('is_filled', [1,2])
                    ->orWhere(function ($query) use($the_id) {
                      $query->where('presc_id', '=', $the_id)
                            ->whereIn('is_filled', [1,2])
                            ->where('is_filled', '=', 0);
                  })
                    ->first();

        $counter11 = $counter1->count1;

          if($counter11 >= 0)  // There are both partially & fully filled drugs in the general prescription
          {
            DB::table('prescriptions')
                      ->where('id', $the_id)
                      ->update(
                        ['filled_status' => 2, 'updated_at'=> $now]
                      );
          }
          else
          {

              DB::table('prescriptions')
                        ->where('id', $the_id)
                        ->update(
                          ['filled_status' => 1, 'updated_at'=> $now]
                        );
            }
      }

    }

    else //substitution takes place
    {

      if(isset($drug))
      {
    $idd=  DB::table('substitute_presc_details')->insertGetId(
    [
     'drug_id'=>$drug,
     'strength'=>$strength,
     // 'routes'=>$route,
     // 'frequency'=>$frequency,
     // 'strength_unit'=>$strength_unit,
     'created_at'=>Carbon::now(),
     'updated_at'=> Carbon::now()
   ]
    );
  }

    DB::table('prescription_filled_status')->insert(
  ['presc_details_id'=>$id,
   'available'=>'No',
   'dose_given'=>$dose2,
   'quantity'=>$quantity1,
   'price'=>$price1,
   'total'=>$total1,
   'payment_option'=>$pay_op,
   'markup'=>$markup,
   'outlet_id'=>$facility,
   'submitted_by'=>$user_id,
   'substitute_presc_id'=>$idd,
   'substitution_reason'=>$reason2,
   'start_date'=>$start_date2,
   'end_date'=>$end_date2,
   'created_at'=>Carbon::now(),
   'updated_at'=> Carbon::now()
 ]
  );

  //Update afyamessages to status 1
  DB::table('afyamessages')
            ->where('id', $afyamessage_id)
            ->update(
              ['status' => 1, 'updated_at'=> $now]
            );

  DB::table('prescription_details')
            ->where('id', $id)
            ->update(
              ['is_filled' => 1, 'updated_at'=> $now]
            );

            $counter1 = DB::table('prescription_details')
                        ->select(DB::raw('count(is_filled) as count1'))
                        ->where([
                          ['presc_id', '=', $the_id],
                          ['is_filled', '=', 2],
                        ])
                        ->orWhere(function ($query) use($the_id) {
                          $query->where('presc_id', '=', $the_id)
                                ->where('is_filled', '=', 0);
                      })
                        ->first();

            $counter11 = $counter1->count1;

              if($counter11 > 0)  // There are partially filled drugs in the general prescription
              {
                DB::table('prescriptions')
                          ->where('id', $the_id)
                          ->update(
                            ['filled_status' => 2, 'updated_at'=> $now]
                          );
              }

          	  else //All prescription_details is_filled for this prescription are 1 hence prescription is fully filled
              {
          	  DB::table('prescriptions')
                            ->where('id', $the_id)
                            ->update(
                              ['filled_status' => 1, 'updated_at'=> $now]
                            );
                }

  }


  return redirect()->action('PharmacyController@show',[$the_id]);
    }

    public function totalsales()
    {
        $today = Carbon::today();
      $patients=DB::table('afya_users')
->Join('prescription_filled_status', 'afya_users.id', '=', 'prescription_filled_status.presc_id')
->Join('druglists','prescription_filled_status.drug_id','=','druglists.id')
->select('afya_users.*','prescription_filled_status.*','druglists.*')
->where('prescription_filled_status.date','>=',$today)
->get();
        return view('pharmacy.totalsales')->with('patients',$patients);
    }

    public function fdrugs(Request $request)
     {
         $term = trim($request->q);
      if (empty($term))
        {
           return \Response::json([]);
        }
       $drugs = Inventory::search($term)->limit(20)->get();

         $formatted_drugs = [];
          foreach ($drugs as $drug)
          {
             $formatted_drugs[] = ['id' => $drug->drug_id, 'text' => $drug->drugname];
          }
     return \Response::json($formatted_drugs);
     }

     public function initialdrugs(Request $request)
      {
          $term = trim($request->q);
       if (empty($term))
         {
            return \Response::json([]);
         }
        $drugs = Druglist::search($term)->limit(30)->get();

           $formatted_drugs = [];
           foreach ($drugs as $drug)
           {
              $formatted_drugs[] = ['id' => $drug->id, 'text' => $drug->drugname];
           }
      return \Response::json($formatted_drugs);
      }

/**
* Get suppliers
*/
     public function fetchSuppliers(Request $request)
      {

          $term = trim($request->q);
       if (empty($term))
         {
            return \Response::json([]);
         }
        $suppliers = DrugSuppliers::search($term)->limit(20)->get();

          $formatted_suppliers = [];
           foreach ($suppliers as $supplier)
           {
              $formatted_suppliers[] = ['id' => $supplier->id, 'text' => $supplier->name];
           }
      return \Response::json($formatted_suppliers);
      }

      /**
      * Get doctors
      */
           public function getDaktari(Request $request)
            {

                $term = trim($request->q);
             if (empty($term))
               {
                  return \Response::json([]);
               }
              $docs = Doctor::search($term)->limit(20)->get();

                $formatted_docs = [];
                 foreach ($docs as $doc)
                 {
                    $formatted_docs[] = ['id' => $doc->id, 'text' => $doc->name];
                 }
            return \Response::json($formatted_docs);
            }

     public function trySomething(Request $request)
     {
       $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("inventory")
            		->select("drugname","drug_id")
            		->where('drugname','LIKE',"%$search%")
            		->get();
        }

        return response()->json($data);
     }

     //SearchController.php
public function autocomplete()
{
	$term = Input::get('term');

	$results = array();

	$queries = DB::table('druglists')
		->where('drugname', 'LIKE', '%'.$term.'%')
		->get();

	foreach ($queries as $query)
	{
	    $results[] = [ 'id' => $query->id, 'value' => $query->drugname ];
	}
return Response::json($results);
  }

  public function find(Request $request)
  {
      return User::search($request->get('q'))->with('profile')->get();
  }

  /**
  *Inventory stuff
  */
  public function getManufacturer(Request $request)
  {
    $term = trim($request->q);
 if (empty($term))
   {
      return \Response::json([]);
    }
  $manufacturers = Druglist::search($term)->limit(20)->get();

    $manus = [];
     foreach ($manufacturers as $manufacturer)
     {
        $manus[] = ['id' => $manufacturer->id, 'text' => $manufacturer->Manufacturer];
     }
     return \Response::json($manus);

  }

  /**
  *Display all inventory
  */
  public function showInventory()
  {
    $inventory = DB::table('inventory')
                ->join('druglists','druglists.id','=','inventory.drug_id')
                ->join('strength','strength.strength','=','inventory.strength')
                ->select('druglists.Manufacturer','druglists.drugname','inventory.created_at AS entry_date','inventory.id AS inv_id',
                'druglists.id AS drug_id','strength.strength','inventory.*','inventory.id AS inventory_id')
                ->where([
                  ['inventory.quantity', '>', 0],
                  ['is_active', '=', 'yes'],
                ])
                ->groupBy('inventory.drug_id')
                ->orderBy('inventory.created_at', 'desc')
                ->get();


                $stock = '';
          foreach($inventory as $invent)
          {
      $drug_id = $invent->drug_id;

      $stock = DB::table('inventory')
                  ->join('druglists','druglists.id','=','inventory.drug_id')
                  ->join('strength','strength.strength','=','inventory.strength')
                  ->where([
                    ['inventory.quantity', '>', 0],
                    ['is_active', '=', 'yes'],
                    ['inventory.drug_id' , '=', $drug_id],
                  ])
                  ->sum('inventory.quantity');
                }

    return view('pharmacy.inventory')->with('inventory',$inventory);
  }

  /**
  * Store new inventory
  */
  public function addStock(Request $request)
  {
    $user_id = Auth::user()->id;

    $data = DB::table('pharmacists')
              ->where('user_id', $user_id)
              ->first();

    $facility = $data->premiseid;

    //$manufacturer = $request->manufacturer;

    $drug = $request->prescription;
    $supplier = $request->supplier;
    $strength = $request->strength;
    $strength_unit = $request->strength_unit;
    $quantity = $request->quantity;
    $price = $request->price;
    $retail_price = $request->retail_price;

    //get drug name. this will be useful during searching drug for substitution
    $dname = DB::table('druglists')
            ->select('drugname')
            ->where('id', '=', $drug)
            ->first();
    $drug_name = $dname->drugname;

    $id1 = DB::table('inventory')->insertGetId([
      'drug_id'=>$drug,
      'supplier'=>$supplier,
      'drugname'=>$drug_name,
      'strength'=>$strength,
      'strength_unit'=>$strength_unit,
      'quantity'=>$quantity,
      'price'=>$price,
      'recommended_retail_price'=>$retail_price,
      'submitted_by'=>$user_id,
      'outlet_id'=>$facility,
      'is_active'=>'yes',
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);

    DB::table('inventory_updates')->insert(
      [
      'drug_id'=>$drug,
      'created_at'=>Carbon::now()
      ]
    );


    return redirect()->action('PharmacyController@showInventory');
  }

  public function getInventory(Request $request)
  {
    $idd = $request->selector;

    if($request->submit_edit)
    {
    return view('pharmacy.edit_inventory')->with('idd',$idd);
    }
    elseif($request->submit_update)
    {
    return view('pharmacy.update_inventory')->with('idd',$idd);
    }
    elseif($request->submit_delete)
    {
    return view('pharmacy.delete_inventory')->with('idd',$idd);
    }

  }

  public function getInventory2($id)
  {
    $inventory = DB::table('inventory')
                ->join('druglists','druglists.id','=','inventory.drug_id')
                ->join('strength','strength.strength','=','inventory.strength')
                ->select('druglists.Manufacturer','druglists.drugname',
                'druglists.id AS drug_id','strength.strength','inventory.*','inventory.id AS inventory_id')
                ->where([
                  ['inventory.id', '=', $id],
                  ['is_active', '=', 'yes'],
                ])
                ->get();

    return view('pharmacy.update_inventory')->with('inventory',$inventory);
  }

  public function editedInventory(Request $request)
  {
    $user_id = Auth::user()->id;

    $data = DB::table('pharmacists')
              ->where('user_id', $user_id)
              ->first();

    $facility = $data->premiseid;
    $id = $request->inventory_id;
    $count = count($id);

    for($i=0; $i<$count; $i++)
    {
      $drug = $request->prescription;
      $strength = $request->strength;
      $strength_unit = $request->strength_unit;
      $quantity = $request->quantity;
      $price = $request->price;
      $supplier = $request->supplier;
      $retail_price = $request->retail_price;

      $dname = DB::table('druglists')
              ->select('drugname')
              ->where('id', '=', $drug[$i])
              ->first();
      $drug_name = $dname->drugname;

    DB::table('inventory')
                    ->where('id', '=', $id[$i])
                    ->update([
                      'drug_id'=>$drug[$i],
                      'drugname'=>$drug_name,
                      'strength'=>$strength[$i],
                      'strength_unit'=>$strength_unit[$i],
                      'quantity'=>$quantity[$i],
                      'price'=>$price[$i],
                      'recommended_retail_price'=>$retail_price[$i],
                      'supplier'=>$supplier[$i],
                      'submitted_by'=>$user_id,
                      'outlet_id'=>$facility,
                      'updated_at'=>Carbon::now()
                    ]);

      }

    return redirect()->action('PharmacyController@showInventory');
  }

  public function updateInventory(Request $request)
  {

    //$inv = $request->inventory_id;
    $id = $request->id;
    $quantity = $request->quantity;
    $drug_id = $request->drug_id;

    $user_id = Auth::user()->id;

    $data = DB::table('pharmacists')
              ->where('user_id', $user_id)
              ->first();

    $facility = $data->premiseid;

    $count = count($drug_id);
//the old update status updated to 0 and the new insert will have 1 to show it is the latest
    for($i=0;$i<$count;$i++)
    {
      DB::table('inventory_updates')->where('id','=', $id[$i])
      ->update([
        'status'=>0,
        'updated_at'=>Carbon::now()
      ]);

    DB::table('inventory_updates')
    ->insert([
      'drug_id'=>$drug_id[$i],
      'quantity'=>$quantity[$i],
      'status'=>1, //this is latest inventory update
      'submitted_by'=>$user_id,
      'outlet_id'=>$facility,
      'created_at'=>Carbon::now(),
      'updated_at'=>Carbon::now()
    ]);

    }

    return redirect()->action('PharmacyController@showInventory');
  }

  public function deleteInventory(Request $request)
  {
    $user_id = Auth::user()->id;
    $id = $request->inventory_id;
    $count = count($id);

    for($i=0;$i<$count;$i++)
    {
    $results = DB::table('inventory')
          ->where('id', '=', $id[$i])
          ->update([
            'is_active'=>'deleted',
            'deleted_by'=>$user_id,
            'updated_at'=>Carbon::now()
          ]);

    }

    return redirect()->action('PharmacyController@showInventory');

  }


  public function inventoryReport()
  {
    $reports = DB::table('prescription_filled_status')
              ->join('prescription_details', 'prescription_filled_status.presc_details_id', '=', 'prescription_details.id')
              ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
              ->leftJoin('inventory', 'inventory.drug_id', '=', 'druglists.id')
              ->leftJoin('inventory_updates', 'inventory_updates.drug_id', '=', 'inventory.drug_id')
              ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
              ->select('prescription_filled_status.id','prescription_filled_status.quantity',
              'inventory.quantity AS inv_qty', 'inventory_updates.quantity AS inv_qty2',
              'druglists.drugname', 'prescription_filled_status.available')
              ->get();

      return view('pharmacy.inventory_report')->with('reports',$reports);
  }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }


    public function Available(){
 return view('pharmacy.available');
    }


    public function Analytics(){
      return view('pharmacy.analytics');
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


    public function receipts($id)
    {
      $receipt = DB::table('prescription_details')
               ->join('prescriptions','prescriptions.id','=','prescription_details.presc_id')
               ->join('prescription_filled_status','prescription_filled_status.presc_details_id','=','prescription_details.id')
               ->join('pharmacy','pharmacy.id','=','prescription_filled_status.outlet_id')
               ->join('druglists', 'prescription_details.drug_id', '=', 'druglists.id')
               ->leftJoin('substitute_presc_details', 'substitute_presc_details.id', '=', 'prescription_filled_status.substitute_presc_id')
               ->leftJoin('inventory', 'substitute_presc_details.drug_id', '=', 'inventory.drug_id')
               ->select('druglists.drugname', 'prescription_filled_status.quantity','prescription_filled_status.price',
                'prescription_filled_status.total','prescription_filled_status.dose_given as dose',
                'pharmacy.name as pname','pharmacy.county as pcounty','pharmacy.town as ptown',
                'prescription_filled_status.created_at', 'inventory.drugname AS inv_drug', 'druglists.Manufacturer',
                'prescription_filled_status.available', 'substitute_presc_details.drug_id AS drug2')
                ->where('prescription_details.id', '=', $id)
                ->first();

      //$manufacturer=DB::table('druglists')->where('id',$receipt->drug_id)->first();

         $dy=$receipt->created_at;
         $dys=date("d-M-Y", strtotime( $dy));
         $last = $id;
         $last ++;

         $number = sprintf('%07d', $last);

   return view('pharmacy.receipt')->with('receipt',$receipt)->with('dys',$dys)->with('number',$number);

    }

}
