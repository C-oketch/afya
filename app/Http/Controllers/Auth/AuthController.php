<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Validator;
use DB;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout', 'getLogout']);


    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'role' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
         $user= User::create([
            'name' => $data['name'],
            'role' => $data['role'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
         $role=$data['role'];
         if($role=='Admin'){
            DB::table('role_user')->insert(['user_id'=>$user->id,
      'role_id'=>1]);
          }
          elseif($role=='Doctor'){
              DB::table('role_user')->insert(['user_id'=>$user->id,
      'role_id'=>2]);
          }
           elseif($role=='Nurse'){
              DB::table('role_user')->insert(['user_id'=>$user->id,
      'role_id'=>4]);
           }
             elseif($role=='Manufacturer'){
                DB::table('role_user')->insert(['user_id'=>$user->id,
      'role_id'=>5]);
             }
               elseif($role=='Pharmacy_admin'){
                  DB::table('role_user')->insert(['user_id'=>$user->id,
      'role_id'=>6]);
               }
                 elseif($role=='Test'){
                    DB::table('role_user')->insert(['user_id'=>$user->id,
      'role_id'=>7]);
                 }
                   elseif($role=='Patient'){
                      DB::table('role_user')->insert(['user_id'=>$user->id,
      'role_id'=>8]);
                   }
                   elseif($role=='Pharmacy_manager'){
                      DB::table('role_user')->insert(['user_id'=>$user->id,
          'role_id'=>12]);
                   }
                   elseif($role=='Pharmacy_store_keeper'){
            DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>13]);
                   }
                  elseif($role=='FacilityFinance'){
            DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>14]);
                   }
                    elseif($role=='Superadmin'){
            DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>15]);
                    }
                        elseif($role=='Nhif'){
            DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>16]);
                    }

                    else{
            DB::table('role_user')->insert(['user_id'=>$user->id,'role_id'=>9]);
                    }



       return $user;

    }


  public function redirectPath()
  {
      // Logic that determines where to send the user
      $role=\Auth::user()->role;
      if ($role == 'Admin') {
          return '/admin';
      }
      if($role == "Doctor"){
   return '/doctor';
  }
      if($role == "Nurse"){
        return '/nurse';
      }
      if($role == "Manufacturer"){
        return '/manufacturer';
      }
      if($role == "Pharmacy_admin" || $role == "Pharmacy_manager"){
        return '/pharmacy';
      }
      if($role == "Pharmacy_store_keeper"){
        return '/inventory';
      }
      if($role == "Test"){
        return '/test';
      }
      if($role == "Patient"){
        return '/patient';
      }
      if($role == "Registrar"){
        return '/registrar';
      }
      if($role=="FacilityAdmin"){
        return '/facilityadmin';
      }
      if($role=="Private"){
        return '/private';
      }
      if($role=="FacilityFinance"){
        return '/finance';
      }
      if($role=="Superadmin"){
        return '/superadmin';
      }
       if($role=="Nhif"){
        return '/nhif';
      }
      if($role=="ceo"){
       return '/ceo';
     }
     if($role=="minister"){
      return '/minister';
    }
    if($role=="gov"){
     return '/gov';
   }
   if($role=="public"){
    return '/public';
  }
  if($role=="revenue"){
   return '/revenue';
 }
 if($role=="material"){
  return '/material';
}
if($role=="morgue"){
 return '/morgue';
}
if($role=="uhc"){
 return '/uhc';
}
      else
      {
      return '/login';
      }
  }

}
