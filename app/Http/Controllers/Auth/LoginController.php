<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin()
    {
        return collect(['name', 'email'])->contains(function ($value) {
            $account = request()->get($this->username());
            $password = request()->get('password');
            return $this->guard()->attempt([$value => $account, 'password' => $password]);
        });
    }

    /**
     * 登录验证.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin()
    {
        $this->validate(request(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],[
            $this->username() => '账号',
            //'captcha' => '验证码',
        ]);
    }

    public function username()
    {
        return 'account';
    }
    
}
