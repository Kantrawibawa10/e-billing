<?php

namespace App\Http\Controllers\page\invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    ///invoice wng start
    public function wng(Request $request)
    {
        $data = [
            'invoicewng' => DB::table('tbl_invoice')
            // pelanggan
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
            // paket
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
            // reg
            ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
            
            ->where('id_invoice', $request->id_invoice)
            ->get(),
        ];
        return view('page.invoice.invoicewng', $data);
    }
    ///invoice wng end


    ///invoice sry start
    public function sry(Request $request)
    {
        $data = [
            'invoicesry' => DB::table('tbl_invoice')
            // pelanggan
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
            // paket
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
            // reg
            ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
            
            ->where('id_invoice', $request->id_invoice)
            ->get(),
        ];
        return view('page.invoice.invoicesry', $data);
    }
    ///invoice sry end

     ///invoice wng start
     public function wngprint(Request $request)
     {
         $data = [
             'invoicewng' => DB::table('tbl_invoice')
             // pelanggan
             ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
             // paket
             ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
             // reg
             ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
             
             ->where('id_invoice', $request->id_invoice)
             ->get(),
         ];
         return view('page.invoice.invoicewngprint', $data);
     }
     ///invoice wng end
 
 
     ///invoice sry start
     public function sryprint(Request $request)
     {
         $data = [
             'invoicesry' => DB::table('tbl_invoice')
             // pelanggan
             ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
             // paket
             ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
             // reg
             ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
             
             ->where('id_invoice', $request->id_invoice)
             ->get(),
         ];
         return view('page.invoice.invoicesryprint', $data);
     }
     ///invoice sry end

    
    public function index(Request $request)
    {
        $data = [
            'invoice' => DB::table('tbl_invoice')
            // pelanggan
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
            // paket
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
            // reg
            ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
            ->orderBy('id_invoice', 'DESC')
            ->get(),
            

            'register' => DB::table('tbl_registrasi')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
            ->get(),

            'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
            'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),
        ];

        return view('page.invoice.invoice', $data);
    }


    ////////////////////////////////////////////////////////////////
    /////////////////////////Search pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////
    public function searchinvoice(Request $request)
    {
        $data = [
            'invoice' => DB::table('tbl_invoice')
            // pelanggan
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
            // paket
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
            // reg
            ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
            ->orderBy('id_invoice', 'DESC')
            ->get(),
            

            'register' => DB::table('tbl_registrasi')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
            ->get(),

            'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
            'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),
        ];

        //generate kode pelanggan
        $random =  rand(1,50);
        $kode_pelanggan = 'CST'.'-'.sprintf("%04s", $random).date('Y');  


        //////////////////////////SEARCH ONE FIELD////////////////////////////////
        if ($request->id_invoice )
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->get(),
            ];
        }


        if ($request->nama)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];
        }


        if ($request->start_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->get(),
            ];
        }

        if ($request->status_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('status_inv', 'like', '%'.$request->status_inv.'%')
                ->get(),
            ];
        }
        //////////////////////////SEARCH ONE FIELD////////////////////////////////

        if ($request->start_inv && $request->end_tanggal)
        {
            $start = $request->start_inv;
            $end = $request->end_tanggal;

            $data = [

                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->whereBetween('start_inv', [$start, $end])
                ->get(),

            ];   
        }         



        //////////////////////////SEARCH CONDITION////////////////////////////////

        ///kode start
        if ($request->id_invoice && $request->start_inv && $request->end_tanggal)
        {
            $start = $request->start_inv;
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
                'belumbayar' => DB::table('tbl_invoice')->select('total')->where('status_inv', 'BelumBayar')->get(),
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
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->whereBetween('start_inv', [$start, $end])
                ->get(),
                //reg end
            ];   
        } 


        if ($request->id_invoice && $request->nama)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];
        }


        if ($request->id_invoice && $request->start_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->get(),
            ];
        }

        if ($request->id_invoice && $request->status_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('status_inv', 'like', '%'.$request->status_inv.'%')
                ->get(),
            ];
        }


        if ($request->id_invoice && $request->nama && $request->start_inv) 
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->get(),
            ];
        }


        if ($request->id_invoice && $request->nama && $request->start_inv && $request->status_inv) 
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->where('status_inv', 'like', '%'.$request->status_inv.'%')
                ->get(),
            ];
        }


        if ($request->id_invoice && $request->nama && $request->start_inv && $request->end_tanggal && $request->status_inv) 
        {
            $start = $request->start_inv;
            $end = $request->end_tanggal;

            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->whereBetween('start_inv', [$start, $end])
                ->where('status_inv', 'like', '%'.$request->status_inv.'%')
                ->get(),
            ];
        }


        if ($request->nama && $request->start_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->get(),
            ];
        }


        if ($request->nama && $request->end_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('end_inv', 'like', '%'.$request->end_inv.'%')
                ->get(),
            ];
        }


        if ($request->nama && $request->start_inv && $request->end_inv) 
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->where('end_inv', 'like', '%'.$request->end_inv.'%')
                ->get(),
            ];
        }


        if ($request->start_inv && $request->end_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->where('end_inv', 'like', '%'.$request->end_inv.'%')
                ->get(),
            ];
        }

        return view('page.invoice.invoice', $data);
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Search pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////
    /////////////////////////Search pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////
    public function printinvoice(Request $request)
    {
        $data = [
            'invoice' => DB::table('tbl_invoice')
            // pelanggan
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
            // paket
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
            // reg
            ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
            ->orderBy('id_invoice', 'DESC')
            ->get(),
            

            'register' => DB::table('tbl_registrasi')
            ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
            ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
            ->get(),

            'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
            'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),
        ];

        //generate kode pelanggan
        $random =  rand(1,50);
        $kode_pelanggan = 'CST'.'-'.sprintf("%04s", $random).date('Y');  


        //////////////////////////SEARCH ONE FIELD////////////////////////////////
        if ($request->id_invoice )
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->get(),
            ];
        }


        if ($request->nama)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];
        }


        if ($request->start_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->get(),
            ];
        }

        if ($request->status_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('status_inv', 'like', '%'.$request->status_inv.'%')
                ->get(),
            ];
        }
        //////////////////////////SEARCH ONE FIELD////////////////////////////////

        if ($request->start_inv && $request->end_tanggal)
        {
            $start = $request->start_inv;
            $end = $request->end_tanggal;

            $data = [

                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->whereBetween('start_inv', [$start, $end])
                ->get(),

            ];   
        }         



        //////////////////////////SEARCH CONDITION////////////////////////////////

        ///kode start
        if ($request->id_invoice && $request->start_inv && $request->end_tanggal)
        {
            $start = $request->start_inv;
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
                'belumbayar' => DB::table('tbl_invoice')->select('total')->where('status_inv', 'BelumBayar')->get(),
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
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->whereBetween('start_inv', [$start, $end])
                ->get(),
                //reg end
            ];   
        } 


        if ($request->id_invoice && $request->nama)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->get(),
            ];
        }


        if ($request->id_invoice && $request->start_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->get(),
            ];
        }

        if ($request->id_invoice && $request->status_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('status_inv', 'like', '%'.$request->status_inv.'%')
                ->get(),
            ];
        }


        if ($request->id_invoice && $request->nama && $request->start_inv) 
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->get(),
            ];
        }


        if ($request->id_invoice && $request->nama && $request->start_inv && $request->status_inv) 
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->where('status_inv', 'like', '%'.$request->status_inv.'%')
                ->get(),
            ];
        }


        if ($request->id_invoice && $request->nama && $request->start_inv && $request->end_tanggal && $request->status_inv) 
        {
            $start = $request->start_inv;
            $end = $request->end_tanggal;

            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('id_invoice', 'like', '%'.$request->id_invoice.'%')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->whereBetween('start_inv', [$start, $end])
                ->where('status_inv', 'like', '%'.$request->status_inv.'%')
                ->get(),
            ];
        }


        if ($request->nama && $request->start_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->get(),
            ];
        }


        if ($request->nama && $request->end_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('end_inv', 'like', '%'.$request->end_inv.'%')
                ->get(),
            ];
        }


        if ($request->nama && $request->start_inv && $request->end_inv) 
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('tbl_pelanggan.nama', 'like', '%'.$request->nama.'%')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->where('end_inv', 'like', '%'.$request->end_inv.'%')
                ->get(),
            ];
        }


        if ($request->start_inv && $request->end_inv)
        {
            $data = [
                'register' => DB::table('tbl_registrasi')
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_registrasi.kode_pelanggan')
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_registrasi.kode_paket')
                ->get(),
                'belumbayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
                'bayar' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),

                'invoice' => DB::table('tbl_invoice')
                // pelanggan
                ->join('tbl_pelanggan', 'tbl_pelanggan.kode_pelanggan', '=', 'tbl_invoice.kode_pelanggan')
                // paket
                ->join('tbl_paket', 'tbl_paket.kode', '=', 'tbl_invoice.kode_paket')
                // reg
                ->join('tbl_registrasi', 'tbl_registrasi.kode_reg', '=', 'tbl_invoice.kode_reg')
                ->orderBy('id_invoice', 'DESC')
                ->where('start_inv', 'like', '%'.$request->start_inv.'%')
                ->where('end_inv', 'like', '%'.$request->end_inv.'%')
                ->get(),
            ];
        }

        return view('page.invoice.print', $data);
    }
    ////////////////////////////////////////////////////////////////
    /////////////////////////Search pelanggan//////////////////////////
    //////////////////////////////////////////////////////////////




}
