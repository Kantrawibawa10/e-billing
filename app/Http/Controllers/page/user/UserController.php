<?php

namespace App\Http\Controllers\page\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;


class UserController extends Controller
{
    public function __construct()
     {
         $this->middleware(['auth']);
     }
    
    public function index(Request $request)
    {
        $data = [
            'users' => DB::table('users')
            ->join('role', 'role.id_role', '=', 'users.id_role')
            ->get(),

            'role' => DB::table('role')->get(),

            'detailrole' => DB::table('users')
            ->where('users.id_role', $request->id_role)
            ->get(),
        ];

        //generate kode users
        $random =  rand(4,50);
        $kode = 'user'.'-'.sprintf("%04s", $random);

        
        return view('page.UserManagement.user', $data, compact('kode'));
    }
    

    ////////////////////////////////////////////////////////////////
    ////////////////////////INSERT Users /////////////////////////
    //////////////////////////////////////////////////////////////
    public function store(Request $request){
        $this->validate($request, [
            'kode' => 'required',
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required',
            'id_role' => 'required',
            'note' => 'nullable',
            'created_at' => 'required',
            'updated_at' => 'required',
            'img' => 'nullable',
        ]);

        if ($request->img <> "") {
            //upload image
            $img = $request->img;
            $random =  rand(4,50);
            $name = $request->username.'-'.sprintf("%04s", $random);
            $fileName =  $request->name;
            $img->move('profile', $fileName);

            $user = DB::table('users')->insert([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'id_role' => $request->id_role,
                'note' => $request->note,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'img' => $fileName,
                
            ]);
            
            if($user){
                //redirect dengan pesan sukses
                return redirect()->route('user')->with(['success' => 'Berhasil Ditambahkan!!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('user')->with(['error' => 'Gagal Ditambahkan!']);
            }
        }else{
            $user = DB::table('users')->insert([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'id_role' => $request->id_role,
                'note' => $request->note,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
            ]);
            
            if($user){
                //redirect dengan pesan sukses
                return redirect()->route('user')->with(['success' => 'Berhasil Ditambahkan!!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('user')->with(['error' => 'Gagal Ditambahkan!']);
            }
        }    
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////INSERT Pelanggan /////////////////////////
    //////////////////////////////////////////////////////////////







    ////////////////////////////////////////////////////////////////
    /////////////////////////Update Pelanggan//////////////////////
    //////////////////////////////////////////////////////////////
    public function update(Request $request)
    {
        if ($request->img_barang <> "") {
            $deleted = DB::table('users')->where('kode',$request->kode)->first();
            unlink('img' .'/'. $deleted->img);

            //upload image
            $img = $request->img;
            $random =  rand(4,50);
            $name = $request->username.'-'.sprintf("%04s", $random);
            $fileName =  $request->name;

            $update = DB::table('users')->where('kode',$request->kode)->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'username' => $request->username,
                'id_role' => $request->id_role,
                'note' => $request->note,
                'status' => $request->status,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'img' => $fileName,
            ]);

            if($update){
                //redirect dengan pesan sukses
                return redirect()->route('users')->with(['success' => 'Berhasil Ditambahkan!!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('users')->with(['error' => 'Gagal Ditambahkan!']);
            }

        }else{
            $update = DB::table('users')->where('kode',$request->kode)->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'username' => $request->username,
                'id_role' => $request->id_role,
                'note' => $request->note,
                'status' => $request->status,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
            ]);

            if($update){
                //redirect dengan pesan sukses
                return redirect()->route('user')->with(['success' => 'Berhasil Diubah!!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('user')->with(['error' => 'Gagal Diubah!']);
            }
        }
    }



    public function updatepassword(Request $request)
    {
        $password = DB::table('users')->where('kode',$request->kode)->update([
            'password' => Hash::make($request->password),
        ]);

        if($password){
            //redirect dengan pesan sukses
            return redirect()->route('user')->with(['success' => 'Password Berhasil Diubah!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('user')->with(['error' => 'Password Gagal Diubah!']);
        }
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Update Pelanggan//////////////////////
    //////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////
    /////////////////////////Search user//////////////////////////
    //////////////////////////////////////////////////////////////
    public function search(Request $request)
    {
        $data = [
            'users' => DB::table('users')
            ->join('role', 'role.id_role', '=', 'users.id_role')
            ->get(),

            'role' => DB::table('role')->get(),
        ];

        //generate kode users
        $random =  rand(4,50);
        $kode = 'user'.'-'.sprintf("%04s", $random);



        //////////////////////////SEARCH ONE FIELD////////////////////////////////
        if ($request->kode )
        {
            $data = [
                'role' => DB::table('role')->get(),

                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->get(),
            ];
        }


        if ($request->nama)
        {
            $data = [
                'role' => DB::table('role')->get(),

                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];
        }

        if ($request->username)
        {
            $data = [
                'role' => DB::table('role')->get(),

                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('username', 'like', '%'.$request->username.'%')
                ->get(),
            ];
        }

        if ($request->status)
        {
            $data = [
                'role' => DB::table('role')->get(), 

                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }
        //////////////////////////SEARCH ONE FIELD////////////////////////////////

        if ($request->kode && $request->nama)
        {
            $data = [
                'role' => DB::table('role')->get(),
                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];
        }

        if ($request->kode && $request->username)
        {
            $data = [
                'role' => DB::table('role')->get(),
                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->where('username', 'like', '%'.$request->username.'%')
                ->get(),
            ];
        }

        if ($request->kode && $request->status)
        {
            $data = [
                'role' => DB::table('role')->get(),
                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }


        if ($request->kode && $request->nama && $request->username)
        {
            $data = [
                'role' => DB::table('role')->get(),
                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->where('status', 'like', '%'.$request->status.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->where('username', 'like', '%'.$request->username.'%')
                ->get(),
            ];
        }



        if ($request->kode && $request->nama && $request->username && $request->status)
        {
            $data = [
                'role' => DB::table('role')->get(),
                'users' => DB::table('users')
                ->join('role', 'role.id_role', '=', 'users.id_role')
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->where('status', 'like', '%'.$request->status.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->where('username', 'like', '%'.$request->username.'%')
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }



        return view('page.UserManagement.user', $data, compact('kode'));
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Search user//////////////////////////
    //////////////////////////////////////////////////////////////
}
