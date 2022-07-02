<?php
 
namespace App\Http\Controllers\page\billing;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;
 
class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        //generate kode paket
        $random =  mt_rand(1000, 9999);
        // $random1 =  rand(5,100);
        $kode_reg = 'REG'.'-'.sprintf("%02s", $random).date('i').date('s').date('y');
        $inv =  mt_rand(1000, 9999);
        // $inv1 =  rand(5,100);
        $kode_inv = 'INV'.'-'.sprintf("%05s", $inv).date('i').date('s').date('y');


        $data = [
            //reg start
            'register' => DB::table('tbl_registrasi')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
            ->where('tbl_registrasi.option', 'aktif')
            ->where('tbl_registrasi.option', 'aktif')
            ->get(),
            //reg end


            //invoice start
            'invoice' => DB::table('tbl_invoice')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
            ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
            ->where('tbl_invoice.option', 'aktif')
            ->where('tbl_invoice.option', 'aktif')
            ->get(),
            //invoice end
            

            //count start
            'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
            'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
            'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
            //count end

            //master data start
            'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
            'pelanggan' => DB::table('tbl_pelanggan')->where('status', 'aktif')->get(),
            'berlangganan' => DB::table('tbl_berlangganan')->get(),
            'set_day' => DB::table('default_time')->select('set_day')->get()
            //master data end
        ];       

        return view('page.e-billing.regbilling', $data, compact('kode_reg', 'kode_inv' ));
    }


    ////////////////////////////////////////////////////////////////
    /////////////////////INSERT e-Billing /////////////////////////
    //////////////////////////////////////////////////////////////
    public function store(Request $request){
        $this->validate($request, [
            //relasi start
            'id_invoice' => 'required',
            'kode_reg' => 'required',
            'kode_paket' => 'required',
            'kode_pelanggan' => 'required',
            //relasi end

            //start date
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'berlangganan' => 'required',
            'bulan' => 'required',
            //end date

            'file' => 'nullable',
            'note' => 'nullable',
        ]);


        $transaksi = DB::table('tbl_registrasi')->insert([

            //kode relasi start
            'kode_reg' => $request->kode_reg,
            'kode_paket' => $request->kode_paket,
            'kode_pelanggan' => $request->kode_pelanggan,
            //kode relasi end

            //harga
            'harga' => $request->harga,
            'pajak' => $request->pajak,
            'subtotal' => $request->subtotal,
            //harga

            //set date start
            'start_reg' => $request->start_reg,
            'end_reg' => $request->end_reg,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
            /////
            'berlangganan' => $request->berlangganan,
            'bulan' => $request->bulan,
            //set date end
            
            //upload file
            'note' => $request->note,
            
        ]);

        $transaksi = DB::table('tbl_invoice')->insert([

            //kode relasi start
            'id_invoice' => $request->id_invoice,
            'kode_reg' => $request->kode_reg,
            'kode_paket' => $request->kode_paket,
            'kode_pelanggan' => $request->kode_pelanggan,
            //kode relasi end            

            //harga
            'harga' => $request->harga,
            'pajak' => $request->pajak,
            'subtotal' => $request->subtotal,
            //harga

            //set date start
            'start_inv' => $request->start_inv,
            'end_inv' => $request->end_inv,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
            /////
            'berlangganan' => $request->berlangganan,
            'bulan' => $request->bulan,
            //set date end

            //upload file
            'note' => $request->note,
        ]);

        
        if($transaksi){
            //redirect dengan pesan sukses
            return redirect()->route('billing')->with(['success' => 'Berhasil Ditambahkan!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('billing')->with(['error' => 'Gagal Ditambahkan!']);
        }
          
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////INSERT e-Billing /////////////////////////
    //////////////////////////////////////////////////////////////




    ////////////////////////////////////////////////////////////////
    /////////////////////////BAYAR e-Billing//////////////////////
    //////////////////////////////////////////////////////////////
    public function bayar(Request $request)
    {
        $bayar = DB::table('tbl_registrasi')->where('kode_reg',$request->kode_reg)->update([
            'status_reg' => $request->status_reg,

            //set date start
            'start_reg' => $request->start_reg,
            'end_reg' => $request->end_reg,
            //////
            'updated_at' => $request->updated_at,
            /////
            'bulan' => $request->bulan,
            //set date end

            //harga
            'harga' => $request->harga,
            'subtotal' => $request->subtotal,
            'pajak' => $request->pajak,
            'total' => $request->total,
            //harga
            
            'note' => $request->note,

        ]);

        $bayar = DB::table('tbl_invoice')->where('kode_reg',$request->kode_reg)->update([
            'kode_reg' => $request->kode_reg,
            'status_inv' => $request->status_inv,

            //set date start
            'updated_at' => $request->updated_at,
            //set date end

            //harga
            'pajak' => $request->pajak,
            'harga' => $request->harga,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            //harga        
            
            'note' => $request->note,
            
        ]);

        $bayar = DB::table('tbl_invoice')->insert([
            //kode relasi start
            'id_invoice' => $request->id_invoice,
            'kode_reg' => $request->kode_reg,
            'kode_paket' => $request->kode_paket,
            'kode_pelanggan' => $request->kode_pelanggan,
            //kode relasi end            

            //harga
            'harga' => $request->harga,
            'pajak' => $request->pajak,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            //harga

            //set date start
            'start_inv' => $request->start_inv,
            'end_inv' => $request->end_inv,
            'updated_at' => $request->updated_at,
            /////
            'berlangganan' => $request->berlangganan,
            'bulan' => $request->bulan,
            //set date end

            //upload file
            'note' => $request->note,
        ]);

        if($bayar){
            //redirect dengan pesan sukses
            return redirect()->route('billing')->with(['success' => 'Berhasil Ditambahkan!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('billing')->with(['error' => 'Gagal Ditambahkan!']);
        }
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////BAYAR e-Billing//////////////////////
    //////////////////////////////////////////////////////////////

    public function nonaktif(Request $request)
    {
        $nonaktif = DB::table('tbl_registrasi')->where('kode_reg',$request->kode_reg)->update([
            'option' => $request->option,        
        ]);

        $nonaktif = DB::table('tbl_invoice')->where('id_invoice',$request->id_invoice)->update([
            'option' => $request->option,        
        ]);

        if($nonaktif){
            //redirect dengan pesan sukses
            return redirect()->route('billing')->with(['success' => 'Berhasil Dinonaktifkan!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('billing')->with(['error' => 'Gagal Dinonaktifkan!']);
        }
    }


    ////////////////////////////////////////////////////////////////
    /////////////////////Perpanjang e-Billing//////////////////////
    //////////////////////////////////////////////////////////////
    public function perpanjang(Request $request)
    {
        $perpanjang = DB::table('tbl_registrasi')->where('kode_reg',$request->kode_reg)->update([
            'status_reg' => $request->status_reg,

            //set date start
            'start_reg' => $request->start_reg,
            'end_reg' => $request->end_reg,
            //////
            'updated_at' => $request->updated_at,
            /////
            'bulan' => $request->bulan,
            //set date end

            //harga
            'harga' => $request->harga,
            'subtotal' => $request->subtotal,
            'pajak' => $request->pajak,
            'total' => $request->total,
            //harga
            
            'note' => $request->note,

        ]);

        $perpanjang = DB::table('tbl_invoice')->where('kode_reg',$request->kode_reg)->update([
            'kode_reg' => $request->kode_reg,
            'status_inv' => $request->status_inv,

            //set date start
            'updated_at' => $request->updated_at,
            //set date end

            //harga
            'pajak' => $request->pajak,
            'harga' => $request->harga,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            //harga        
            
            'note' => $request->note,
            
        ]);

        $perpanjang = DB::table('tbl_invoice')->insert([
            //kode relasi start
            'id_invoice' => $request->id_invoice,
            'kode_reg' => $request->kode_reg,
            'kode_paket' => $request->kode_paket,
            'kode_pelanggan' => $request->kode_pelanggan,
            //kode relasi end            

            //harga
            'harga' => $request->harga,
            'pajak' => $request->pajak,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            //harga

            //set date start
            'start_inv' => $request->start_inv,
            'end_inv' => $request->end_inv,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
            /////
            'berlangganan' => $request->berlangganan,
            'bulan' => $request->bulan,
            //set date end

            //upload file
            'note' => $request->note,
        ]);

        if($perpanjang){
            //redirect dengan pesan sukses
            return redirect()->route('billing')->with(['success' => 'Berhasil Ditambahkan!!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('billing')->with(['error' => 'Gagal Ditambahkan!']);
        }
    }









































    function getBeforeDays($specDay, $days, $format = 'Y-m-d') {
        $d = date('d', strtotime($specDay)); 
        $m = date('m', strtotime($specDay)); 
        $y = date('Y', strtotime($specDay));
        $dateArray = array();
        for($i=1; $i<=$days; $i++) {
            $dateArray[] = '"' . date($format, mktime(0,0,0,$m,($d+$i),$y)) . '"'; 
        }
        return $dateArray;
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////Perpanjang e-Billing//////////////////////
    //////////////////////////////////////////////////////////////


    ////////////////////////////////////////////////////////////////
    /////////////////////////Search pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////
    public function search(Request $request)
    {
         //generate kode paket
        $random =  rand(1,100);
        $kode_reg = 'REG'.'-'.sprintf("%01s", $random).date('mdY');
        $inv =  rand(1,100);
        $kode_inv = 'INV'.'-'.sprintf("%01s", $inv).date('mdY');


        $data = [
            //reg start
            'register' => DB::table('tbl_registrasi')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
            ->where('tbl_registrasi.option', 'aktif')
            ->get(),
            //reg end


            //invoice start
            'invoice' => DB::table('tbl_invoice')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
            ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
            ->where('tbl_invoice.option', 'aktif')
            ->get(),
            //invoice end
            

            //count start
            'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
            'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
            'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
            //count end


            //master data start
            'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
            'pelanggan' => DB::table('tbl_pelanggan')->get(),
            'berlangganan' => DB::table('tbl_berlangganan')->get(),
            'set_day' => DB::table('default_time')->select('set_day')->get()
            //master data end
        ];  


        //////////////////////////SEARCH ONE FIELD////////////////////////////////
        if ($request->kode_reg)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->get(),
                //reg end
            ];  
        }

        if ($request->nama)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
               //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
                //reg end
            ];  
        }


        if ($request->start_reg)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                ->get(),
                //reg end
            ];  
        }



        if ($request->value)
        {

            

            if($request->value == "Aktif") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->value == "Perpanjang") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->value == "Expired") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

            
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }

      
        }
        //////////////////////////SEARCH ONE FIELD////////////////////////////////





        //////////////////////////SEARCH CONDITION FIELD////////////////////////////////


        //////////////////////////SEARCH KODE FIELD START////////////////////////////////
        if ($request->kode_reg && $request->nama)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
                //reg end
            ];  
        }


        if ($request->kode_reg && $request->start_reg)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                ->get(),
                //reg end
            ];  
        }


        if ($request->kode_reg && $request->start_reg && $request->end_tanggal)
        {
            $start = $request->start_reg;
            $end = $request->end_tanggal;

            $data = [
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                ->whereBetween('start_reg', [$start, $end])
                ->get(),
                //reg end
            ];   
        }         

        if ($request->kode_reg && $request->start_reg && $request->end_tanggal && $request->value)
        {

            

            if($request->kode_reg && $request->start_reg && $request->end_tanggal && $request->value == "Aktif") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->start_reg && $request->end_tanggal && $request->value == "Perpanjang") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->start_reg && $request->end_tanggal && $request->value == "Expired") {

                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }


        if ($request->kode_reg && $request->nama && $request->start_reg && $request->end_tanggal && $request->value)
        {

            

            if($request->kode_reg && $request->nama && $request->start_reg && $request->end_tanggal && $request->value == "Aktif") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->nama && $request->start_reg && $request->end_tanggal && $request->value == "Perpanjang") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                   //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->nama && $request->start_reg && $request->end_tanggal && $request->value == "Expired") {

                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }
        //////////////////////////SEARCH KODE FIELD END////////////////////////////////




        //////////////////////////SEARCH VALUE FIELD START////////////////////////////////
        if ($request->kode_reg && $request->value)
        {

            

            if($request->kode_reg && $request->value == "Aktif") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->value == "Perpanjang") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->value == "Expired") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }


        if ($request->nama && $request->value)
        {

            

            if($request->nama && $request->value == "Aktif") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->nama && $request->value == "Perpanjang") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->nama && $request->value == "Expired") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }

        if ($request->start_reg && $request->value)
        {

            

            if($request->start_reg && $request->value == "Aktif") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->start_reg && $request->value == "Perpanjang") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->start_reg && $request->value == "Expired") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }

        if ($request->start_reg && $request->end_tanggal && $request->value)
        {

            

            if($request->start_reg && $request->end_tanggal && $request->value == "Aktif") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->start_reg && $request->end_tanggal && $request->value == "Perpanjang") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->start_reg && $request->end_tanggal && $request->value == "Expired") {

                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }
        //////////////////////////SEARCH VALUE FIELD END////////////////////////////////


        //////////////////////////SEARCH CONDITION FIELD////////////////////////////////




        

        return view('page.e-billing.regbilling', $data, compact('kode_reg', 'kode_inv' ));
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Search pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////


    
    ////////////////////////////////////////////////////////////////
    /////////////////////////print pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////
    public function print(Request $request)
    {
         //generate kode paket
        $random =  rand(1,100);
        $kode_reg = 'REG'.'-'.sprintf("%01s", $random).date('mdY');
        $inv =  rand(1,100);
        $kode_inv = 'INV'.'-'.sprintf("%01s", $inv).date('mdY');


        $data = [
            //reg start
            'register' => DB::table('tbl_registrasi')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
            ->where('tbl_registrasi.option', 'aktif')
            ->get(),
            //reg end


            //invoice start
            'invoice' => DB::table('tbl_invoice')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
            ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
            ->where('tbl_invoice.option', 'aktif')
            ->get(),
            //invoice end
            

            //count start
            'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
            'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
            'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
            //count end


            //master data start
            'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
            'pelanggan' => DB::table('tbl_pelanggan')->get(),
            'berlangganan' => DB::table('tbl_berlangganan')->get(),
            'set_day' => DB::table('default_time')->select('set_day')->get()
            //master data end
        ];  


        //////////////////////////SEARCH ONE FIELD////////////////////////////////
        if ($request->kode_reg)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->get(),
                //reg end
            ];  
        }

        if ($request->nama)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
               //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
                //reg end
            ];  
        }


        if ($request->start_reg)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                ->get(),
                //reg end
            ];  
        }



        if ($request->value)
        {

            

            if($request->value == "Aktif") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->value == "Perpanjang") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->value == "Expired") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }

      
        }
        //////////////////////////SEARCH ONE FIELD////////////////////////////////





        //////////////////////////SEARCH CONDITION FIELD////////////////////////////////


        //////////////////////////SEARCH KODE FIELD START////////////////////////////////
        if ($request->kode_reg && $request->nama)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get(),
                //reg end
            ];  
        }


        if ($request->kode_reg && $request->start_reg)
        {
            $data = [
                
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                ->get(),
                //reg end
            ];  
        }


        if ($request->kode_reg && $request->start_reg && $request->end_tanggal)
        {
            $start = $request->start_reg;
            $end = $request->end_tanggal;

            $data = [
                //invoice start
                'invoice' => DB::table('tbl_invoice')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->where('tbl_invoice.option', 'aktif')
                ->get(),
                //invoice end
                
    
                //count start
                'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                //count end

    
                //master data start
                'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                'pelanggan' => DB::table('tbl_pelanggan')->get(),
                'berlangganan' => DB::table('tbl_berlangganan')->get(),
                'set_day' => DB::table('default_time')->select('set_day')->get(),
                //master data end

                //reg start
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->where('tbl_registrasi.option', 'aktif')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                ->whereBetween('start_reg', [$start, $end])
                ->get(),
                //reg end
            ];   
        }         

        if ($request->kode_reg && $request->start_reg && $request->end_tanggal && $request->value)
        {

            

            if($request->kode_reg && $request->start_reg && $request->end_tanggal && $request->value == "Aktif") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->start_reg && $request->end_tanggal && $request->value == "Perpanjang") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->start_reg && $request->end_tanggal && $request->value == "Expired") {

                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }


        if ($request->kode_reg && $request->nama && $request->start_reg && $request->end_tanggal && $request->value)
        {

            

            if($request->kode_reg && $request->nama && $request->start_reg && $request->end_tanggal && $request->value == "Aktif") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->nama && $request->start_reg && $request->end_tanggal && $request->value == "Perpanjang") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                   //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->nama && $request->start_reg && $request->end_tanggal && $request->value == "Expired") {

                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }
        //////////////////////////SEARCH KODE FIELD END////////////////////////////////




        //////////////////////////SEARCH VALUE FIELD START////////////////////////////////
        if ($request->kode_reg && $request->value)
        {

            

            if($request->kode_reg && $request->value == "Aktif") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->value == "Perpanjang") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->kode_reg && $request->value == "Expired") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('kode_reg', 'like', '%'.$request->kode_reg.'%')
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }


        if ($request->nama && $request->value)
        {

            

            if($request->nama && $request->value == "Aktif") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->nama && $request->value == "Perpanjang") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->nama && $request->value == "Expired") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }

        if ($request->start_reg && $request->value)
        {

            

            if($request->start_reg && $request->value == "Aktif") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->start_reg && $request->value == "Perpanjang") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->start_reg && $request->value == "Expired") {

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }

        if ($request->start_reg && $request->end_tanggal && $request->value)
        {

            

            if($request->start_reg && $request->end_tanggal && $request->value == "Aktif") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->start_reg && $request->end_tanggal && $request->value == "Perpanjang") {
                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    // ->where(getBeforeDays('end_reg', 7, 'Y-m-d'))
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '>=', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];

            } elseif($request->start_reg && $request->end_tanggal && $request->value == "Expired") {

                $start = $request->start_reg;
                $end = $request->end_tanggal;

                $data = [
                
                    //invoice start
                    'invoice' => DB::table('tbl_invoice')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                    ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                    ->where('tbl_invoice.option', 'aktif')
                    ->get(),
                    //invoice end
                    
        
                    //count start
                    'belumbayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'BelumBayar')->get(),
                    'bayar' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    'total' => DB::table('tbl_registrasi')->select('total')->where('status_reg', 'Berlangganan')->get(),
                    //count end

        
                    //master data start
                    'paket' => DB::table('tbl_paket')->where('value', 'true')->get(),
                    'pelanggan' => DB::table('tbl_pelanggan')->get(),
                    'berlangganan' => DB::table('tbl_berlangganan')->get(),
                    'set_day' => DB::table('default_time')->select('set_day')->get(),
                    //master data end
    
                    
                    //reg start
                    'register' => DB::table('tbl_registrasi')
                    ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                    ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                    ->where('tbl_registrasi.option', 'aktif')
                    ->where('start_reg', 'like', '%'.$request->start_reg.'%')
                    ->whereBetween('start_reg', [$start, $end])
                    ->where('end_reg', '<', date('Y-m-d'))
                    ->get(),
                    //reg end
                ];
            }  
        }
        //////////////////////////SEARCH VALUE FIELD END////////////////////////////////


        //////////////////////////SEARCH CONDITION FIELD////////////////////////////////




        

        return view('page.e-billing.print', $data, compact('kode_reg', 'kode_inv' ));
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////print pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////
   
}
