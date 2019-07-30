<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function  editIndex(Request $request){
        $list = Auth::user();
        return view('auth.edituser',compact('list'));
    }
    public function editUser(Request $request){
        if($request->isMethod('POST')){
            $this->validator($request);
        }
        User::where('id',auth::user()->id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect('home');
    }
    protected function validator($request)
    {
        if($request->isMethod('POST')){
            $this->validate($request, [
                'name'         =>      'required', 'string', 'max:255','unique:users',
                'email'       =>      'required', 'string', 'email', 'max:255', 'unique:users',
                'password'       =>      'required', 'string', 'min:8', 'confirmed',
            ],[
                'name.required'            =>      '用户名不能为空',
                'email.required'          =>      '邮箱不能为空',
                'password.required'           =>      '密码不能为空',
            ]);
        }
    }
}
