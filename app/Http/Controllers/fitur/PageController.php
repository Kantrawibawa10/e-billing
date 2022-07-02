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
            'page' => DB::table('page_view')->where('value', 'true')->get(),
        ];

        return view('page.layouts.sidebar', $data);
    }

    

}
