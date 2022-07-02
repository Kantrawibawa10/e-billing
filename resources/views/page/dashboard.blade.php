@extends('layouts.app')
@extends('layouts.sidebar')
@section('content')
<header class="mb-3">
  <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
  </a>
</header>

<style>
    .icon {fill: #ffffff}
</style>

<div class="page-heading mb-0 row justify-content-between">
  <div class="col-12 col-lg-9 col-md-12 pb-3">
    <h3>Dashboard</h3>
    <p>Halo!! Selamat Datang {{ auth()->user()->level }}</p>
    <p class="text-gray"><i class="bi bi-calendar2"></i> Tanggal: <?php echo date('d M Y') ?></p>
  </div>

  <div class="col-12 col-lg-3 col-md-12">
        <div class="card">
            <div class="card-body py-4 px-5">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl">
                        <img src="../assets/images/faces/1.jpg" alt="Face 1">
                    </div>
                    
                    <div class="ms-3 name">
                        <h5 class="font-bold">{{ auth()->user()->username }}</h5>
                        <h6 class="text-muted mb-0">{{ auth()->user()->kode }}</h6>
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>


<div class="page-content">
   <section>

        {{-- row data halaman dashboard start--}}
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                <div class="stats-icon blue">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Pelanggan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $pelanggan1->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                    <?xml version="1.0" encoding="UTF-8"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-cash-usd" width="30" height="30" viewBox="0 0 24 24">
                                        <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.9 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.1 4 20 4M15 10H11V11H14C14.55 11 15 11.45 15 12V15C15 15.55 14.55 16 14 16H13V17H11V16H9V14H13V13H10C9.45 13 9 12.55 9 12V9C9 8.45 9.45 8 10 8H11V7H13V8H15V10Z" />
                                    </svg>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Terbayar</h6>
                                    <h6 class="font-extrabold mb-0">@currency($hitung->sum('subtotal'))</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                    <?xml version="1.0" encoding="UTF-8"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-cash-usd" width="30" height="30" viewBox="0 0 24 24">
                                        <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.9 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.1 4 20 4M15 10H11V11H14C14.55 11 15 11.45 15 12V15C15 15.55 14.55 16 14 16H13V17H11V16H9V14H13V13H10C9.45 13 9 12.55 9 12V9C9 8.45 9.45 8 10 8H11V7H13V8H15V10Z" />
                                    </svg>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Belum Terbayar</h6>
                                    <h6 class="font-extrabold mb-0">@currency($hitung1->sum('subtotal'))</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                    <?xml version="1.0" encoding="UTF-8"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="mdi-cash-usd" width="30" height="30" viewBox="0 0 24 24">
                                        <path d="M20 4H4C2.89 4 2 4.89 2 6V18C2 19.11 2.9 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.1 4 20 4M15 10H11V11H14C14.55 11 15 11.45 15 12V15C15 15.55 14.55 16 14 16H13V17H11V16H9V14H13V13H10C9.45 13 9 12.55 9 12V9C9 8.45 9.45 8 10 8H11V7H13V8H15V10Z" />
                                    </svg>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Total Uang</h6>
                                    <h6 class="font-extrabold mb-0">@currency($total->sum('subtotal'))</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
        {{-- row data halaman dashboard end --}}

        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pelanggan</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
      
        </div>



        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4>Pelanggan Bulan Ini</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead>
                                <tr style="font-size: 13px">
                                    <th>Kode</th>
                                    <th>NIK</th>
                                    <th>Pelanggan</th>
                                    <th>Telpn</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pelanggan as $item)
                                <tr>
                                  <td class="col-auto">
                                    <p class=" mb-0" style="font-size: 12px">{{ $item->kode_pelanggan }}</p>
                                  </td>
      
                                  <td class="col-auto">
                                    <p class=" mb-0" style="font-size: 12px">{{$item->nik}}</p>
                                  </td>

                                  <td class="col-auto">
                                    <p class="font-bold mb-0" style="font-size: 12px">{{$item->nama}}</p>
                                  </td>

      
                                    <td class="col-auto">
                                        <p class=" mb-0" style="font-size: 12px">{{$item->no_telpn}}</p>
                                    </td>
      
                                    <td class="col-auto">
                                      <p class=" mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->created_at)) }}</p>
                                    </td>
      
                                    <td class="col-auto">
                                      <p class=" mb-0" style="font-size: 12px" >{{ date('d M, Y', strtotime($item->updated_at)) }}</p>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

   </section>
</div>


@endsection