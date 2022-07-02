<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {

        return view('auth.login');
    }

    public function store(Request $request)
    {
        // $username = DB::table('users')->select('username')->where('username', $request->username)->first();
        $levels = DB::table('users')
        ->join('role', 'role.id_role', '=', 'users.id_role')
        ->select('role.id_role')
        ->orderBy('users.id','DESC')
        ->where('username', $request->username)->first();

        $this->validate($request, [
            'username'=>'required',
            'password'=>'required',
        ]);


        if (!auth()->attempt($request->only('username', 'password'), $request->remember)){
            return back()->with('gagal', 'invalid login details');
        }

        if($levels->id_role == '1') {
            return redirect()->route('dashboard')->with('login','Anda Berhasil Login');
        }

        elseif($levels->level == '2') {
            return redirect()->route('dashboard')->with('login','Anda Berhasil Login');
        }
        elseif($levels->level == '3') {
            return redirect()->route('dashboard')->with('login','Anda Berhasil Login');
        }
    }

}

