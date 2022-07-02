<?php

namespace App\Http\Controllers\page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class IndexController extends Controller
{
    public function __construct()
     {
         $this->middleware(['auth']);
     }
    
    public function index()
    {
        $data = [
            'pelanggan' => DB::table('tbl_pelanggan')->where('bulan', date('m'))->get(),
            'pelanggan1' => DB::table('tbl_pelanggan')->get(),
            'hitung' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'Berlangganan')->get(),
            'hitung1' => Db::table('tbl_invoice')->select('subtotal')->where('status_inv', 'BelumBayar')->get(),
            'total' => Db::table('tbl_invoice')->select('subtotal')->get(),
        ];

        return view('page.dashboard', $data);
    }
    
}
