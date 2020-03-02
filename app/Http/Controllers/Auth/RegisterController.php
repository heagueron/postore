<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;


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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    /**
     * Once the user is registred, adjust Timezone
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function registered(Request $request, $user)
    {
        // set timezone
        $timezone =  $this->getTimezone($request);
        $user->timezone = $timezone;
        // adjust user time fields
        $user->created_at = $user->created_at->timezone( $timezone )->toDateTimeString();
        $user->updated_at = $user->created_at->timezone( $timezone )->toDateTimeString();
        $user->save();

    }

    protected function getTimezone(Request $request)
    {
        if ($timezone = $request->get('tz')) {
            //dd($request);
            return $timezone;
        }

        // fetch it from FreeGeoIp
        $ip = $this->getClientIp();
        //dd('Mi alma de ip: ', $ip);

        try {
            $response = json_decode(file_get_contents('http://ip-api.com/json/' . $ip), true);
            if( Arr::has($response, 'timezone') ) {
                return Arr::get( $response, 'timezone' );
            };

        } catch (\Exception $e) {}
        
    }

    protected function getClientIp(): string
    {
        $ip = \request()->ip();
        //$ip = $_SERVER['REMOTE_ADDR'];
        return $ip == '127.0.0.1' ? '45.230.46.137' : $ip;
    }

    

}
