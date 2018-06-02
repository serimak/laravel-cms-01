<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Ldap;

use Anam\Captcha\Captcha;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/login';
    protected $redirectAfterGuestLogout = '/';
    protected $homePath = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function getLogin()
    {
        // $this->logger->action(__METHOD__, "start");
        return redirect()->route('login');
        // $this->logger->action(__METHOD__, "end");
    }

    public function postLogin(Captcha $captcha)
    {
        // $this->logger->action(__METHOD__, "start");
        $response = $captcha->check($this->request);

        if (!$response->isVerified()) {
            return $this->sendFailedLoginResponse($this->request);
        }

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $this->validate($this->request, $rules);
        $data = $this->request->only(array_keys($rules));

        $user = [
          'username' => $data['username'],
          'password' => $data['password'],
          'active' => 1,
          'auth_type'=> 'local'
        ]; 
        // $this->logger->action(__METHOD__, "end");
        if(Auth::attempt($user)) {
            $user = Auth::user();
            return $this->sendLoginResponse($this->request);
        } else {
            return $this->sendFailedLoginResponse($this->request);
        }

    }

    public function postGuest(Captcha $captcha)
    {
        $response = $captcha->check($this->request);

        if (!$response->isVerified()) {
            return $this->sendFailedLoginResponse($this->request);
        }

        $user = [
          'username' => env('USR_GUEST'),
          'password' => env('PWD_GUEST'),
          'active' => 1,
          'auth_type'=> 'local'
        ]; 

        if(Auth::attempt($user)) {
            $user = Auth::user();
            return $this->sendLoginResponse($this->request);
        } else {
            return $this->sendFailedLoginResponse($this->request);
        }

    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->request->session()->flush();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : $this->homePath);
    }

    /**
     * Log the guest user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGuestLogout()
    {
        $this->request->session()->flush();
        return redirect(property_exists($this, 'redirectAfterGuestLogout') ? $this->redirectAfterGuestLogout : $this->homePath);
    }


    public function redirectTo()
    {
      //$url = '/dashboard';
        $url = '/research_search';
        return $url;
    }
}
