<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\page\IndexController;
use App\Http\Controllers\page\pelanggan\PelangganController;
use App\Http\Controllers\page\user\UserController;
use App\Http\Controllers\page\fitur\PageController;
use App\Http\Controllers\page\paket\PaketController;
use App\Http\Controllers\page\billing\BillingController;
use App\Http\Controllers\page\invoice\InvoiceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Email_Controller;
use App\Http\Controllers\DefaultController;


//pelangggan
Route::get('/getPelanggan/{kode}', function ($kode) {
    $pelanggan = DB::table('tbl_pelanggan')->where('kode_pelanggan', $kode)->get();
    return response()->json($pelanggan);
})->name('getPelanggan');
//pelanggan

//paket
Route::get('/getPaket/{Kode}', function ($Kode) {
    $paket = DB::table('tbl_paket')->where('kode', $Kode)->get();
    return response()->json($paket);
})->name('getPaket');
//paket


//berlangganan
Route::get('/getBulan/{id}', function ($id) {
    $bulan = DB::table('tbl_berlangganan')->where('id', $id)->get();
    return response()->json($bulan);
})->name('getBulan');
//berlangganan



//berlangganan
Route::get('/getBayar/{kode_reg}', function ($kode_reg) {
    $bayar = DB::table('tbl_registrasi')->where('kode_reg', $kode_reg)->get();
    return response()->json($bayar);
})->name('getBayar');
//berlangganan




Route::get('/', function () {
    if (Auth::user()) {
        return redirect('/dashboard');
    }

    return view('auth.login');
}); 

//login controller
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
//login controller

//logout controller
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
//logout controller


Route::get('/dashboard', [IndexController::class, 'index'])->name('dashboard');






//pelanggan start
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
//aksi
Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('addpelanggan');
Route::post('/pelanggan/update/{kode_pelanggan}', [PelangganController::class, 'update'])->name('editpelanggan');
//print
Route::get('/pelanggan/print', [PelangganController::class, 'print'])->name('printpelanggan');
//search
Route::get('/pelanggan/search', [PelangganController::class, 'search'])->name('searchpelanggan');
//pelanggan end





//user-management
Route::get('/user', [UserController::class, 'index'])->name('user');
Route::post('/user/store', [UserController::class, 'store'])->name('adduser');
Route::post('/user/update/{kode}', [UserController::class, 'update'])->name('edituser');
Route::post('/user/updatepassword/{kode}', [UserController::class, 'updatepassword'])->name('updatepassword');
//search
Route::get('/user/search', [UserController::class, 'search'])->name('searchuser');




//paket
Route::get('/paket', [PaketController::class, 'index'])->name('paket');
//aksi
Route::post('/paket/store', [PaketController::class, 'store'])->name('addpaket');
Route::post('/paket/update/{kode}', [PaketController::class, 'update'])->name('editpaket');
Route::get('/paket/deleted/{kode}', [PaketController::class, 'deleted'])->name('deletedpaket');
//search
Route::get('/paket/search', [PaketController::class, 'search'])->name('searchpaket');
//paket





// billing
Route::get('/billing', [BillingController::class, 'index'])->name('billing');
Route::get('/test', [BillingController::class, 'test'])->name('test');

///transaksi
Route::post('/billing/store', [BillingController::class, 'store'])->name('addregis');
Route::post('/billing/bayar/{kode_reg}', [BillingController::class, 'bayar'])->name('bayar');
Route::post('/billing/perpanjang/{kode_reg}', [BillingController::class, 'perpanjang'])->name('perpanjang');
Route::post('/billing/nonaktif/{kode_reg}', [BillingController::class, 'nonaktif'])->name('nonaktif');

// //search
Route::get('/billing/search', [BillingController::class, 'search'])->name('searchbilling');
Route::get('/billing/print', [BillingController::class, 'print'])->name('printbilling');






//invoice start
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice');
//search
Route::get('/search', [InvoiceController::class, 'searchinvoice'])->name('searchinvoice');
//print
Route::get('/print', [InvoiceController::class, 'printinvoice'])->name('printinvoice');
//invoice end



//invoice start
Route::get('/invoicewng/{id_invoice}', [InvoiceController::class, 'wng'])->name('invoicewng');
Route::get('/invoicesry/{id_invoice}', [InvoiceController::class, 'sry'])->name('invoicesry');
Route::get('/invoicewng/print/{id_invoice}', [InvoiceController::class, 'wngprint'])->name('invoicewngprint');
Route::get('/print/{id_invoice}', [InvoiceController::class, 'sryprint'])->name('invoicesryprint');
//invoice end






//setDefault
Route::get('/system', [DefaultController::class, 'index'])->name('system');
Route::post('/system/setday/{id}', [DefaultController::class, 'setday'])->name('set');
Route::post('/system/berlangganan/{id}', [DefaultController::class, 'setberlangganan']);
Route::post('/system/berlangganan', [DefaultController::class, 'addberlangganan'])->name('berlangganan');






//email
Route::get('/email', [Email_Controller::class, 'test_mailable_content'])->name('email');
