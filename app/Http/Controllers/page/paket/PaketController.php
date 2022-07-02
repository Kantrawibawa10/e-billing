<?php
 
namespace App\Http\Controllers\page\paket;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
 
class PaketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $data = [
            'paket' => DB::table('tbl_paket')->get(),
            'get_tgl' => DB::table('tbl_paket')->take(1)->get(),
        ];

        //generate kode paket
        $random =  rand(4,50);
        $kode_paket = 'PKT'.'-'.sprintf("%02s", $random).sprintf("%02s", $random).date('Y');

        return view('page.paket.paket', $data, compact('kode_paket'));
    }


    ////////////////////////////////////////////////////////////////
    /////////////////////INSERT paket /////////////////////////
    //////////////////////////////////////////////////////////////
    public function store(Request $request){
        $this->validate($request, [
            'kode' => 'required|unique:tbl_paket,kode',
            'nama_paket' => 'required',
            'kategori' => 'nullable',
            'harga_paket' => 'required',
            'nilai_pajak' => 'nullable',
            'total' => 'nullable',
            'deskripsi' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'file' => 'nullable',
        ]);

        
        $paket = DB::table('tbl_paket')->insert([
            'kode' => $request->kode,
            'nama_paket' => $request->nama_paket,
            'kategori' => $request->kategori,
            'harga_paket' => $request->harga_paket,
            'nilai_pajak' => $request->nilai_pajak,
            'total' => $request->total,
            'deskripsi' => $request->deskripsi,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ]);
        
        if($paket){
            //redirect dengan pesan sukses
            return redirect()->route('paket')->with(['success' => 'Paket Berhasil Ditambahkan!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('paket')->with(['error' => 'Paket Gagal Ditambahkan!']);
        }
          
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////INSERT paket /////////////////////////
    //////////////////////////////////////////////////////////////


    ////////////////////////////////////////////////////////////////
    /////////////////////////Update paket//////////////////////
    //////////////////////////////////////////////////////////////
    public function update(Request $request)
    {
        $update = DB::table('tbl_paket')->where('kode',$request->kode)->update([
            'nama_paket' => $request->nama_paket,
            'kategori' => $request->kategori,
            'harga_paket' => $request->harga_paket,
            'nilai_pajak' => $request->nilai_pajak,
            'deskripsi' => $request->deskripsi,
            'value' => $request->value,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ]);

        if($update){
            //redirect dengan pesan sukses
            return redirect()->route('paket')->with(['success' => 'Paket Barhasil Diupdate!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('paket')->with(['error' => 'Paket Gagal Diupdate!!']);
        }
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Update paket//////////////////////
    //////////////////////////////////////////////////////////////


    ////////////////////////////////////////////////////////////////
    /////////////////////////Deleted paket//////////////////////
    //////////////////////////////////////////////////////////////
    public function deleted(Request $request)
    {
	
        $deleted = DB::table('tbl_paket')->where('kode',$request->kode)->delete();

        if($deleted){
            //redirect dengan pesan sukses
            return redirect()->route('paket')->with(['success' => 'Paket Berhasil Dihapus!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('paket')->with(['error' => 'Paket Gagal Dihapus!!']);
        }
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Deleted paket//////////////////////
    //////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////
    /////////////////////////Search paket//////////////////////////
    //////////////////////////////////////////////////////////////
    public function search(Request $request)
    {
        $data = [
            'paket' => DB::table('tbl_paket')->get(),
            'get_tgl' => DB::table('tbl_paket')->take(1)->get(),
        ];

        // $paket = DB::table('tbl_paket')->where('item', 'true')->get();

        //generate kode paket
        $random =  rand(1,50);
        $kode_paket = 'PKT'.'-'.sprintf("%04s", $random).date('Y');
        


        //////////////////////////SEARCH ONE FIELD////////////////////////////////
        if ($request->kode )
        {
            $data = [
                'paket' => DB::table('tbl_paket')
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->get(),
            ];
        }


        if ($request->nama_paket)
        {
            $data = [
                'paket' => DB::table('tbl_paket')
                ->where('nama_paket', 'like', '%'.$request->nama_paket.'%')
                ->get(),
            ];
        }

        if ($request->value)
        {
            $data = [
                'paket' => DB::table('tbl_paket')
                ->where('value', 'like', '%'.$request->value.'%')
                ->get(),
            ];
        }
        //////////////////////////SEARCH ONE FIELD////////////////////////////////




        //////////////////////////SEARCH CONDITION////////////////////////////////

        ///kode start
        if ($request->kode && $request->nama_paket)
        {
            $data = [
                'paket' => DB::table('tbl_paket')            
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->where('nama_paket', 'like', '%'.$request->nama_paket.'%')
                ->get(),
            ];   
        }


        if ($request->kode && $request->value)
        {
            $data = [
                'paket' => DB::table('tbl_paket')    
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->where('value', 'like', '%'.$request->value.'%')
                ->get(),
            ];   
        }


        if ($request->kode && $request->nama_paket && $request->value)
        {
            $data = [
                'paket' => DB::table('tbl_paket')
                
                ->where('kode', 'like', '%'.$request->kode.'%')
                ->where('nama_paket', 'like', '%'.$request->nama_paket.'%')
                ->where('value', 'like', '%'.$request->value.'%')
                ->get(),
            ];   
        }
        //kode end



        if ($request->nama_paket && $request->value)
        {
            $data = [
                'paket' => DB::table('tbl_paket')
                
                ->where('nama_paket', 'like', '%'.$request->nama_paket.'%')
                ->where('value', 'like', '%'.$request->value.'%')
                ->get(),
            ];   
        }


        return view('page.paket.paket', $data, compact('kode_paket'));
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Search paket//////////////////////////
    //////////////////////////////////////////////////////////////

}
