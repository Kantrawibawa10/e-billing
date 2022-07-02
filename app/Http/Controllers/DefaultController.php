<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class DefaultController extends Controller
{
    public function __construct()
     {
         $this->middleware(['auth']);
     }
    
    public function index()
    {
        $data = [
            'set_time' => DB::table('default_time')->where('value', 'true')->get(),
            'set_berlangganan' => DB::table('tbl_berlangganan')->where('value', 'true')->get(),
        ];

        return view('page.system.default', $data);
    }

    public function setday(Request $request)
    {
        $time = DB::table('default_time')->where('id',$request->id)->update([
            'set_day' => $request->set_day,
        ]);

        if($time){
            //redirect dengan pesan sukses
            return redirect()->route('system')->with(['success' => 'Berhasil Diupdate!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('system')->with(['error' => 'Gagal Diupdate!']);
        }
    }


    public function setberlangganan(Request $request)
    {
        $this->validate($request, [
            'berlangganan' => 'required|unique:tbl_berlangganan,berlangganan',
        ]);


        $berlangganan = DB::table('tbl_berlangganan')->where('id',$request->id)->update([
            'berlangganan' => $request->berlangganan,
        ]);

        if($berlangganan){
            //redirect dengan pesan sukses
            return redirect()->route('system')->with(['success' => 'Berhasil Diupdate!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('system')->with(['error' => 'Gagal Diupdate!']);
        }
    }

    public function addberlangganan(Request $request)
    {
        $this->validate($request, [
            'berlangganan' => 'required|unique:tbl_berlangganan,berlangganan',
        ]);


        $berlangganan = DB::table('tbl_berlangganan')->insert([
            'berlangganan' => $request->berlangganan,
        ]);

        if($berlangganan){
            //redirect dengan pesan sukses
            return redirect()->route('system')->with(['success' => 'Berhasil Ditambahkan!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('system')->with(['error' => 'Gagal Ditambahkan!']);
        }
    }
}
