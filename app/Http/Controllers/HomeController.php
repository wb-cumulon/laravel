<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function editorindex(){
        $user['id'] = Auth::user()->id;
        $user['name'] = Auth::user()->name;
        $user['email'] = Auth::user()->email;
        return view('editoruser',$user);
    }

    public function editoruser(Request $request){
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        DB::table('users')->where('id',$id)->update(['name'=>$name,'email'=>$email]);
        return view('success');
    }
}
