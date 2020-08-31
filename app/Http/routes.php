<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;




Route::get('/', function () {
Auth::logout();
Session::flush();
return view('welcome');
});
Route::get('privacy_policy', function () { return view('privacy_policy');  });

Route::get('webReg/{id}', function ($id) {
return view('web_reg')->with('id',$id);
});

Route::Post('webReg', [ 'as' => 'webReg', 'uses' => 'WebController@webReg']);



Route::auth();
Route::group(['middleware' => ['auth']], function() {

Route::get('/home', 'HomeController@index');
Route::resource('users','UserController');

Route::get('switch-user/{id}', function ($id) {
$from=Auth::user()->id;
Auth::logout();
$user = User::find($id);
Auth::login($user);
$redirect= new AuthController;
return redirect($redirect->redirectPath());

});


});
//Password reset routes

Route::get('password/reset/{token}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

//android routes getPatient


Route::get('getallpatients', 'AndroidController@getAllPatients');
Route::post('getpatients', 'AndroidController@getPatients');
Route::get('getwaitinglist', 'AndroidController@getWaitingList');
Route::post('showpatientdetails', 'AndroidController@showPatientDetails');
Route::post('getcount', 'AndroidController@getCount');
Route::post('getfee', 'AndroidController@getFee');

//Pharmacy android routes
Route::post('getprescriptions', 'PharmacyAndroidController@prescriptions');
Route::post('getInventoryReport', 'PharmacyAndroidController@inventoryReport');
// Route::get('getFilledPresc', 'PharmacyAndroidController@FilledPresc');
Route::get('getTodaysSales','PharmacyAndroidController@TodaysSales');
Route::get('getThisWeeksSales','PharmacyAndroidController@ThisWeeksSales');
Route::get('getThisMonthsSales','PharmacyAndroidController@ThisMonthsSales');
Route::get('getThisYearsSales','PharmacyAndroidController@ThisYearsSales');
Route::get('getAllSales','PharmacyAndroidController@AllSales');
Route::get('showInventory','PharmacyAndroidController@showInventory');


//Mobile Routes
//Doctor
Route::post('doctor.update', 'MDoctorsController@updateDoctor');
Route::post('doctor.reports', 'MDoctorsController@getReport');
Route::post('doctor.visits', 'MDoctorsController@getVisits');
Route::post('doctor.info', 'MDoctorsController@doctorinfo');
Route::post('doctor.patients', 'MDoctorsController@todayPatient');
Route::get('doctor.patient/{id}', 'MDoctorsController@getPatient');
Route::get('doctormessage/{id}', 'MDoctorsController@messages');
Route::post('doctor.fee', 'MDoctorsController@getFee');
Route::post('doctor.appointments', 'MDoctorsController@getAppointments');
Route::post('doctor.makeappointment', 'MDoctorsController@makeAppointment');
// Patient
Route::post('patient.authenticate','BPatientController@authenticate');
Route::post('patient.allergies','BPatientController@allergies');
Route::post('patient.vaccination','BPatientController@vaccination');
Route::post('patient.triages','BPatientController@triages');
Route::post('patient.tests','BPatientController@tests');
Route::post('patient.admits','BPatientController@admits');
Route::post('patient.expenditure_total','BPatientController@getTotalExpenditure');
Route::post('patient.expenditure','BPatientController@getExpenditure');
Route::post('patient.history','BPatientController@patientHistory');
Route::post('patient.prescriptions','BPatientController@patientPrescriptions');
Route::post('patient.make_visit','BPatientController@makeVisit');
Route::post('patient.self_reports','BPatientController@selfReports');
Route::post('patient.appointments','BPatientController@getAppointments');
Route::post('patient.appointment','BPatientController@getCurrentAppointment');
Route::post('patient.self_report','BPatientController@selfReport');
Route::post('patient.set_access','BPatientController@setAccess');
Route::post('patient.update_access','BPatientController@updateAccess');
Route::post('patient.get_accesses','BPatientController@getAccesses');
Route::post('patient.dependents','BPatientController@getDependents');
Route::post('patient.update_steps','BPatientController@updateSteps');
Route::post('patient.send_message','BPatientController@sendMessage');
Route::post('patient.send_text','BPatientController@sendTextMessage');
Route::post('patient.send_all_sms','BPatientController@insertSms');
Route::post('patient.submit_report','BPatientController@submitReport');
Route::post('patient.sign_up','BPatientController@signUp');
Route::post('patient.reset_pin','BPatientController@resetPin');
Route::post('patient.get_complaints','BPatientController@getComplaints');
Route::post('patient.get_allergies','BPatientController@getAllergies');
Route::post('patient.get_reports','BPatientController@getReports');
Route::post('patient.chats','BPatientController@getChats');
//Patient version 2
Route::post('patient.get_doctors','BPatientController@getDoctors');
Route::post('patient.set_appointment','BPatientController@setAppointment');


//Mobile messaging
//Route::post('patient.prev_chat','AfyaMobileMessaging@getPreviousChat');
//Route::post('chat.register','AfyaMobileMessaging@registerUser');
//Route::post('chat.send','AfyaMobileMessaging@sendMessage');
//Route::post('chat.users','AfyaMobileMessaging@getUsers');
//Route::post('can_chat','AfyaMobileMessaging@canChat');

//<<<<<<< HEAD
//NHIF
Route::post('nhif.details','NhifMobController@getPreDetails');
Route::post('nhif.register','NhifMobController@registerUser');
Route::post("nhif.add_spouse", 'NhifMobController@addDependent');
Route::post("nhif.get_nhif_employer", 'NhifMobController@getNhifEmployer');
Route::post("nhif.get_nhif_employee", 'NhifMobController@getNhifEmployee');
Route::post("nhif.limits", 'NhifMobController@limits');
Route::post("nhif.statements", 'NhifMobController@statements');
Route::post("nhif.dependents", 'NhifMobController@getDependents');
Route::post("nhif.dependent", 'NhifMobController@getDependent');
Route::post("nhif.choose", 'NhifMobController@chooseFacility');
Route::post("nhif.change", 'NhifMobController@changeFacility');
Route::post("nhif.facilities", 'NhifMobController@getFacilities');
Route::post("nhif.update_facility", 'NhifMobController@updateUserFacility');
Route::post("nhif.get_facility", 'NhifMobController@getFacility');
//=======
//Nhif
//Route::post('nhif.register','NhifMobController@registerUser');
//Route::post('nhif.details','NhifMobController@getPredetails');
//>>>>>>> 5f197f537fcdc35b9a1e65a3a4dcd505fa6e3ca3

Route::group(['middleware' => ['auth','role:Admin|Superadmin']], function() {
Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit']);
Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update']);
Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy']);


});
//android routes end

//Admin routes starts
Route::group(['middleware' => ['auth','role:Admin|Superadmin']], function() {
Route::resource('superadmin','SuperadminController');
Route::resource('admin','AdminController');
Route::get('facilities','AdminController@facility')->name('facilities');
Route::get('gov-facilities','AdminController@gov_facility');
Route::get('priv-facilities','AdminController@priv_facility');
Route::get('pharm-facilities','AdminController@pharmacies');
Route::get('manu-facilities','AdminController@manufacturers');
Route::get('active_facilities','FacilityController@Activefac')->name('active_facilities');

Route::get('faci-single/{facilitycode}','AdminController@faci_single');
Route::get('faci-patients','AdminController@faci_patients');
Route::get('faci-doctors','AdminController@faci_doctors');
Route::post('addfacility1','AdminController@addfacility1');
Route::post('addfacility2','AdminController@addfacility2');

Route::get('facilityAdmin','AdminController@facilityAdmin');
Route::get('addAdmin','AdminController@create');
Route::post('adminstore','AdminController@store');
Route::get('addtest','AdminController@addtest');
Route::get('addtestrady','AdminController@addtestrady');
Route::get('testcardiac','AdminController@testcardiac');
Route::get('testneurology','AdminController@testneurology');
Route::get('testprocedure','AdminController@testprocedure');









Route::post('addingtestsb','AdminController@storetestsbg');
Route::post('addingtest','AdminController@storetest');
Route::post('addingtestrdy','AdminController@storetestimaging');
Route::post('get-test-subcat','AdminController@get_test_subcat');
Route::post('addingtestcardiac','AdminController@storecardiac');
Route::post('addingtestneurology','AdminController@storeneurology');
Route::post('addingtestprocedure','AdminController@storeprocedure');




Route::get('testupdate/{id}', [ 'as' => 'teststo', 'uses' => 'AdminController@teststo']);
Route::delete('testts/{id}',['as'=>'testts.destroy','uses'=>'AdminController@destroytests']);
Route::delete('cardiac/{id}',['as'=>'test_cardiac.destroy','uses'=>'AdminController@destroycardiac']);
Route::delete('neurology/{id}',['as'=>'test_neurology.destroy','uses'=>'AdminController@destroyneurology']);
Route::delete('procedure/{id}',['as'=>'test_procedure.destroy','uses'=>'AdminController@destroyprocedure']);

Route::get('/tags/tests', 'AdminController@ftest');
Route::get('addfacility', 'AdminController@addfacc')->name('addfacility');
Route::get('testviews/{id}', [ 'as' => 'viewgrp', 'uses' => 'AdminController@viewgrp']);


Route::resource('kins','KinController');
Route::resource('facility','FacilityController');
Route::resource('county','CountyController');
Route::resource('constituency','ConstituencyController');
Route::resource('allergy','AllergyController');
Route::resource('illness','IllnessController');
Route::resource('diseases','DiseasesController');
Route::resource('chronic','ChronicController');
Route::resource('vaccine','VaccineController');



Route::get('config', function () {
return view('admin.config');
});
});
/**
* NURSE ROUTES
**/
Route::group(['middleware' => ['auth','role:Admin|Superadmin|Nurse|Private']], function() {
Route::resource('nurse','NurseController');
Route::get('all_patients', 'NurseController@users');
Route::get('waitingList', 'NurseController@wList');
Route::get('nurseappointment','NurseController@Appointment');
Route::get('calendarnurse','NurseController@Calendar');
Route::get('nurse.patientshow/{id}','NurseController@patientShow');
Route::get('nurse.createkin/{id}',['as'=>'createkin','uses'=>'NurseController@createnextkin']);
Route::get('nurse.vaccine/{id}',['as'=>'vaccinescreate','uses'=>'NurseController@vaccinescreate']);
Route::get('nurse.details/{id}',['as'=>'details','uses'=>'NurseController@details']);
Route::get('infactdetails/{id}','NurseController@infactDetails');

Route::post('reviewdetail',['as'=>'reviewdetail','uses'=>'NurseController@reviewDetail']);

Route::post('updatekin','NurseController@Updatekin');
Route::post('vaccine','NurseController@vaccine');
Route::post('updateuser','NurseController@updateUser');

Route::post('nurseupdates','NurseController@nurseUpdates');

Route::get('nurse.dependents/{id}', [ 'as' => 'nurse.dependents', 'uses' => 'NurseController@showDependents']);


Route::post('createinfantdetails','NurseController@createinfantDetails');
Route::get('immuninationchart/{id}','NurseController@immuninationChart');
Route::get('growth/{id}','NurseController@childGrowth');
Route::get('update.dependant/{id}','NurseController@updateDependant');
Route::post('Dependantupdate','NurseController@Dependantupdate');
Route::get('showpatient/{id}','NurseController@showpatient');
Route::get('immunination/{id}','NurseController@immunination');
Route::post('immunization','NurseController@storeImmunization');
Route::post('updateinfant','NurseController@updateInfant');
Route::post('nurse.nutrition','NurseController@infantNutrition');
Route::post('babydetails','NurseController@babyDetails');
Route::post('motherdetails','NurseController@motherDetails');
Route::post('allergies','NurseController@dependantAllergy');
Route::post('vitaldetails','NurseController@vitalDetails');
Route::post('disability','NurseController@patientDisability');
Route::post('abnormalities','NurseController@abnormalities');
Route::post('addfather','NurseController@addfather');
Route::post('addmother','NurseController@addmother');
Route::post('babytriage','NurseController@addBaby');
Route::get('/tag/drugs', 'NurseController@fdrugs');
Route::get('/tag/observation','NurseController@fobservation');
Route::get('/tag/symptom','NurseController@fsymptom');
Route::get('/tag/chief','NurseController@fchief');
Route::get('/tag/chronic','NurseController@fchronic');
// Route::get('nurse.existapp/{id}','NurseController@existingapp');
Route::post('createexistingdetail','NurseController@createexistingdetail');
Route::get('nurse.deexistapp/{id}','NurseController@deexistapp');
Route::post('existingdetail','NurseController@existingdetail');
Route::get('/tag/constituencyr','NurseController@findConstituencyr');
Route::get('add_allergy/{id}','NurseController@add_allergy');
Route::post('update_allergy','NurseController@update_allergy');
//Route::get('nurse.preview/{id}','NurseController@preview');
Route::post('createdetail',['as'=>'createdetail','uses'=>'NurseController@createdetails']);

Route::get('nurse.dep_preview/{id}','NurseController@dep_preview');
Route::post('update_dep_preview','NurseController@update_dep_preview');
// Route::get('add_chronic/{id}','NurseController@add_chronic');
// Route::post('update_chronic','NurseController@updatechronic');

Route::get('/ajax-subcat',function(){
$cat_id= Input::get('cat_id');
$symptoms= Symptom::where('observation_id','=',$cat_id)->get();

return Response::json($symptoms);

});


Route::resource('alcohol-history','AlcoholhistoryController');
Route::resource('smoking-history','SmokinghistoryController');
Route::resource('medical-history','MedicalhistoryController');


Route::resource('surgical-history','SurgicalproceduresController');
Route::resource('pathistory', 'PatientHistoryController');

Route::resource('med-history','MedhistoryController');



});

// Doctor routes;
Route::group(['middleware' => ['auth','role:Admin|Superadmin|Doctor|Private']], function() {
Route::resource('doctor','DoctorController');
Route::get('doctorProfile', [ 'as' => 'doctorProfile', 'uses' => 'DoctorController@DocDetails']);
Route::resource('prescription', 'PrescriptionController@store');
Route::resource('yourfees','DoctorController@fees');
Route::resource('slfrprtng','DoctorController@selfReporting');
Route::get('doctor.selfhistory', [ 'as' => 'slfrprtngHist', 'uses' => 'DoctorController@slfrprtngHist']);
Route::get('change_password', 'DoctorController@changePassword')->name('change_password');
Route::post('change_password', 'DoctorController@newPassword');
Route::get('private.show_receiptc/{id}','privateController@showPaidd')->name('private.show_receiptc');
Route::get('private.labreceipt2/{id}','privateController@showPaidlab2')->name('private.labreceipt2');
Route::get('private.radyreceipt2/{id}','privateController@showPaidrady2')->name('private.radyreceipt2');


Route::get('/tagprv/chief','NurseController@fchief');

Route::get('newpatients', [ 'as' => 'doctorpatient', 'uses' => 'DoctorController@doctorpatient']);
Route::get('doctor.main_dashboard', [ 'as' => 'doctor', 'uses' => 'DoctorController@index']);

Route::get('pendingpatients', [ 'as' => 'pending', 'uses' => 'DoctorController@pending']);
Route::get('patientadmitted', [ 'as' => 'admitted', 'uses' => 'DoctorController@Admitted']);
Route::get('testdone/{id}', [ 'as' => 'testdone', 'uses' => 'PatientController@testdone']);

// Route::get('show/{id}',['as'=>'showPatient', 'uses'=>'PatientController@showpatient'])->name('doctor.patient_details');
Route::get('doctor.show/{id}', 'PatientController@showpatient')->name('showPatient');
Route::get('doctor.history/{id}','PatientController@history')->name('patienthistory');
Route::get('doctor.patient_history/{id}','PatientController@P_history')->name('patient_history');

Route::get('doctor.patreview/{id}','PatientController@patreview')->name('patreview');
Route::get('doctor.examination/{id}','PatientController@examination')->name('examination');
Route::get('doctor.patsamury/{id}','PatientController@patsamury')->name('patsamury');
Route::get('doctor.impression/{id}','PatientController@impression')->name('impression');
Route::get('doctor.discharge/{id}','PatientTestController@discharges')->name('discharge');

Route::get('doctor.admit/{id}','PatientTestController@admit')->name('admit');
Route::get('doctor.transfering/{id}','PatientTestController@transfer')->name('transfering');
Route::get('doctor.endvisittransfer/{id}','TagController@endvisits')->name('endvisit');

Route::get('doctor.alltest/{id}','PatientTestController@alltestdata')->name('alltestes');
Route::get('doctor.prescriptions/{id}','PrescriptionController@prescriptions')->name('medicines');
Route::get('doctor.procedure/{id}','PrescriptionController@procedures')->name('procedure');
Route::get('doctor.histdetails/{id}','PatientHistoryController@histdetails')->name('doctor.histdetails');
Route::get('doctor.medicalhistdata/{id}','PatientHistoryController@histmedical')->name('doctor.medicalhistdata');

Route::get('doctor.surghistdata/{id}','PatientHistoryController@surghistdata')->name('doctor.surghistdata');
Route::get('doctor.chronichistdata/{id}','PatientHistoryController@chronichistdata')->name('doctor.chronichistdata');
Route::get('doctor.medhistdata/{id}','PatientHistoryController@medhistdata')->name('doctor.medhistdata');
Route::get('doctor.allergyhistdata/{id}','PatientHistoryController@allergyhistdata')->name('doctor.allergyhistdata');

Route::get('doctor.abnorhistdata/{id}','PatientHistoryController@abnorhistdata')->name('doctor.abnorhistdata');
Route::get('doctor.vacchistdata/{id}','PatientHistoryController@vacchistdata')->name('doctor.vacchistdata');

Route::get('doctor.impression_edit/{id}','PatientController@impedit')->name('impression_edit');
Route::get('doctor.impression_remove/{id}','PatientController@impremove')->name('impression_remove');
Route::post('impedit', 'TestsaveDocController@ImpressionEdit');

Route::get('doctor.diagnosis_edit/{id}','PatientController@diagedit')->name('diagnosis_edit');
Route::get('doctor.diagnosis_remove/{id}','PatientController@diagremove')->name('diagnosis_remove');
Route::post('diagedit', 'TestsaveDocController@diagnosisEdit');








Route::get('visit/{id}', [ 'as' => 'visit', 'uses' => 'PatientController@pvisit']);
Route::get('depvisit/{id}', [ 'as' => 'dependantvisit', 'uses' => 'PatientController@dependantvisit']);
Route::Post('admitts', [ 'as' => 'admitting', 'uses' => 'TagController@admitts']);
// Route::get('transfer/{id}', [ 'as' => 'transfering', 'uses' => 'PatientTestController@transfer']);
Route::Post('transfers', [ 'as' => 'transfer', 'uses' => 'TagController@transfers']);
// Route::get('endvisittransfer/{id}', [ 'as' => 'endvisit', 'uses' => 'TagController@endvisits']);
// Route::Post('appointment', [ 'as' => 'nxtappt', 'uses' => 'TagController@nxtappt']);


Route::get('afyauselfreport/{id}',['as'=>'afyauslfrprtng', 'uses'=>'DoctorController@afyauselfreport']);
Route::get('depselfreport/{id}',['as'=>'depslfrprtng', 'uses'=>'DoctorController@depselfreport']);

Route::Post('doctor.selfReporting2', [ 'as' => 'selftarget', 'uses' => 'DoctorController@selftargetafyauser']);
Route::Post('doctor.selfReporting2', [ 'as' => 'selftargetupdt', 'uses' => 'DoctorController@selftargetupdt']);

Route::post('doctor.smoking_store', 'PatientHistoryController@Doc_smoking')->name('doctor.smoking_store');
Route::post('doctor.medical', 'PatientHistoryController@Doc_medical')->name('doctor.medical');
Route::post('doctor.surgical', 'PatientHistoryController@Doc_surgical')->name('doctor.surgical');
Route::post('doctor.chronic', 'PatientHistoryController@Doc_chronic')->name('doctor.chronic');
Route::post('doctor.drug', 'PatientHistoryController@Doc_drug')->name('doctor.drug');
Route::post('doctor.allergy', 'PatientHistoryController@Doc_allergy')->name('doctor.allergy');
Route::post('doctor.vaccine', 'PatientHistoryController@Doc_vaccine')->name('doctor.vaccine');
Route::post('doctor.abnormal', 'PatientHistoryController@Doc_abnormal')->name('doctor.abnormal');


Route::get('/tags/tst', 'TagController@ftest');
Route::get('/docss/drugs', 'TestController@fdrugs');
Route::get('/doctor.diseases', 'DiseasesController@find');
Route::get('/facility2', 'FacilityController@ffacility');
// Route::post('conditional', 'TestsaveController@conditionald');
Route::post('summPatients', 'TestsaveDocController@summPatients');
Route::post('generalExamination', 'TestsaveController@generalExamination');
Route::post('trgpost', 'TestsaveDocController@trgpost')->name('trgpost');
Route::post('impPost', 'TestsaveDocController@ImpressionSave');
Route::post('mrPatients', 'TestsaveDocController@mrPatients');
Route::post('mrPatients2', 'TestsaveDocController@mrPatients2');
Route::post('patientreview', 'TestsaveController@patientreview');


Route::post('testsave','TestsaveDocController@store');
Route::post('otherTest','TestsaveDocController@otherimagingPost');
Route::post('Otherremove','TestsaveDocController@Otherremove');
Route::get('labtestremove/{id}',['as'=>'testlab.remov','uses'=>'TestsaveDocController@destroytest']);
Route::post('mriTest','TestsaveDocController@mriPost');
Route::post('mriTestremove','TestsaveDocController@mriTestremove');
Route::post('ctTest','TestsaveDocController@ctTest');
Route::post('ctTestremove','TestsaveDocController@ctTestremove');
Route::post('ultraTest','TestsaveDocController@ultraTest');
Route::post('ultraTestremove','TestsaveDocController@ultraTestremove');
Route::post('xrayTest','TestsaveDocController@xrayTest');
Route::post('xrayTestremove','TestsaveDocController@xrayTestremove');


Route::delete('testremove/{id}',['as'=>'test.deletes','uses'=>'PatientTestController@destroytest']);
Route::delete('imagingremove/{id}',['as'=>'imaging.deletes','uses'=>'TestsaveDocController@imagingdestroytest']);

Route::get('testremove/{id}',['as'=>'test.remov','uses'=>'PatientTestController@destroytest']);



Route::get('test-all/{id}','PatientTestController@test_all');
Route::get('doctor.test/{id}', 'PatientTestController@testdata')->name('testes');
Route::get('testImaging/{id}', [ 'as' => 'testesImage', 'uses' => 'PatientTestController@testsImaging']);
Route::get('testmri/{id}', [ 'as' => 'testesmri', 'uses' => 'PatientTestController@testdatamri']);
Route::get('testultra/{id}', [ 'as' => 'testesultra', 'uses' => 'PatientTestController@testdataultra']);
Route::get('testxray/{id}', [ 'as' => 'testesxray', 'uses' => 'PatientTestController@testdataxray']);
Route::get('otherimaging/{id}', [ 'as' => 'otherimaging', 'uses' => 'PatientTestController@testesImage']);

// Route::Post('diagnosisconfirm', [ 'as' => 'diaconf', 'uses' => 'PatientTestController@diagnosesconf']);
Route::Post('diagconfirm', [ 'as' => 'Testconfirms', 'uses' => 'PatientTestController@Testconfirm']);
Route::post('doc.labtest', 'PatientTestController2@labResult')->name('doc.labtest');


Route::get('doc.otherReport/{id}', 'PatientTestController2@otherReport')->name('otherReport');
Route::get('doc.labtestReport/{id}', 'PatientTestController2@labtestReport')->name('labtestReport');
Route::get('doc.mrireport/{id}', 'PatientTestController2@mrireports')->name('mrireport');
Route::get('doc.ctReport/{id}', 'PatientTestController2@ctreports')->name('ctreport');
Route::get('doc.ultraReport/{id}', 'PatientTestController2@ultrareports')->name('ultrareport');
Route::get('doc.xrayReport/{id}', 'PatientTestController2@xrayreports')->name('xrayreport');
Route::get('doc.cardiac/{id}', 'PatientTestController2@cardiacReport')->name('cardiacReport');
Route::get('doc.neurology/{id}', 'PatientTestController2@neurologyReport')->name('neurologyReport');
Route::get('doc.procedure/{id}', 'PatientTestController2@procedureReport')->name('procedureReport');
// Route::delete('imagingremove/{id}',['as'=>'imaging.deletes','uses'=>'TestsaveDocController@imagingdestroytest']);
 Route::delete('cardiacremove/{id}',['as'=>'cardiac.deletes','uses'=>'TestsaveDocController@destroycardiac']);
 Route::delete('neurologyremove/{id}',['as'=>'neurology.deletes','uses'=>'TestsaveDocController@destroyneurology']);
 Route::delete('procedureremove/{id}',['as'=>'procedure.deletes','uses'=>'TestsaveDocController@destroyprocedure']);

 Route::post('doc.cardiacResult', 'PatientTestController2@cardiacResult')->name('doc.cardiacResult');
 Route::post('doc.neurologyResult', 'PatientTestController2@neurologyResult')->name('doc.neurologyResult');
 Route::post('doc.procedureResult', 'PatientTestController2@procedureResult')->name('doc.procedureResult');

 Route::post('doc.cardiacupload', 'PatientTestController2@cardiacupload')->name('doc.cardiacupload');
 Route::post('doc.neurologyupload', 'PatientTestController2@neurologyupload')->name('doc.neurologyupload');
 Route::post('doc.procedureupload', 'PatientTestController2@procedureupload')->name('doc.procedureupload');



Route::post('doc.otherResult', 'PatientTestController2@otherResult')->name('doc.otherResult');
Route::post('doc.mriResult', 'PatientTestController2@mriResult')->name('doc.mriResult');
Route::post('doc.ctResult', 'PatientTestController2@ctResult')->name('doc.ctResult');
Route::post('doc.ultraResult', 'PatientTestController2@ultraResult')->name('doc.ultraResult');
Route::post('doc.xrayResult', 'PatientTestController2@xrayResult')->name('doc.xrayResult');
Route::post('doc.labResult', 'PatientTestController2@labResult')->name('doc.labResult');



Route::post('doc.otherupload', 'PatientTestController2@otherupload')->name('doc.otherupload');
Route::get('remove.otherupload/{id}', 'PatientTestController2@Removeotherupload')->name('remove.otherupload');

Route::post('doc.mriupload', 'PatientTestController2@mriupload')->name('doc.mriupload');
Route::get('remove.mriupload/{id}', 'PatientTestController2@Removemriupload')->name('remove.mriupload');
Route::post('doc.ctupload', 'PatientTestController2@ctupload')->name('doc.ctupload');
Route::get('remove.ctupload/{id}', 'PatientTestController2@Removectupload')->name('remove.ctupload');

Route::post('doc.xrayupload', 'PatientTestController2@xrayupload')->name('doc.xrayupload');
Route::get('remove.xrayupload/{id}', 'PatientTestController2@Removexrayupload')->name('remove.xrayupload');

Route::post('doc.ultraupload', 'PatientTestController2@ultraupload')->name('doc.ultraupload');
Route::get('remove.ultraupload/{id}', 'PatientTestController2@Removeultraupload')->name('remove.ultraupload');
Route::post('doc.labupload', 'PatientTestController2@labupload')->name('doc.labupload');
Route::get('remove.labupload/{id}', 'PatientTestController2@Removelabupload')->name('remove.labupload');



Route::post('doc.save', 'PatientTestController2@savetests')->name('doc.save');
Route::post('doc.regRadremove', 'PatientTestController2@Radremove')->name('doc.regRadremove');
Route::post('doc.savelab', 'PatientTestController2@storeRegLab')->name('doc.savelab');
Route::post('doc.labremove', 'PatientTestController2@labremove')->name('doc.labremove');

Route::Post('diagnosis', [ 'as' => 'confdiag', 'uses' => 'PrescriptionController@diagnoses']);
Route::Post('quickdiagnosis', [ 'as' => 'quickdiag', 'uses' => 'PrescriptionController@quickdiag']);
Route::get('doctor.diagnosis/{id}', 'PrescriptionController@Diagnosis')->name('doc.diagnosis');


Route::get('prescremove/{id}',['as'=>'prescs.deletes','uses'=>'PrescriptionController@destroypresc']);
Route::get('printpresc/{id}', 'PrescriptionController@printpresc')->name('printpresc');
Route::get('doctor.reccomendation/{id}', 'PrescriptionController@reccomendation')->name('reccomendation');


Route::post('insert-presc-detail','PrescriptionController@store');
Route::post('insert-presc2','PrescriptionController@store2F');
Route::post('insert-reco','PrescriptionController@storeRecomendation');


Route::get('disdiagnosis/{id}', [ 'as' => 'disdiagnosis', 'uses' => 'PatientTestController@disdiagnosis']);
Route::get('disprescription/{id}', [ 'as' => 'disprescription', 'uses' => 'PatientTestController@disprescription']);




Route::Post('showdischarge', [ 'as' => 'discharging', 'uses' => 'TagController@discharge']);

Route::Post('confradiolog', [ 'as' => 'confradiology', 'uses' => 'PrescriptionController@confradiology']);
Route::post('addprocedure', 'PrescriptionController@addproc');
Route::post('editprocedure', 'PrescriptionController@editproc');
Route::post('deleteprocedure', 'PrescriptionController@deleteproc');


Route::get('doctor.followup', [ 'as' => 'followup', 'uses' => 'DoctorController@followup']);
Route::get('doctor.result/{id}', [ 'as' => 'imgrslt', 'uses' => 'PatientTestController2@imgrslt']);
Route::get('doctor.tstdetails/{id}', [ 'as' => 'tstdetails', 'uses' => 'PatientTestController2@testdetails']);

Route::get('donexraydoc/{id}', [ 'as' => 'donexraydoc', 'uses' => 'TestController2@donexraydoc']);
Route::get('donemridoc/{id}', [ 'as' => 'donemridoc', 'uses' => 'TestController2@donemridoc']);
Route::get('doneultradoc/{id}', [ 'as' => 'doneultradoc', 'uses' => 'TestController2@doneultradoc']);
Route::get('donectdoc/{id}', [ 'as' => 'donectdoc', 'uses' => 'TestController2@donectdoc']);
Route::get('doctor.viewtest/{id}', [ 'as' => 'viewtestdoc', 'uses' => 'TestController2@viewtest']);
Route::get('doctor.view_test/{id}', [ 'as' => 'view_testdoc', 'uses' => 'TestController2@view_test']);
Route::get('doneotherdoc/{id}','TestController2@doneotherdoc')->name('doneotherdoc');

Route::get('doctor.prscdetails/{id}', [ 'as' => 'prscdetails', 'uses' => 'PrescriptionController@prescdetails']);
Route::get('doctor.prscdetails2/{id}', [ 'as' => 'prscdetails2', 'uses' => 'PrescriptionController@prescdetails2']);
Route::get('doctor.visit_details/{id}', [ 'as' => 'visitDetails', 'uses' => 'DoctorController@visitDetails']);
Route::get('doctor.medica_report/{id}',  'DoctorController@medica_report')->name('doctor.medica_report');
Route::get('doctor.medica_report2/{id}',  'DoctorController@medica_report2')->name('doctor.medica_report2');
Route::get('doctor.slideshow/{id}',  'DoctorController@slideshow')->name('doctor.slideshow');
Route::get('doctor.slideshow2/{id}',  'DoctorController@slideshow2')->name('doctor.slideshow2');

Route::get('doctor.edithistory/{id}',  'DoctorController@edithistory')->name('doctor.edithistory');
Route::get('doctor.edithistory2/{id}',  'DoctorController@edithistory2')->name('doctor.edithistory2');

// Route::get('appid/{appid}/tpoid/{tpoid}/ptdid/{ptdid}', ['as' => 'registrarp.others', 'uses' => 'RegistrarController@PayOthers']);


Route::get('impid/{impid}/appid/{appid}', 'DoctorController@imp_delete')->name('imp_delete');
Route::get('diagid/{diagid}/appid/{appid}','DoctorController@diag_delete')->name('diag_delete');
Route::get('cmid/{cmid}/appid/{appid}', 'DoctorController@cm_delete')->name('cm_delete');

Route::get('impid/{impid},appid/{appid}', 'DoctorController@imp2_delete')->name('imp2_delete');
Route::get('diagid/{diagid},appid/{appid}','DoctorController@diag2_delete')->name('diag2_delete');
Route::get('cmid/{cmid},appid/{appid}', 'DoctorController@cm2_delete')->name('cm2_delete');


Route::resource('calendardoc','CalendardocController');
Route::get('calendar21/{id}','CalendardocController@load')->name('appcalendar21');
Route::post('docstore','CalendardocController@store')->name('docstore');
});


/**
* Doctor END
**/
/**
* Manufacturer
**/

Route::group(['middleware' => ['auth','role:Admin|Superadmin|Manufacturer']], function() {
Route::resource('manufacturer','ManufacturerController');
Route::get('DrugSubstitution','ManufacturerController@drugsubstitution');
Route::get('Drugsales','ManufacturerController@todaysales');
Route::get('druglist', 'ManufacturerController@show');
Route::get('manuemployees','ManufacturerController@getEmployees');
Route::post('addemployee','ManufacturerController@addEmployee');
Route::get('salesrep','ManufacturerController@getSalesrep');
Route::post('addsalesrep','ManufacturerController@addSalesrep');
Route::get('manudoctor', 'ManufacturerController@manuDoctor');
Route::get('region', 'ManufacturerController@Region');
Route::get('awaycompany', 'ManufacturerController@awayCompany');
Route::get('tocompany', 'ManufacturerController@toCompany');
Route::get('manustock', 'ManufacturerController@manuStock');
Route::get('competition', 'ManufacturerController@Competition');
Route::get('Trends','ManufacturerController@Trends');
Route::get('SectorSummary','ManufacturerController@SectorSummary');
Route::post('addmanu','ManufacturerController@addManu');
Route::get('manufacturerconfig','ManufacturerController@manconfig');
Route::get('/tags/drugs', 'TestController@fdrugs');
Route::post('adddrugs','ManufacturerController@adddrugs');
Route::post('addcompany','ManufacturerController@addcompany');

Route::resource('ads','AdsController');

});

/**
* Pharmacy Routes
**/
Route::group(['middleware' => ['auth','role:Admin|Superadmin|Pharmacyadmin|Pharmacymanager']], function() {
Route::resource('pharmacy','PharmacyController');
Route::get('pharmacy/{id}', 'PharmacyController@show');
Route::get('home',[ 'as' => 'home', 'uses' => 'PharmacyController@index']);

Route::get('pharmacy.show_alternative/{id}', 'PharmacyController@showAlternative')->name('pharmacy.show_alternative');
Route::get('pharmacy.showparent/{id}', 'PharmacyController@showParent')->name('pharmacy.showparent');

Route::get('pharmacy.showdependant/{id}', 'PharmacyController@showDependant')->name('pharmacy.showdependant');
Route::get('pharmacy.add_dependant/{id}', 'PharmacyController@addDependant')->name('pharmacy.add_dependant');
Route::get('pharmacy.add_prescription/{id}', 'PharmacyController@getDepPresc')->name('pharmacy.add_prescription');

Route::post('edit_parent_dob', 'PharmacyController@editParo')->name('edit_parent_dob');
Route::post('insert_parent_dob', 'PharmacyController@insertParent')->name('insert_parent_dob');
Route::post('update_parent_dob', 'PharmacyController@updateParent')->name('update_parent_dob');

Route::post('create_alt_dependent', 'PharmacyController@insertDependant')->name('create_alt_dependent');


Route::post('presc_details', 'PharmacyController@insertPresc')->name('presc_details');
Route::post('dependant_prescription_details', 'PharmacyController@insertDependantPresc')->name('dependant_prescription_details');
Route::post('post_presc', 'PharmacyController@postPresc');
Route::get('fill_prescription/{id}', [ 'as' => 'fillpresc', 'uses' => 'PharmacyController@fillPresc']);
Route::get('alt_fill_prescription/{id}', [ 'as' => 'alt_fillpresc', 'uses' => 'PharmacyController@altFillPresc']);
Route::get('substitution/{id}', [ 'as' => 'substitution', 'uses' => 'PharmacyController@subPresc']);
Route::get('alt_substitution/{id}', [ 'as' => 'alt_substitution', 'uses' => 'PharmacyController@subPrescAlternative']);

Route::get('filled_prescriptions', ['as' => 'filled_prescriptions','uses' => 'PharmacyController@FilledPresc']);
Route::get('totalsales', 'PharmacyController@totalsales');
Route::get('available', 'PharmacyController@Available');
Route::get('analytics', 'PharmacyController@Analytics');
Route::get('/alldrugs', 'PharmacyController@initialdrugs');
Route::get('/alldoctors', 'PharmacyController@getDaktari');
Route::get('/tag/drug', 'PharmacyController@fdrugs');
Route::get('/select2', 'PharmacyController@trySomething');
Route::get('autocomplete',array('as'=>'autocomplete','uses'=>'PharmacyController@autocomplete'));
Route::get('search/autocomplete', 'PharmacyController@autocomplete');
Route::get('inventory', [ 'as' => 'inventory', 'uses' => 'PharmacyController@showInventory']);
Route::get('new_stock', function()
{
return view('pharmacy.new_stock');
}
);
Route::post('add_stock', ['as' => 'add_stock', 'uses' => 'PharmacyController@addStock']);
Route::get('/manus', 'PharmacyController@getManufacturer');

Route::post('submit_edited', ['as' => 'submit_edited', 'uses' => 'PharmacyController@editedInventory']);
Route::post('delete_inventory', ['as' => 'delete_inventory', 'uses' => 'PharmacyController@deleteInventory']);
Route::get('inventory_report', ['as' => 'inventory_report', 'uses' => 'PharmacyController@inventoryReport']);
Route::get('/supplier', 'PharmacyController@fetchSuppliers');
});

/**
*Routes for pharmacy,manager and store keeper
*/
Route::group(['middleware' => ['auth','role:Admin|Superadmin|Pharmacyadmin|Pharmacymanager|Pharmacystorekeeper']], function() {
Route::post('edit_inventory', ['as' => 'edit_inventory', 'uses' => 'PharmacyController@getInventory']);
Route::get('inventory', [ 'as' => 'inventory', 'uses' => 'PharmacyController@showInventory']);
Route::post('inventory_update', ['as' => 'inventory_update', 'uses' => 'PharmacyController@updateInventory']);
Route::get('update_inv/{id}', ['as' => 'update_inv', 'uses' => 'PharmacyController@getInventory2']);

Route::get('pharmacy_receipts/{id}','PharmacyController@receipts')->name('pharmacy_receipts');

});


Route::group(['middleware' => ['auth','role:Admin|Superadmin|Test|Doctor']], function() {
Route::resource('test','PatientTestController');
});


//Admin Routes
Route::group(['middleware' => ['auth','role:Admin|Superadmin|Patient']], function() {
Route::resource('patient','PatientController');
Route::get('PatientAllergies','PatientController@patientAllergies');
Route::get('expenditure','PatientController@Expenditure');
Route::get('patientdependants','PatientController@getDependant');
Route::get('self_reporting','PatientController@selfReporting');
Route::get('patientappointment','PatientController@patientAppointment');
Route::get('patientcalendar','PatientController@patientCalendar');
Route::get('receipts.patient/{id}','PatientController@receipts');
Route::get('patient.self/{id}','PatientController@self');
Route::get('patient.dependant/{id}','PatientController@dependant');
Route::get('patient.addselfreport/{id}','PatientController@addselfreport');
Route::post('createselfreport','PatientController@createselfreport');
Route::get('patient.dependantself/{id}','PatientController@dependantself');
Route::get('patient.dep_addselfreport/{id}','PatientController@depAddselfreport');
Route::post('createdepselfreport','PatientController@createdepselfreport');
Route::get('patient.nextkin/{id}', ['as' => 'patientdtls', 'uses' => 'PatientController@patientDetails']);
Route::post('updateBasic','PatientController@store');
Route::get('patient.tstdetails/{id}', [ 'as' => 'pattstdetails', 'uses' => 'PatientController@testdetails']);
Route::get('patient.viewtest/{id}', [ 'as' => 'viewtestpat', 'uses' => 'PatientController@viewtest']);
Route::get('patient.prscdetails/{id}', [ 'as' => 'prscdetailspat', 'uses' => 'PatientController@prescdetails']);
Route::get('patient.credentials/{id}', ['as' => 'crdents', 'uses' => 'PatientController@credentials']);
Route::post('updatecred','PatientController@Upcredentiials');
Route::get('patient.nhif', [ 'as' => 'patientnhif', 'uses' => 'PatientController@nhif']);
Route::post('nhifupload','PatientNhifController@store');

Route::get('admin.invoice/{id}','AdminController@invoice')->name('invoice');
Route::get('admin.quotation','AdminController@quotation')->name('quotation');
Route::get('billquot/{id}','AdminController@billquot')->name('billquot');
Route::post('billquots','AdminController@billquots');
Route::get('patappointments','PatientController@patappointments');
Route::post('systdoctors', 'PatientController@alldoctors' )->name('systdoctors');

});

Route::group(['middleware' => ['auth','role:Admin|Superadmin|Registrar']], function() {
  Route::get('registrar.Reg_feespay_F/{id}','RegistrarControllerF@conReg');
  Route::post('consultationfeeF','RegistrarControllerF@consultationFees');
  Route::get('registrar.show/{id}','RegistrarController@showUser');
  Route::get('registrar.consltreceiptF/{id}','RegistrarControllerF@showPaidConslt')->name('registrar.consltreceiptF');


//nguchu
Route::resource('registrar','RegistrarController');
Route::post('registrar.shows','privateController@showUser');
Route::get('registrar.shows3/{id}','privateController@showUser3');
Route::get('registrar.shows2/{id}','privateController@showUser2');
Route::get('register_edit_patient/{id}','privateController@edit_patient');
Route::get('registrar.shows_test/{id}','privateController@showUsertest');
Route::get('registrar.shows_pay/{id}','privateController@showUserpay');
Route::get('registrar.radyreceipt/{id}','RegistrarController@showPaid1')->name('registrar.radyreceipt');
Route::get('registrar.printout/{id}','RegistrarController@printout')->name('registrar.printout');
Route::get('registrar.testprint/{id}','RegistrarController@testprint')->name('registrar.testprint');
Route::get('registrar.prscprint/{id}','RegistrarController@prscprint')->name('registrar.prscprint');

Route::get('allpatients','RegistrarController@allPatients');
Route::get('registrar.select/{id}','RegistrarController@selectChoice');
Route::get('register_new_patient','RegistrarController@registerPatient');
Route::get('onboarding','RegistrarController@onboarding');
Route::post('boarding','RegistrarController@boarding');


Route::get('appointmentsmade','privateController@appointmentsmadereg')->name("reg.app1");
Route::get('paid_fees','privateController@registrarFees')->name('paid_fees');
Route::get('registrarp.medicalR/{id}','RegistrarController@medicalR');
Route::get('registrarp.Reg_feespay/{id}','RegistrarController@pconReg');
Route::post('medicalfeep','RegistrarController@medicalfeep');
Route::post('consultationfee','RegistrarController@consultationFees');
Route::get('registrar.showsapp/{id}','privateController@showUserApp');


Route::get('appid/{appid}/tpoid/{tpoid}/ptdid/{ptdid}', ['as' => 'registrarp.others', 'uses' => 'RegistrarController@PayOthers']);
Route::get('appid/{appid}/tpctid/{tpctid}/ptdid/{ptdid}', ['as' => 'registrarp.ct', 'uses' => 'RegistrarController@PayCt']);
Route::get('appid/{appid}/tpxray/{tpxray}/ptdid/{ptdid}', ['as' => 'registrarp.xray', 'uses' => 'RegistrarController@PayXray']);
Route::get('appid/{appid}/mrid/{mrid}/ptdid/{ptdid}', ['as' => 'registrarp.mri', 'uses' => 'RegistrarController@PayMri']);
Route::get('appid/{appid}/ultid/{ultid}/ptdid/{ptdid}', ['as' => 'registrarp.ultra', 'uses' => 'RegistrarController@PayUltra']);
Route::get('appid/{appid}/tp_id/{tp_id}/ptdidl/{ptdidl}',['as' => 'registrarp.labt', 'uses' => 'RegistrarController@PayLab']);
Route::get('appid/{appid}/tpcard_id/{tpcard_id}/ptdidc/{ptdidc}',['as' => 'registrarp.cardiac', 'uses' => 'RegistrarController@PayCardiac']);
Route::get('appid/{appid}/tpneuro_id/{tpneuro_id}/ptdidn/{ptdin}',['as' => 'registrarp.neurology', 'uses' => 'RegistrarController@PayNeurology']);
Route::get('appid/{appid}/tpneuro_id/{tpproc_id}/ptdidp/{ptdip}',['as' => 'registrarp.procedure', 'uses' => 'RegistrarController@PayProcedure']);
Route::post('regpaycardiac','RegistrarController@regpaycardiac');
Route::post('regpayneurology','RegistrarController@regpayneurology');
Route::post('regpayprocedures','RegistrarController@regpayprocedures');


Route::get('fees','RegistrarController@Fees')->name('fee');
Route::get('register.feespay/{id}','RegistrarController@feespay');



Route::get('registrar.histdetails/{id}','PatientRegHistoryController@histdetails')->name('registrar.histdetails');
Route::get('registrar.mhistdata/{id}','PatientRegHistoryController@histmedical')->name('registrar.medicalhistdata');
Route::get('registrar.surghistdata/{id}','PatientRegHistoryController@surghistdata')->name('registrar.surghistdata');
Route::get('registrar.chronichistdata/{id}','PatientRegHistoryController@chronichistdata')->name('registrar.chronichistdata');
Route::get('registrar.medhistdata/{id}','PatientRegHistoryController@medhistdata')->name('registrar.medhistdata');
Route::get('registrar.allergyhistdata/{id}','PatientRegHistoryController@allergyhistdata')->name('registrar.allergyhistdata');
Route::get('registrar.abnorhistdata/{id}','PatientRegHistoryController@abnorhistdata')->name('registrar.abnorhistdata');
Route::get('registrar.vacchistdata/{id}','PatientRegHistoryController@vacchistdata')->name('registrar.vacchistdata');



Route::post('registrar.smoking_store', 'PatientRegHistoryController@Doc_smoking')->name('registrar.smoking_store');
Route::post('registrar.medical', 'PatientRegHistoryController@Doc_medical')->name('registrar.medical');
Route::post('registrar.surgical', 'PatientRegHistoryController@Doc_surgical')->name('registrar.surgical');
Route::post('registrar.chronic', 'PatientRegHistoryController@Doc_chronic')->name('registrar.chronic');
Route::post('registrar.drug', 'PatientRegHistoryController@Doc_drug')->name('registrar.drug');
Route::post('registrar.allergy', 'PatientRegHistoryController@Doc_allergy')->name('registrar.allergy');
Route::post('registrar.vaccine', 'PatientRegHistoryController@Doc_vaccine')->name('registrar.vaccine');
Route::post('registrar.abnormal', 'PatientRegHistoryController@Doc_abnormal')->name('registrar.abnormal');



Route::get('registrar.Reg_feespay/{id}','RegistrarController@conReg');


Route::get('registrar.creapp/{id}','RegistrarController@creapp');
Route::get('registrar.addDependents/{id}','RegistrarController@addDependents');
Route::get('registrar.dependants/{id}','RegistrarController@selectDependant');
Route::post('updateusers','privateController@updateUsers');
Route::post('registrar_updateusers','RegistrarController@updateUsers');
Route::post('reg_updateusers','privateController@RegupdateUsers');
Route::get('registrar.histdata/{id}','privateController@histdata');
Route::post('fee_payment','RegistrarController@payConsultation');
// Route::get('reg.test','privateController@RegTests')->name('reg.test');
// Route::get('reg.test2/{id}','privateController@RegTests2')->name('reg.test2');
Route::post('reg.save','TestsaveController@imagingPost');
Route::post('regRadremove','TestsaveController@Radremove');
Route::post('reg.savelab','TestsaveController@storeRegLab');
Route::post('labremove','TestsaveController@labremove');



Route::get('registrar.show_receiptimgng/{id}','privateController@showPaid')->name('registrar.show_receiptimgng');
Route::get('registrar.show_receipt/{id}','privateController@showPaid')->name('registrar.show_receipt');


Route::get('registrar.radyreceipt2/{id}','RegistrarController@showPaid2')->name('registrar.radyreceipt2');
Route::get('registrar.labreceipt/{id}','RegistrarController@showPaidlab')->name('registrar.labreceipt');
Route::get('registrar.labreceipt2/{id}','RegistrarController@showPaidlab2')->name('registrar.labreceipt2');

Route::get('registrar.print_receipt/{id}','privateController@printReceipt')->name('registrar.print_receipt');
Route::get('registrarp.show_receipt/{id}','privateController@showPaidp')->name('registrarp.show_receipt');

Route::post('registrarnextkin','privateController@registrarNextkin');
Route::post('registrar_nextkin','RegistrarController@registrarNextkin');
Route::get('update/{id}','privateController@updateKin');
Route::post('registrarupdatekin','privateController@registrarUpdatekin');
Route::get('consultationfee/{id}','RegistrarController@consultationFee');
Route::post('nxtappt-reg','RegistrarController@nxtapptreg');
Route::post('nxtappt-reg2','RegistrarController@nxtapptreg2');

Route::post('createdependent','RegistrarController@createDependent');
Route::get('registrar.dependantTriage/{id}','RegistrarController@dependantTriage');
Route::post('Dependentconsultationfee','RegistrarController@Dependentconsultationfee');

Route::post('registeruser','RegistrarController@store');
Route::get('/tag/constituency','RegistrarController@findConstituency');

Route::get('registrar.selects/{id}','privateController@selectChoice');


Route::post('privateconsultationfee','privateController@consultationFees');
Route::get('registrar.showdependants/{id}','privateController@selectDependant');
Route::post('privateDependentconsultationfee','privateController@Dependentconsultationfee');
Route::get('private.addDependents/{id}','privateController@addDependents');
Route::post('createdeppriv','privateController@createDependent');


Route::get('/appointment_made', 'RegistrarController@appointment_made')->name("reg.app");
Route::post('regpaytest','RegistrarController@regpaytest');
Route::post('regpaytest2','RegistrarController@regpaytest2');
Route::post('regpayothers','RegistrarController@regpayothers');
Route::post('regpaylab','RegistrarController@regpaylab');



Route::get('register_edit_nextkin/{id}','RegistrarController@edit_nextkin');
Route::post('register_update_nextkin','RegistrarController@update_nextkin');
Route::get('edit_patient_details/{id}','RegistrarController@edit_patient');
Route::post('register_update_patient','privateController@update_patient');
Route::post('update_patient_details','RegistrarController@update_patient');
// Route::get('registrar.RegUpHist/{id}','PatientRegHistoryController@RegUpHist')->name('registrar.RegUpHist');
Route::post('Reg_store', 'PatientHistoryController@Reg_store');

Route::get('register.feespaytest/{id}','RegistrarController@feespaytest');
Route::get('register.feespaytest2/{id}','RegistrarController@feespaytest2');

Route::post('smoking-hprivate', 'SmokinghistoryController@storeprivate');
Route::Post('private.updatesmoking', [ 'as' => 'updatesmoking', 'uses' => 'SmokinghistoryController@updatesmoking']);


Route::post('alcohol-hprivate', 'AlcoholhistoryController@storeprivate');
Route::Post('private.updatealcohol', [ 'as' => 'updatealcohol', 'uses' => 'AlcoholhistoryController@updatealcohol']);

Route::post('medical-hprivate', 'MedicalhistoryController@storeprivate');
Route::Post('private.updatemedical', [ 'as' => 'updatemedical', 'uses' => 'MedicalhistoryController@updatemedical']);

Route::get('private.surgical/{id}',['as'=>'surgcreate','uses'=>'SurgicalproceduresController@surgicalcreate']);
Route::Post('private.procedure', [ 'as' => 'surgical-private', 'uses' => 'SurgicalproceduresController@storeprivates']);

Route::get('private.selfmedication/{id}',['as'=>'medcreate','uses'=>'MedhistoryController@selfmedcreate']);
Route::Post('private.selfmeds', [ 'as' => 'selfmeds', 'uses' => 'MedhistoryController@storeprivates']);

Route::get('private.chronic/{id}',['as'=>'croniccreate','uses'=>'MedhistoryController@chroniccreate']);
Route::post('add_chronicprvt','MedhistoryController@addchronic');
Route::get('/registrar.diseases', 'DiseasesController@find');

Route::get('private.vaccine/{id}',['as'=>'vaccreate','uses'=>'privateController@vaccinescreate']);
Route::post('vaccinesave','privateController@vaccine');

Route::get('registrar.allergy/{id}',['as'=>'reg_allergy','uses'=>'MedhistoryController@add_allergy']);
Route::post('update_allergyreg','MedhistoryController@update_allergy');
Route::get('add-parent', function (Request $request) {

});

Route::post('addParent','RegistrarController@add_parent');

Route::get('new-parent', function (Request $request) {

$data['id']=$request->id;
$data['dep_id']=$request->dep_id;

return view('registrar.new_parent',$data);

});

Route::post('add_parent_details','RegistrarController@add_parent2');

});
/**
* Test Routes
**/
Route::group(['middleware' => ['auth','role:Admin|Superadmin|Test']], function() {
Route::resource('test','TestController');
Route::get('testsales','TestController@testSales');
Route::get('testesd','TestController@testesd');
Route::get('testesdR','TestController@testesdR');
Route::get('testanalytics','TestController@testAnalytics');
Route::get('patientTests/{id}', [ 'as' => 'patientTests', 'uses' => 'TestController@testdetails']);
Route::get('testsdone/{id}', [ 'as' => 'testsdone', 'uses' => 'TestController@testsdone']);

Route::get('radTests/{id}', [ 'as' => 'pradTests', 'uses' => 'TestController@radydetails']);
Route::get('radinvoice/{id}', [ 'as' => 'radinvoice', 'uses' => 'TestController@radyinvoice']);
Route::get('labinvoice/{id}', [ 'as' => 'labinvoice', 'uses' => 'TestController@labinvoices']);
Route::post('labinvoicepay', 'TestController@labinvoicepay');

Route::get('radTestd/{id}', [ 'as' => 'radTestd', 'uses' => 'TestController@radydetaild']);

Route::get('tests.action/{id}', [ 'as' => 'perftest', 'uses' => 'TestController@actions']);
Route::get('tests.actiontransfered/{id}', [ 'as' => 'perftestTrans', 'uses' => 'TestController@actionstrans']);

Route::get('tests.testtransfer/{id}', [ 'as' => 'testtransfer', 'uses' => 'TestController@testtransfer']);
Route::Post('test.test_transfer', [ 'as' => 'transfertest', 'uses' => 'TestController@transfertest']);

Route::get('TestHistory/{id}', [ 'as' => 'viewtest', 'uses' => 'TestController@viewtest']);

Route::get('radiologyp/{id}', [ 'as' => 'perftestradio', 'uses' => 'TestController@actionxray']);
Route::get('radiomri/{id}', [ 'as' => 'perftestmri', 'uses' => 'TestController@actionmri']);
Route::get('radioultra/{id}', [ 'as' => 'perftestultra', 'uses' => 'TestController@actionultra']);
Route::get('radioct/{id}', [ 'as' => 'perftestct', 'uses' => 'TestController@actionct']);

Route::Post('test.action', [ 'as' => 'testResult', 'uses' => 'TestController@testResult']);
Route::Post('pdetails3', [ 'as' => 'testResult3', 'uses' => 'TestController@testResult3']);
Route::Post('pdetails4', [ 'as' => 'testResult4', 'uses' => 'TestController@testResult4']);
Route::Post('pdetails5', [ 'as' => 'testResult5', 'uses' => 'TestController@testResult5']);
Route::Post('pdetailsctest', [ 'as' => 'ctest', 'uses' => 'TestController@ctest']);

Route::Post('xrayreport', [ 'as' => 'xrayfindings', 'uses' => 'TestController2@xrayfindings']);
Route::Post('ctreport', [ 'as' => 'ctfindings', 'uses' => 'TestController2@ctfindings']);
Route::Post('mrireport', [ 'as' => 'mrifindings', 'uses' => 'TestController2@mrifindings']);
Route::Post('ultrareport', [ 'as' => 'ultrafindings', 'uses' => 'TestController2@ultrafindings']);

Route::Post('radiology.report', [ 'as' => 'imgreport', 'uses' => 'TestController2@imagingreports']);



Route::Post('test.report2', [ 'as' => 'testfilm', 'uses' => 'TestController@testreport']);
Route::Post('report', [ 'as' => 'testRupdt', 'uses' => 'TestController@testupdate']);

Route::get('grapher/{id}', [ 'as' => 'grapherxray', 'uses' => 'TestController@grapherxray']);
Route::get('graphermr/{id}', [ 'as' => 'graphermri', 'uses' => 'TestController@graphermri']);
Route::get('grapherct/{id}', [ 'as' => 'grapherct', 'uses' => 'TestController@grapherct']);
Route::get('grapherultra/{id}', [ 'as' => 'grapherultra', 'uses' => 'TestController@grapherultra']);
Route::post('fileUpload', ['as'=>'fileUpload','uses'=>'TestController2@fileUpload']);
Route::post('fileUploads','TestController2@fileUploads');
Route::post('fileUploade','TestController2@fileUploade');
Route::post('fileUploady','TestController2@fileUploady');

Route::get('donexray/{id}', [ 'as' => 'donexray', 'uses' => 'TestController2@donexray']);
Route::get('donemri/{id}', [ 'as' => 'donemri', 'uses' => 'TestController2@donemri']);
Route::get('doneultra/{id}', [ 'as' => 'doneultra', 'uses' => 'TestController2@doneultra']);
Route::get('donect/{id}', [ 'as' => 'donect', 'uses' => 'TestController2@donect']);


Route::post('paymentt', 'TestController2@payment');
Route::post('radypayment', 'TestController2@radypayment');
Route::get('test.testreg/{id}', [ 'as' => 'testreg', 'uses' => 'TestController2@testreg']);
Route::get('patientslct/{id}', [ 'as' => 'patientslct', 'uses' => 'TestController2@patientslct']);
// Route::get('test.adds/{id}', [ 'as' => 'moretest', 'uses' => 'TestController2@add_Test']);
Route::get('test.pinfo/{id}','TestController2@pinformation');
Route::get('test.deppinfo/{id}','TestController2@depinformation');
Route::post('uppat', 'TestController2@updatepat');
Route::post('postpatient', 'TestController2@postpat');
Route::post('postpatientdep', 'TestController2@postpatdep');
Route::post('testadd', 'TestController2@testadd');
Route::post('testadddep', 'TestController2@testadddep');

Route::get('/disis/find', 'DiseasesController@find');

Route::get('/tests/doctor','FacilityAdminController@finddoc');

Route::get('/tags/fac', 'FacilityController@ffacility');
Route::get('registrar.dependant/{id}','TestController2@selectDependant');
Route::get('test.addDependents/{id}','TestController2@addDependents');
Route::post('createdependenttest','TestController2@createDependent');
Route::get('test.show/{id}','TestController2@testsshow');
Route::get('test.depshow/{id}','TestController2@testsdepshow');
Route::get('test.remove/{id}','TestController2@destroytests');


Route::get('test.mri/{id}','TestController2@addmri');
Route::get('test.ultrasound/{id}','TestController2@addultra');
Route::get('test.ctscan/{id}','TestController2@addct');
Route::get('test.xray/{id}','TestController2@addxray');

Route::post('Radytest','TestsaveController@radiologytests');
Route::get('test.transfered', [ 'as' => 'transfered', 'uses' => 'TestController2@transfered']);


});

//FacilityAdmin Routes
Route::group(['middleware' => ['auth','role:Admin|Superadmin|FacilityAdmin']], function() {
Route::get('testranges','FacilityAdminController@testranges');
Route::post('rangesadd','FacilityAdminController@rangesadd');
Route::delete('testranges/{id}',['as'=>'ranges.destroy','uses'=>'FacilityAdminController@destroyranges']);
Route::post('updtranges','FacilityAdminController@updateranges');

Route::resource('facilityadmin','FacilityAdminController');
Route::resource('facility-finance','FacilityFinanceController');
Route::get('facilityregister','FacilityAdminController@facilityregister');
Route::get('addfacilityregister','FacilityAdminController@addfacilityregister');

Route::get('facilityusers','FacilityAdminController@facilityusers');


Route::get('facilitynurse','FacilityAdminController@facilitynurse');
Route::get('facilitydoctor','FacilityAdminController@facilitydoctor');
Route::get('facilityofficer','FacilityAdminController@facilityofficer');
Route::get('consltfee','FacilityAdminController@consltfee');
Route::get('facadmin.show_receipt/{id}','FacilityAdminController@showPaid')->name('facadmin.show_receipt');


Route::get('createdoc','FacilityAdminController@createdoc');
Route::get('/tags/doc','FacilityAdminController@finddoc');
Route::post('addfacilityregistrar','FacilityAdminController@store');
Route::post('addfacilitynurse','FacilityAdminController@storenurse');
Route::post('addfacilitydoctor','FacilityAdminController@storedoctor');
Route::Post('addfacilityofficer','FacilityAdminController@storeofficer');
Route::Post('setfees','FacilityAdminController@setfees');


Route::get('laboratory','FacilityAdminController@laboratory');
Route::post('facilitytest','FacilityAdminController@storelabtech');
Route::delete('lab/{id}',['as'=>'labtech.destroy','uses'=>'FacilityAdminController@destroylabtech']);
Route::get('techupdate/{id}', [ 'as' => 'labtechperson', 'uses' => 'FacilityAdminController@labtech']);
Route::Post('techupdate', [ 'as' => 'updatelabtech', 'uses' => 'FacilityAdminController@uplabtech']);

Route::get('alltestprices','FacilityAdminController2@alltests');
Route::get('testprices','FacilityAdminController2@readItems');
Route::post('addItem', 'FacilityAdminController2@addItem');
Route::post('editItem', 'FacilityAdminController2@editItem');
Route::get('deleteItem/{id}', 'FacilityAdminController2@RemoveItem')->name('deleteItem');


Route::get('testpricesct','FacilityAdminController2@readct');
Route::post('addct', 'FacilityAdminController2@addct');
Route::post('editct', 'FacilityAdminController2@editct');
Route::get('deletect/{id}', 'FacilityAdminController2@RemoveCt')->name('deletect');

Route::get('testpricesotherIm','FacilityAdminController2@readotherIm');
Route::post('saveother', 'FacilityAdminController2@saveother');
Route::get('deleteptoo/{id}', 'FacilityAdminController2@RemoverOop')->name('deleteptoo');



Route::get('testpricesxray','FacilityAdminController2@readxray');
Route::post('savexray', 'FacilityAdminController2@addxray');
Route::post('editxray', 'FacilityAdminController2@editxray');
Route::get('deletexray/{id}', 'FacilityAdminController2@Removexray')->name('deletexray');

Route::post('editother', 'FacilityAdminController2@editother');


Route::get('upimages','FacilityAdminController2@upimages');
Route::post('upimagespst','FacilityAdminController2@upimagespst');
Route::get('testpricesmri','FacilityAdminController2@readmri');
Route::post('addmri', 'FacilityAdminController2@addmri');
Route::post('editmri', 'FacilityAdminController2@editmri');
Route::get('deletemri/{id}', 'FacilityAdminController2@Removemri')->name('deletemri');

Route::get('testpricesultra','FacilityAdminController2@readultra');
Route::post('addultra', 'FacilityAdminController2@addultra');
Route::post('editultra', 'FacilityAdminController2@editultra');
Route::get('deleteultra/{id}', 'FacilityAdminController2@Removeultra')->name('deleteultra');

Route::get('facilityadmin.discount/{id}', [ 'as' => 'discounts', 'uses' => 'FacilityAdminController2@Discounts']);
Route::post('discountadd', 'FacilityAdminController2@adddiscounts');
Route::post('discountupdate', 'FacilityAdminController2@discountupdate');

Route::get('testpricescardiac','FacilityAdminController2@readcardiac');
Route::post('addcardiac', 'FacilityAdminController2@addCardiac');
Route::post('editcardiac', 'FacilityAdminController2@editcardiac');
Route::get('deletecardiac/{id}', 'FacilityAdminController2@Removecardiac')->name('deletecardiac');

Route::get('testpricesneurology','FacilityAdminController2@readneurology');
Route::post('addneurology', 'FacilityAdminController2@addneurology');
Route::post('editneurology', 'FacilityAdminController2@editneurology');
Route::get('deleteneurology/{id}', 'FacilityAdminController2@Removeneurology')->name('deleteneurology');

Route::get('testpricesprocedure','FacilityAdminController2@readprocedure');
Route::post('addprocedure', 'FacilityAdminController2@addprocedure');
Route::post('editprocedure', 'FacilityAdminController2@editprocedure');
Route::get('deleteprocedure/{id}', 'FacilityAdminController2@Removeprocedure')->name('deleteprocedure');






});

//PrivateDoc

Route::group(['middleware' => ['auth','role:Private|Admin|Superadmin|Doctor']], function() {
Route::resource('private','privateController');
Route::get('pwaitingp','privateController@index')->name('pwaitingp');

Route::resource('dashboardPrivate','DoctorController2@DashboardPrivate');
Route::get('pendingpatient','privateController@PendingPatient')->name('private.fees');
Route::get('private.fees','privateController@Fees')->name('private.fees');

Route::get('private.receipt/{id}','privateController@showReceipt')->name('private.receipt');
Route::get('private.print_receipt/{id}','privateController@printReceipt2')->name('private.print_receipt');
Route::get('private.show/{id}','privateController@show');
Route::get('nurseVitals/{id}','privateController@nurseVitals')->name('nurseVitals');


Route::post('addmother','NurseController@addmother');
Route::post('private.createdetail','privateController@createDetails');

Route::get('privatepatients','privateController@privatepatient')->name('privatepat');

Route::get('privateaddmited','privateController@privadmitted')->name('privadmpat');

Route::get('allpatientsDOC','privateController@allPatients')->name('allpatientsDOC');

Route::get('appointmentsmadedoc','privateController@appointmentsmade')->name('appointmentsmadedoc');
Route::get('private.dashboard','DoctorController2@DashboardPrivate')->name('privdashboard');


// Route::get('', [ 'as' => 'privdashboard', 'uses' => '']);






});


//FacilityFinance

Route::group(['middleware' => ['auth','role:Admin|Superadmin|FacilityAdmin|FacilityFinance']], function() {

Route::get('finance', function () {

return view('facilityfinance.home');
});

Route::get('payments','FacilityFinanceController@payments');
Route::get('pending','FacilityFinanceController@pending');
Route::post('paid','FacilityFinanceController@paid');
});


//Millie routes for Pharmacy
//admin
Route::post('showpharmadmininventoryreport','PharmacyAndroidController@showPharmadmininventoryreport');
Route::post('showpharmdrugs','PharmacyAndroidController@showPharmdrugs');
Route::post('showpharmsuppliers','PharmacyAndroidController@showPharmsuppliers');
//pharmacyhomepage
Route::post('pharmacyhomepage','PharmacyAndroidController@pharmacyhomepage');

//test
Route::post('prescriptions','PharmacyAndroidController@prescriptions');
Route::post('showinv','PharmacyAndroidController@showinv');

Route::post('showpharmadminprescriptions','PharmacyAndroidController@showPharmadminprescriptions');

Route::post('showpharmadmininventory','PharmacyAndroidController@showPharmadmininventory');

Route::post('showpharmadminsalestoday','PharmacyAndroidController@showPharmadminsalestoday');
Route::post('showpharmadminsalesweek','PharmacyAndroidController@showPharmadminsalesweek');
Route::post('showpharmadminsalesmonth','PharmacyAndroidController@showPharmadminsalesmonth');
Route::post('showpharmadminsalesyear','PharmacyAndroidController@showPharmadminsalesyear');
Route::post('showpharmadminsalesall','PharmacyAndroidController@showPharmadminsalesall');

Route::post('showpharmadminpresc','PharmacyAndroidController@showPharmadminpresc');
//Route::post('updateinventorymsh','PharmacyAndroidController@updateInventorymsh');


//manager
Route::post('showpharmmangerinventoryreport','PharmacyAndroidController@showPharmmangerinventoryreport');
Route::post('showpharmmanagerinventory','PharmacyAndroidController@showPharmmanagerinventory');

//storekeeper
//being re-used here also
// Route::post('showpharmadmininventory','PharmacyAndroidController@showPharmadmininventory');

//Millie routes for Manufacturer
Route::post('showmanustock','AndroidManufacturerController@showManustock');
Route::post('showmanusales','AndroidManufacturerController@showManusales');
Route::post('showmanusales1','AndroidManufacturerController@showManusales1');
Route::post('showmanusales50','AndroidManufacturerController@showManusales50');

Route::post('showmanusalesdoc1','AndroidManufacturerController@showManusalesdoc1');
Route::post('showmanusalesdoc2','AndroidManufacturerController@showManusalesdoc2');

Route::post('showmanusalesdrug1','AndroidManufacturerController@showManusalesdrug1');
Route::post('showmanusalesdrug2','AndroidManufacturerController@showManusalesdrug2');
Route::post('showmanusalesdrug3','AndroidManufacturerController@showManusalesdrug3');
Route::post('showmanusalesdrug4','AndroidManufacturerController@showManusalesdrug4');

Route::post('showmanusalesbypharmacy','AndroidManufacturerController@showmanusalesbypharmacy');
Route::post('showmanusalesbydoctor','AndroidManufacturerController@showManusalesbydoctor');
Route::post('showmanusalesbydrugs','AndroidManufacturerController@showManusalesbydrugs');

Route::post('showmanuregionsummary','AndroidManufacturerController@showManuregionsummary');
Route::post('showregionsales','AndroidManufacturerController@showRegionsales');


Route::post('showmanudrugsubstitutionsawaytoday','AndroidManufacturerController@showManudrugsubstitutionsawaytoday');
Route::post('showmanudrugsubstitutionsawayweek','AndroidManufacturerController@showManudrugsubstitutionsawayweek');
Route::post('showmanudrugsubstitutionsawaymonth','AndroidManufacturerController@showManudrugsubstitutionsawaymonth');
Route::post('showmanudrugsubstitutionsawayyear','AndroidManufacturerController@showManudrugsubstitutionsawayyear');

Route::post('showmanudrugsubstitutionstotoday','AndroidManufacturerController@showManudrugsubstitutionstotoday');
Route::post('showmanudrugsubstitutionstoweek','AndroidManufacturerController@showManudrugsubstitutionstoweek');
Route::post('showmanudrugsubstitutionstomonth','AndroidManufacturerController@showManudrugsubstitutionstomonth');
Route::post('showmanudrugsubstitutionstoyear','AndroidManufacturerController@showManudrugsubstitutionstoyear');
Route::post('showmanudrugsubstitutionstomax','AndroidManufacturerController@showManudrugsubstitutionstomax');

Route::post('showmanudrugsubstitutionsintoday','AndroidManufacturerController@showManudrugsubstitutionsintoday');
Route::post('showmanudrugsubstitutionsinweek','AndroidManufacturerController@showManudrugsubstitutionsinweek');
Route::post('showmanudrugsubstitutionsinmonth','AndroidManufacturerController@showManudrugsubstitutionsinmonth');
Route::post('showmanudrugsubstitutionsinyear','AndroidManufacturerController@showManudrugsubstitutionsinyear');
Route::post('showmanudrugsubstitutionsinmax','AndroidManufacturerController@showManudrugsubstitutionsinmax');

Route::post('showmanusectorsummary','AndroidManufacturerController@showManusectorsummary');
Route::post('showmanucompetition','AndroidManufacturerController@showManucompetition');
Route::post('showmanutrends','AndroidManufacturerController@showManutrends');
//showManutrendscompanyyear showManutrends
// Route::post('showmanutrendscompanytoday8','AndroidManufacturerController@showManutrendscompanytoday');
//  Route::post('showmanutrendscompanyyear8','AndroidManufacturerController@showManutrendscompanyweek');
//   Route::post('showmanutrendscompanymonth8','AndroidManufacturerController@showManutrendscompanymonth');
//    Route::post('showManutrendscompanyyear8','AndroidManufacturerController@showManutrendscompanyyear');

//billsuggestion
//izi ni weeks
Route::post('showcomapnyanddrugcompe','AndroidManufacturerController@showComapnyanddrugcompe');
Route::post('showcomapnyanddrugcompe99','AndroidManufacturerController@showComapnyanddrugcompe99');
Route::post('showcomapny2anddrugcompe','AndroidManufacturerController@showComapny2anddrugcompe');
Route::post('showcomapny3anddrugcompe','AndroidManufacturerController@showComapny3anddrugcompe');
Route::post('showcomapny4anddrugcompe','AndroidManufacturerController@showComapny4anddrugcompe');
Route::post('showcomapny5anddrugcompe','AndroidManufacturerController@showComapny5anddrugcompe');
Route::post('showcomapny6anddrugcompe','AndroidManufacturerController@showComapny6anddrugcompe');

//to be tested
Route::post('showcomapnyanddrugcompetoday','AndroidManufacturerController@showComapnyanddrugcompetoday');
Route::post('showcomapny2anddrugcompetoday','AndroidManufacturerController@showComapny2anddrugcompetoday');
Route::post('showcomapny3anddrugcompetoday','AndroidManufacturerController@showComapny3anddrugcompetoday');
Route::post('showcomapny4anddrugcompetoday','AndroidManufacturerController@showComapny4anddrugcompetoday');
Route::post('showcomapny5anddrugcompetoday','AndroidManufacturerController@showComapny5anddrugcompetoday');
Route::post('showcomapny6anddrugcompetoday','AndroidManufacturerController@showComapny6anddrugcompetoday');

Route::post('showcomapnyanddrugcompemonth','AndroidManufacturerController@showComapnyanddrugcompemonth');
Route::post('showcomapny2anddrugcompemonth','AndroidManufacturerController@showComapny2anddrugcompemonth');
Route::post('showcomapny3anddrugcompemonth','AndroidManufacturerController@showComapny3anddrugcompemonth');
Route::post('showcomapny4anddrugcompemonth','AndroidManufacturerController@showComapny4anddrugcompemonth');
Route::post('showcomapny5anddrugcompemonth','AndroidManufacturerController@showComapny5anddrugcompemonth');
Route::post('showcomapny6anddrugcompemonth','AndroidManufacturerController@showComapny6anddrugcompemonth');

Route::post('showcomapnyanddrugcompeyear','AndroidManufacturerController@showComapnyanddrugcompeyear');
Route::post('showcomapny2anddrugcompeyear','AndroidManufacturerController@showComapny2anddrugcompeyear');
Route::post('showcomapny3anddrugcompeyear','AndroidManufacturerController@showComapny3anddrugcompeyear');
Route::post('showcomapny4anddrugcompeyear','AndroidManufacturerController@showComapny4anddrugcompeyear');
Route::post('showcomapny5anddrugcompeyear','AndroidManufacturerController@showComapny5anddrugcompeyear');
Route::post('showcomapny6anddrugcompeyear','AndroidManufacturerController@showComapny6anddrugcompeyear');

//competition analysis
Route::post('showmanucompetitionsalesyear','AndroidManufacturerController@showManucompetitionsalesyear');
Route::post('showmanucompetitionregiontoday','AndroidManufacturerController@showManucompetitionregiontoday');
Route::post('showmanucompetitionregionweek','AndroidManufacturerController@showManucompetitionregionweek');
Route::post('showmanucompetitionregionmonth','AndroidManufacturerController@showManucompetitionregionmonth');
Route::post('showmanucompetitionregionyear','AndroidManufacturerController@showManucompetitionregionyear');

Route::post('showmanucompetitiondoctortoday','AndroidManufacturerController@showManucompetitiondoctortoday');
Route::post('showmanucompetitiondoctormonth','AndroidManufacturerController@showManucompetitiondoctormonth');
Route::post('showmanucompetitiondoctorweek','AndroidManufacturerController@showManucompetitiondoctorweek');
Route::post('showmanucompetitiondoctoryear','AndroidManufacturerController@showManucompetitiondoctoryear');

Route::post('showmanucompetitiondrugtoday','AndroidManufacturerController@showManucompetitiondrugtoday');
Route::post('showmanucompetitiondrugweek','AndroidManufacturerController@showManucompetitiondrugweek');
Route::post('showmanucompetitiondrugmonth','AndroidManufacturerController@showManucompetitionddrugmonth');
Route::post('showmanucompetitiondrugyear','AndroidManufacturerController@showManucompetitiondrugyear');

Route::post('showmanucompetitiondrugs','AndroidManufacturerController@showManucompetitiondrugs');
Route::post('showmanucompetitionsales','AndroidManufacturerController@showManucompetitionsales');
Route::post('addmanuemployeess','AndroidManufacturerController@addManuemployeess');
//manu trends
Route::post('showmanutrendssubstitutionyear','AndroidManufacturerController@showManutrendssubstitutionyear');
Route::post('showmanutrendssubstitutionmonth','AndroidManufacturerController@showManutrendssubstitutionmonth');
Route::post('showmanutrendssubstitutionweek','AndroidManufacturerController@showManutrendssubstitutionweek');
Route::post('showmanutrendssubstitutiontoday','AndroidManufacturerController@showManutrendssubstitutiontoday');

Route::post('showmanutrendsregionweek','AndroidManufacturerController@showManutrendsregionweek');
Route::post('showmanutrendsregiontoday','AndroidManufacturerController@showManutrendsregionweek');
Route::post('showmanutrendsregionmonth','AndroidManufacturerController@showManutrendsregionmonth');
Route::post('showmanutrendsregionyear','AndroidManufacturerController@showManutrendsregionyear');

Route::post('showmanutrendsdrugtoday','AndroidManufacturerController@showManutrendsdrugtoday');
Route::post('showmanutrendsdrugweek','AndroidManufacturerController@showManutrendsdrugweek');
Route::post('showmanutrendsdrugmonth','AndroidManufacturerController@showManutrendsdrugmonth');
Route::post('showmanutrendsdrugyear','AndroidManufacturerController@showManutrendsdrugyear');

Route::post('showmanutrendscompanystoday','AndroidManufacturerController@showManutrendscompanystoday');
Route::post('showmanutrendscompanysweek','AndroidManufacturerController@showManutrendscompanystoday');
Route::post('showmanutrendscompanysmonth','AndroidManufacturerController@showManutrendscompanysmonth');
Route::post('showmanutrendscompanysyear','AndroidManufacturerController@showManutrendscompanysyear');

Route::post('showmanucountyinfo','AndroidManufacturerController@showManucountyinfo');
Route::post('showmanucounties','AndroidManufacturerController@showManucounties');
Route::post('showmanudoctors','AndroidManufacturerController@showmanudoctors');

//subd drugs
Route::post('showmanudrugsubstitutionsawaytodaysub','AndroidManufacturerController@showManudrugsubstitutionsawaytodaysub');
Route::post('showmanudrugsubstitutionsawayweeksub','AndroidManufacturerController@showManudrugsubstitutionsawayweeksub');
Route::post('showmanudrugsubstitutionsawaymonthsub','AndroidManufacturerController@showManudrugsubstitutionsawaymonthsub');
Route::post('showmanudrugsubstitutionsawayyearsub','AndroidManufacturerController@showManudrugsubstitutionsawayyearsub');

//competition totals
Route::post('showmanucompetitiondoctoryeartotalq','AndroidManufacturerController@showManucompetitiondoctoryeartotalq');
Route::post('showmanucompetitiondoctormonthtotalq','AndroidManufacturerController@showManucompetitiondoctormonthtotalq');
Route::post('showmanucompetitiondoctorweektotalq','AndroidManufacturerController@showManucompetitiondoctorweektotalq');
Route::post('showmanucompetitiondoctortodaytotalq','AndroidManufacturerController@showManucompetitiondoctortodaytotalq');

Route::post('showmanucompetitionregionyeartotalq','AndroidManufacturerController@showManucompetitionregionyeartotalq');

//testya doh
Route::post('showmanusaletots1','AndroidManufacturerController@showManusaletots1');

// Route::get('test',function(){
//     $showManusaletots1 = showManusaletots1::get();
//     $showManusaletots = showManusaletots1::get();
//     $obj = (object)array_merge_recursive((array)$showManusaletots1, (array)$showManusaletots);
// })

//sectorcashtotals
Route::post('showmanusectorsummarytotalcash','AndroidManufacturerController@showManusectorsummarytotalcash');

//regionsummary totals
Route::post('showmanupharmacies','AndroidManufacturerController@showManupharmacies');
Route::post('showmanuprescriptions','AndroidManufacturerController@showManuprescriptions');
Route::post('showmanudrugs','AndroidManufacturerController@showManudrugs');
Route::post('showmanusaletots','AndroidManufacturerController@showManusaletots');

Route::post('showmanusalescounty1','AndroidManufacturerController@showManusalescounty1');
Route::post('showmanusalescounty2','AndroidManufacturerController@showManusalescounty2');
Route::post('showmanusalescounty3','AndroidManufacturerController@showManusalescounty3');
Route::post('showmanusalescounty4','AndroidManufacturerController@showManusalescounty4');
Route::post('showmanusalescounty5','AndroidManufacturerController@showManusalescounty5');
Route::post('showmanusalescounty6','AndroidManufacturerController@showManusalescounty6');
Route::post('showmanusalescounty7','AndroidManufacturerController@showManusalescounty7');
Route::post('showmanusalescounty8','AndroidManufacturerController@showManusalescounty8');
Route::post('showmanusalescounty9','AndroidManufacturerController@showManusalescounty9');
Route::post('showmanusalescounty10','AndroidManufacturerController@showManusalescounty10');
Route::post('showmanusalescounty11','AndroidManufacturerController@showManusalescounty11');
Route::post('showmanusalescounty12','AndroidManufacturerController@showManusalescounty12');
Route::post('showmanusalescounty13','AndroidManufacturerController@showManusalescounty13');
Route::post('showmanusalescounty14','AndroidManufacturerController@showManusalescounty14');
Route::post('showmanusalescounty15','AndroidManufacturerController@showManusalescounty15');
Route::post('showmanusalescounty16','AndroidManufacturerController@showManusalescounty16');
Route::post('showmanusalescounty17','AndroidManufacturerController@showManusalescounty17');
Route::post('showmanusalescounty18','AndroidManufacturerController@showManusalescounty18');
Route::post('showmanusalescounty19','AndroidManufacturerController@showManusalescounty19');
Route::post('showmanusalescounty20','AndroidManufacturerController@showManusalescounty20');
Route::post('showmanusalescounty21','AndroidManufacturerController@showManusalescounty21');
Route::post('showmanusalescounty22','AndroidManufacturerController@showManusalescounty22');
Route::post('showmanusalescounty23','AndroidManufacturerController@showManusalescounty23');
Route::post('showmanusalescounty24','AndroidManufacturerController@showManusalescounty24');
Route::post('showmanusalescounty25','AndroidManufacturerController@showManusalescounty25');
Route::post('showmanusalescounty26','AndroidManufacturerController@showManusalescounty26');
Route::post('showmanusalescounty27','AndroidManufacturerController@showManusalescounty27');
Route::post('showmanusalescounty28','AndroidManufacturerController@showManusalescounty28');
Route::post('showmanusalescounty29','AndroidManufacturerController@showManusalescounty29');
Route::post('showmanusalescounty30','AndroidManufacturerController@showManusalescounty30');
Route::post('showmanusalescounty31','AndroidManufacturerController@showManusalescounty31');
Route::post('showmanusalescounty32','AndroidManufacturerController@showManusalescounty32');
Route::post('showmanusalescounty33','AndroidManufacturerController@showManusalescounty33');
Route::post('showmanusalescounty34','AndroidManufacturerController@showManusalescounty34');
Route::post('showmanusalescounty35','AndroidManufacturerController@showManusalescounty35');
Route::post('showmanusalescounty36','AndroidManufacturerController@showManusalescounty36');
Route::post('showmanusalescounty37','AndroidManufacturerController@showManusalescounty37');
Route::post('showmanusalescounty38','AndroidManufacturerController@showManusalescounty38');
Route::post('showmanusalescounty39','AndroidManufacturerController@showManusalescounty39');
Route::post('showmanusalescounty40','AndroidManufacturerController@showManusalescounty40');
Route::post('showmanusalescounty41','AndroidManufacturerController@showManusalescounty41');
Route::post('showmanusalescounty42','AndroidManufacturerController@showManusalescounty42');
Route::post('showmanusalescounty43','AndroidManufacturerController@showManusalescounty43');
Route::post('showmanusalescounty44','AndroidManufacturerController@showManusalescounty44');
Route::post('showmanusalescounty45','AndroidManufacturerController@showManusalescounty45');
Route::post('showmanusalescounty46','AndroidManufacturerController@showManusalescounty46');
Route::post('showmanusalescounty47','AndroidManufacturerController@showManusalescounty47');
Route::post('showmanusalesbypharmacycontent1','AndroidManufacturerController@showManusalesbypharmacycontent1');


//total for doctors in sales
Route::post('showmanusalesdoc1totalq','AndroidManufacturerController@showManusalesdoc1totalq');
//total stocks for manu
Route::post('showmanustocktotalq','AndroidManufacturerController@showManustocktotalq');
//total quantities for doc sales
Route::post('showmanusalesdoc2totalq','AndroidManufacturerController@showmanusalesdoc2totalq');
//stock by pharmacy/ displays pharmacy with stock
Route::post('showmanustockbypharmacy','AndroidManufacturerController@showmanustockbypharmacy');
//display all pharms
Route::post('showmanustockbypharmacy1','AndroidManufacturerController@showmanustockbypharmacy1');
Route::post('showmanustockbypharmacy3','AndroidManufacturerController@showmanustockbypharmacy3');

//Millie pharmacy android


//NHIF
Route::resource('nhif','NhifController');
Route::get('nhif-facilities','NhifController@nhif_facilities');
Route::get('suspend-facility/{id}','NhifController@suspend_facility');
Route::get('unsuspend-facility/{id}','NhifController@unsuspend_facility');
Route::get('nhif-patients','NhifController@nhif_patients');
Route::get('dashboard-details','NhifController@dashboard_details');
Route::get('nhif-facility','NhifController@nhif_facility');


Route::get('facility-patients','NhifController@facility_patients');
Route::get('patient-visits','NhifController@patient_visits');
Route::resource('claims','ClaimsController');

Route::get('facility-claims','ClaimsController@facility_claims');
Route::get('patient-claiming','ClaimsController@patient_claiming');




Route::resource('calendar','CalendarController');

Route::get('appcalendar','CalendarController@index')->name('appcalendar');

// Route::get('calendar2','CalendarController@load')->name('appcalendar2');


//CEO routes starts

Route::group(['middleware' => ['auth']], function() {
Route::resource('ceo','CeoController');
Route::resource('minister','MinisterController');
Route::resource('gov','GovController');
Route::resource('public','PublicController');
Route::resource('revenue','RevenueController');
Route::resource('material','MaterialController');
Route::resource('morgue','MorgueController');
Route::resource('uhc','UhcController');
});

//OBS and Gynachology routes Please dont Remove
include('obsg_routes.php');
