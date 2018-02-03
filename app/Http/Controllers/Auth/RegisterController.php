<?php

namespace App\Http\Controllers\Auth;

use Mail;
use Session;
use App\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //Session::flash('status', 'Registrado! Un mail fue enviado a tu cuenta para confirmar la activacion');

        return $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verifyToken' => Str::random(40),
        ]);

        // $user = User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        //     'verifyToken' => Str::random(40),
        // ]);

        //$thisUser = User::findOrFail($user->id);
        //$this->sendEmail($thisUser);
    }

    public function sendEmail($thisUser) {
    
        Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    }

    public function verifyEmailFirst() {

        return view('email.verifyEmailFirst');
    }

    public function sendEmailDone($email, $verifyToken) {

        $user = User::where(['email' => $email, 'verifyToken' => $verifyToken])->first();
        
        if($user) {

            user::where(['email' => $email, 'verifyToken' => $verifyToken])->update(['is_active' => '1', 'verifyToken' => null]);
            return view('email.userConfirmed');
        }
        else {

            return 'usuario no encontrado';
        }
    }
}
