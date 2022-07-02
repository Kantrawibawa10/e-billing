<?php

namespace App\Http\Controllers\page\pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class PelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $data = [
            'pelanggan' => DB::table('tbl_pelanggan')->where('id_kategori', '2')->get(),
            'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
            'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
            ->where('status', 'aktif')->limit(1)->get(),
        ];

        //generate kode pelanggan
        $random =  rand(4,50);
        $kode_pelanggan = 'CST'.'-'.sprintf("%04s", $random).date('Y');

        
        return view('page.pelanggan.pelanggan', $data, compact('kode_pelanggan'));
    }

    

    ////////////////////////////////////////////////////////////////
    /////////////////////INSERT Pelanggan /////////////////////////
    //////////////////////////////////////////////////////////////
    public function store(Request $request){
        $this->validate($request, [
            'kode_pelanggan' => 'required|unique:tbl_pelanggan,kode_pelanggan',
            'nik' => 'required|unique:tbl_pelanggan,nik',
            'nama' => 'required',
            'alamat' => 'required',
            'no_telpn' => 'required',
            'email' => 'nullable',
            'catatan' => 'nullable',
            'created_at' => 'required',
            'updated_at' => 'required',
            'bulan' => 'required',
            'id_kategori' => 'required',
            'file' => 'nullable',
        ]);

        if ($request->file <> "") {
            //uCSToad image
            $file = $request->file;
            $fileName =  $request->generate_no. $file->hashName();
            $file->move('file', $fileName);

            $pelanggan = DB::table('tbl_pelanggan')->insert([
                'kode_pelanggan' => $request->kode_pelanggan,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telpn' => $request->no_telpn,
                'email' => $request->email,
                'catatan' => $request->catatan,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'bulan' => $request->bulan,
                'id_kategori' => $request->id_kategori,
                'file' => $fileName,      
            ]);
            
            if($pelanggan){
                //redirect dengan pesan sukses
                return redirect()->route('pelanggan')->with(['success' => 'Berhasil Ditambahkan!!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('pelanggan')->with(['error' => 'Gagal Ditambahkan!']);
            }
        }else{
            $pelanggan = DB::table('tbl_pelanggan')->insert([
                'kode_pelanggan' => $request->kode_pelanggan,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telpn' => $request->no_telpn,
                'email' => $request->email,
                'catatan' => $request->catatan,
                'created_at' => $request->created_at,
                'updated_at' => $request->updated_at,
                'id_kategori' => $request->id_kategori,
                'bulan' => $request->bulan,
            ]);

            
            if($pelanggan){
                //redirect dengan pesan sukses
                return redirect()->route('pelanggan')->with(['success' => 'Berhasil Ditambahkan!!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('pelanggan')->with(['error' => 'Gagal Ditambahkan!']);
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
            $deleted = DB::table('tbl_pelanggan')->where('kode_pelanggan',$request->kode_pelanggan)->first();
            unlink('file' .'/'. $deleted->file);

            //upload image
            $file = $request->file;
            $fileName =  $request->generate_no. $file->hashName();
            $file->move('file', $fileName);

            $update = DB::table('tbl_pelanggan')->where('kode_pelanggan',$request->kode_pelanggan)->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telpn' => $request->no_telpn,
                'email' => $request->email,
                'catatan' => $request->catatan,
                'updated_at' => $request->updated_at,
                'file' => $fileName,
            ]);

            if($update){
                //redirect dengan pesan sukses
                return redirect()->route('pelanggan')->with(['success' => 'Berhasil Ditambahkan!!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('pelanggan')->with(['error' => 'Gagal Ditambahkan!']);
            }

        }else{
            $update = DB::table('tbl_pelanggan')->where('kode_pelanggan',$request->kode_pelanggan)->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telpn' => $request->no_telpn,
                'email' => $request->email,
                'status' => $request->status,
                'catatan' => $request->catatan,
                'updated_at' => $request->updated_at,
            ]);

            if($update){
                //redirect dengan pesan sukses
                return redirect()->route('pelanggan')->with(['success' => 'Berhasil Ditambahkan!!']);
            }else{
                //redirect dengan pesan error
                return redirect()->route('pelanggan')->with(['error' => 'Gagal Ditambahkan!']);
            }
        }
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Update Pelanggan//////////////////////
    //////////////////////////////////////////////////////////////












    

    ////////////////////////////////////////////////////////////////
    /////////////////////////Search pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////
    public function search(Request $request)
    {
        $data = [
            'pelanggan' => DB::table('tbl_pelanggan')->where('id_kategori', '2')->get(),
            'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
            'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
            ->where('status', 'aktif')->limit(1)->get(),
        ];

        //generate kode pelanggan
        $random =  rand(1,50);
        $kode_pelanggan = 'CST'.'-'.sprintf("%04s", $random).date('Y');  


        //////////////////////////SEARCH ONE FIELD////////////////////////////////
        if ($request->kode_pelanggan )
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->get(),
            ];
        }


        if ($request->nama)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];
        }


        if ($request->created_at)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('created_at', 'like', '%'.$request->created_at.'%')
                ->get(),
            ];
        }

        if ($request->status)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }
        //////////////////////////SEARCH ONE FIELD////////////////////////////////




        //////////////////////////SEARCH CONDITION////////////////////////////////

        ///kode start
        if ($request->kode_pelanggan && $request->nama)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];   
        }


        if ($request->kode_pelanggan && $request->created_at)
        {
            $date = date_create($request->created_at);
            $created = date_format($date,'Y-m-d');
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('created_at', 'like', '%'.$created.'%')
                ->get(),
            ];   
        }


        if ($request->kode_pelanggan && $request->created_at && $request->end_tanggal)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->whereBetween('created_at', [$start, $end])
                ->get(),
            ];   
        }        


        if ($request->kode_pelanggan && $request->status)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];   
        }


        if ($request->kode_pelanggan && $request->nama && $request->created_at)
        {
            $date = date_create($request->created_at);
            $created = date_format($date,'Y-m-d');
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->where('created_at', 'like', '%'.$created.'%')
                ->get(),
            ];   
        }



        if ($request->kode_pelanggan && $request->nama && $request->created_at && $request->end_tanggal)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->whereBetween('created_at', [$start, $end])
                ->get(),
            ];   
        }



        if ($request->kode_pelanggan && $request->created_at && $request->end_tanggal && $request->status)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];   
        }
   


        


        if ($request->nama && $request->created_at)
        {
            $date = date_create($request->created_at);
            $created = date_format($date,'Y-m-d');
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->where('created_at', 'like', '%'.$request->created.'%')
                ->get(),
            ];
        }


        if ($request->nama && $request->created_at && $request->end_tanggal)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->whereBetween('created_at', [$start, $end])
                ->get(),
            ];
        }


        if ($request->nama && $request->created_at && $request->end_tanggal && $request->status)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }



        if ($request->created_at && $request->end_tanggal)
        {
            // dd($request->created_at , $request->end_tanggal);
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->whereBetween('created_at', [$start, $end])
                ->get(),
            ];
        }


        if ($request->created_at && $request->end_tanggal && $request->status)
        {
            // dd($request->created_at , $request->end_tanggal);
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }


        if ($request->kode_pelanggan && $request->nama && $request->created_at && $request->end_tanggal && $request->status)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];   
        }
    

        return view('page.pelanggan.pelanggan', $data, compact('kode_pelanggan'));
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Search pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////













    ///////////////////////////////////////////////////////////////////
    /////////////////////////PRINT pelanggan//////////////////////////
    /////////////////////////////////////////////////////////////////
    public function print(Request $request)
    {
        $data = [
            'pelanggan' => DB::table('tbl_pelanggan')->where('id_kategori', '2')->get(),
            'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
            'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
            ->where('status', 'aktif')->limit(1)->get(),
        ];
        //////////////////////////SEARCH ONE FIELD////////////////////////////////
        if ($request->kode_pelanggan )
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->get(),
            ];
        }


        if ($request->nama)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];
        }


        if ($request->created_at)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('created_at', 'like', '%'.$request->created_at.'%')
                ->get(),
            ];
        }

        if ($request->status)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }
        //////////////////////////SEARCH ONE FIELD////////////////////////////////




        //////////////////////////SEARCH CONDITION////////////////////////////////

        ///kode start
        if ($request->kode_pelanggan && $request->nama)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];   
        }


        if ($request->kode_pelanggan && $request->created_at)
        {
            $date = date_create($request->created_at);
            $created = date_format($date,'Y-m-d');
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('created_at', 'like', '%'.$created.'%')
                ->get(),
            ];   
        }


        if ($request->kode_pelanggan && $request->created_at && $request->end_tanggal)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->whereBetween('created_at', [$start, $end])
                ->get(),
            ];   
        }        


        if ($request->kode_pelanggan && $request->status)
        {
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];   
        }


        if ($request->kode_pelanggan && $request->nama && $request->created_at)
        {
            $date = date_create($request->created_at);
            $created = date_format($date,'Y-m-d');
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->where('created_at', 'like', '%'.$created.'%')
                ->get(),
            ];   
        }



        if ($request->kode_pelanggan && $request->nama && $request->created_at && $request->end_tanggal)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->whereBetween('created_at', [$start, $end])
                ->get(),
            ];   
        }



        if ($request->kode_pelanggan && $request->created_at && $request->end_tanggal && $request->status)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];   
        }
   


        


        if ($request->nama && $request->created_at)
        {
            $date = date_create($request->created_at);
            $created = date_format($date,'Y-m-d');
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->where('created_at', 'like', '%'.$request->created.'%')
                ->get(),
            ];
        }


        if ($request->nama && $request->created_at && $request->end_tanggal)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->whereBetween('created_at', [$start, $end])
                ->get(),
            ];
        }


        if ($request->nama && $request->created_at && $request->end_tanggal && $request->status)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;
            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }



        if ($request->created_at && $request->end_tanggal)
        {
            // dd($request->created_at , $request->end_tanggal);
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->whereBetween('created_at', [$start, $end])
                ->get(),
            ];
        }


        if ($request->created_at && $request->end_tanggal && $request->status)
        {
            // dd($request->created_at , $request->end_tanggal);
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];
        }


        if ($request->kode_pelanggan && $request->nama && $request->created_at && $request->end_tanggal && $request->status)
        {
            $start = $request->created_at;
            $end = $request->end_tanggal;

            $data = [
                'bulanini' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->where('id_kategori', '2')->get(),
                'kategori' => DB::table('tbl_kategori')->where('nama_ketgori', 'customer')
                ->where('status', 'aktif')->limit(1)->get(),
                'pelanggan' => DB::table('tbl_pelanggan')
                ->where('kode_pelanggan', 'like', '%'.$request->kode_pelanggan.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'like', '%'.$request->status.'%')
                ->get(),
            ];   
        }

        return view('page.pelanggan.print', $data);
    }
    //////////////////////////////////////////////////////////////////
    /////////////////////////PRINT pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////////

}
