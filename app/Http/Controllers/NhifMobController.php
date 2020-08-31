<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Facility;
use App\Http\Models\Branch;
use App\Http\Models\SubCategory;
use App\Http\Models\Category;
use App\Http\Models\NhifEmployer;
use App\Http\Models\NhifUser;
use App\Http\Models\NhifEmployee;
use App\Http\Models\NhifDependent;
use DB;

class NhifMobController extends Controller {
    
    public function getPredetails() {
        $counties = Branch::select('county as name')->groupby('county')->get();
        $nearestNhifBranches = Branch::get();
        $categories = Category::all();
        $subCategories = SubCategory::all();     
        return json_encode(array(
            'counties' => $counties,
            'branches' => $nearestNhifBranches,
            'categories' => $categories,
            'sub_categories' => $subCategories
        ));
    }
    
    public function getNhifEmployee(Request $request) {
        $id = $request->input('user');
        $user = NhifUser::join('nhif_employees', 'nhif_employees.user_id', '=', 'nhif_users.id')->join('facilities', 'nhif_users.nearest_nhif','=', 'facilities.id')->where('nhif_users.afyapepe_user', $id)->first();
        return json_encode($user);
    }
    
    public function getNhifEmployer(Request $request) {
        $id = $request->input('user');
        $user = NhifUser::join('nhif_employers', 'nhif_employers.user_id', '=', 'nhif_users.id')->join('facilities', 'nhif_users.nearest_nhif','=', 'facilities.id')->where('nhif_users.afyapepe_user', $id)->first();
        return json_encode($user);
    }

    public function registerUser(Request $request) {
        $userJson = $request->input('details');
        $user = json_decode($userJson);
        $docFile = $request->file('file');
        $passport = $request->file('file1');
        $type = $request->input('type');
        
        $docPath = uniqid() . '.' . $docFile->getClientOriginalExtension();
        $docFile->move(public_path() . '/nhif_documents/', $docPath);
        
        $nhifUser = new NhifUser();
        $nhifUser['afyapepe_user'] = $user->afyapepe_user;
        $nhifUser['po_box'] = $user->po_box;
        $nhifUser['postal_code'] = $user->postal_code;
        $nhifUser['postal_address'] = $user->postal_address;
        $nhifUser['telephone_number'] = $user->telephone_number;
        $nhifUser['email'] = $user->email;
        $nhifUser['type'] = $type;
        $nhifUser['town'] = $user->town;
        $nhifUser['nearest_nhif'] = $user->nearest_nhif;
        $nhifUser['id_document'] = $docPath;
        $nhifUser->save();
        
        switch($type) {
            case 3:
                $passportPath = uniqid() . '.' . $docFile->getClientOriginalExtension();
                $passport->move(storage_path() . '/nhif_passports/', $passportPath);
                
                NhifEmployee::create([
                    'user_id' => $nhifUser->id,
                    'employer_code' => $user->employer_code,
                    'employer_name' => $user->employer_name,
                    'employer_pin' => $user->employer_pin,
                    'id_type' => $user->id_type,
                    'id_number' => $user->id_number,
                    'id_serial_number' => $user->id_serial_number,
                    'first_name' => $user->first_name,
                    'other_name' => $user->other_name,
                    'dob' => $user->afyapepe_user,
                    'gender' => $user->gender,
                    'marital_status' => $user->marital_status,
                    'passport' => $passportPath
                ]);
                break;
            case 2:
                $passportPath = uniqid() . '.' . $docFile->getClientOriginalExtension();
                $passport->move(storage_path() . '/nhif_passports/', $passportPath);
                NhifEmployee::create([
                    'user_id' => $nhifUser->id,
                    'id_type' => $user->id_type,
                    'id_number' => $user->id_number,
                    'id_serial_number' => $user->id_serial_number,
                    'first_name' => $user->first_name,
                    'other_name' => $user->other_name,
                    'dob' => $user->afyapepe_user,
                    'gender' => $user->gender,
                    'marital_status' => $user->marital_status,
                    'passport' => $passportPath
                ]);
                break;
            case 1:
                $pinPath = uniqid() . '.' . $passport->getClientOriginalExtension();
                $passport->move(storage_path() . '/nhif_pins/', $pinPath);

                NhifEmployer::create([
                    'user_id' => $nhifUser->id,
                    'registration_cert_number' => $user->registration_cert_number,
                    'organisation_name' => $user->organisation_name,
                    'kra_pin' => $user->kra_pin,
                    'road' => $user->road,
                    'building' => $user->building,
                    'no_of_emp' => $user->no_of_emp,
                    'business_type' => $user->business_type,
                    'sector' => $user->sector,
                    'category' => $user->category,
                    'sub_category' => $user->sub_category,
                    'pin_document' => $pinPath
                ]);
                break;
        }
        
    }
    
    public function limits() {
        $data = array(
            'o_nhif_limit' => 200,
            'o_nhif_used' => 100,
            'o_nhif_available' => 100,
            'i_nhif_limit' => 200,
            'i_nhif_used' => 100,
            'i_nhif_available' => 100
        );
        return json_encode($data);
    }
    
    public function addDependent(Request $request) {
        $docFile = $request->file('file');
        $passport = $request->file('file1');
        $userJson = $request->input('details');
        $dependent = json_decode($userJson);
        $docPath = "";
        $passportPath = "";
        if($docFile != null) {
            $docPath = uniqid() . '.' . $docFile->getClientOriginalExtension();
            
            $docFile->move(public_path() . '/nhif_documents/', $docPath);            
        }
        if($passport != null) {
            $passportPath = uniqid() . '.' . $docFile->getClientOriginalExtension();
            $passport->move(storage_path() . '/nhif_passports/', $passportPath);       
        }

        NhifDependent::create([
           'principal' => $dependent->principal,
            'dob' => $dependent->dob,
            'surname' => $dependent->surname,
            'phone' => $dependent->phone,
            'othername' => $dependent->othername,
            'type' => $dependent->code,
            'identification' => $dependent->identification,
            'gender' => $dependent->gender,    
            'facility' => $dependent->facility,    
            'id_document' => $docPath, 
            'passport' => $passportPath
        ]);
        
    }
    
    public function updateUserFacility(Request $request) {
        $user = $request->input('patient');
        $facility = $request->input('facility');
        
        NhifUser::where('afyapepe_user', $user)->update([
            'nearest_nhif' => $facility
        ]);
        
        return json_encode(Facility::where('id', $facility)->first());
        
    }
    
    public function getDependents(Request $request) {
        $user = $request->input('user');
        $data = array();
        
        $dependents = NhifDependent::where('principal', $user)->orderby('type', 'asc')->get();

        return json_encode($dependents);
        
    }
    
    public function getDependent(Request $request) {
        $user = $request->input('dependent');
        $data = array();
        
        $dependent = NhifDependent::where('id', $user)->first();

        $data['id'] = $dependent['id'];
        $data['principal'] = $dependent['principal'];
        $data['dob'] = $dependent['dob'];
        $data['type'] = $dependent['type'];
        $data['surname'] = $dependent['surname'];
        $data['phone'] = $dependent['phone'];
        $data['othername'] = $dependent['othername'];
        $data['code'] = $dependent['code'];
        $data['identification'] = $dependent['identification'];
        $data['gender'] = $dependent['gender'];
        $data['facility'] = $dependent['facility'];
        $data['id_document'] = $dependent['id_document'];
        $data['passport'] = $dependent['passport'];
        $data['hospital'] = Facility::where('id', '=', $dependent['facility'])->first()['hospital'];
        
        return json_encode($data);
        
    }
    
    public function chooseFacility(Request $request) {
        $passport = $request->file('file1');
        $passportPath = "";
        $userJson = $request->input('details');
        $user = json_decode($userJson);
        if($passport != null) {
            $passportPath = uniqid() . '.' . $passport->getClientOriginalExtension();
            $passport->move(storage_path() . '/nhif_passports/', $passportPath);       
        }
        
        NhifDependent::where('id', $user->name)->update([
           'facility' => $user->id,
            'passport' => $passportPath
        ]);
        echo $user->id;
    }
    
    public function changeFacility(Request $request) {
        $userJson = $request->input('details');
        $details = json_decode($userJson);
//        dd($details);
        $from = NhifDependent::where('id', $details->id)->first()['facility'];
        $to = $details->facility;
        DB::table("nhif.nhif_facility_changes")->insert([
            'from' => $from,
            'to' => $to,
            'user' => $details->id,
            'reasons' => json_encode($details->reasons)
        ]);
        NhifDependent::where('id', $details->id)->update([
           'facility' => $details->facility,
        ]);
    }
    
    public function getFacilities() {
        $facilities = Facility::orderby('hospital', 'asc')->get();
        return json_encode($facilities);
    }
    
    public function getFacility(Request $request) {
        $patient = $request->input("patient");
        $id = NhifUser::where('afyapepe_user', $patient)->first()['nearest_nhif'];
        $facility = Facility::where('id', $id)->first();
        return json_encode($facility);
    }
    
    public function statements() {
        $statements = array(
            array('date' => 'January 2018',
            'contributions' => array(
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 January 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 January 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 January 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
            )),
            array('date' => 'February 2018',
            'contributions' => array(
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 February 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 February 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 February 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
            )),
                  array('date' => 'March 2018',
            'contributions' => array(
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 March 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 March 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
                array(
                    'type' => 'Contribution Debit',
                    'date' => '16 March 2018',
                    'status' => '1',
                    'amount' => 500,
                    'currency' => 'Kes'
                ),
            )),
        );
        
        $details = array(
            'total' => number_format(4500),
            'currency' => "KES",
            'contributions' => $statements
        );
        
        return json_encode($details);
        
        
    }
    
}
