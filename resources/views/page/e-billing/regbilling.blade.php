@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<header class="mb-3">
  <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
  </a>
</header>

<div class="page-heading mb-0 pb-0 row justify-content-between">
  <div class="col-12 col-lg-9 col-md-12 pb-3">
    <h3>Halaman e-Billing</h3>
    <p>Berisi Data Registrasi Pelanggan</p>
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


<div class="page-content pt-0 mt-0">
  <section class="row">
    
    {{-- row data halaman pelanggan start--}}
    <div class="col-12 col-lg-12">
      <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
              <div class="card-body px-3 py-4-5">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="stats-icon red">
                          <i class="bi bi-bar-chart-line-fill"></i>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <h6 class="text-muted font-semibold">Jumlah Register</h6>
                      <h6 class="font-extrabold mb-0">{{ $register->count() }}</h6>
                    </div>
                  </div>
              </div>
          </div>
        </div>
          

        <!-- <style>
          .icon  {fill: #ffffff}
        </style> -->

        <div class="col-6 col-lg-3 col-md-6">
          <div class="card">
              <div class="card-body px-3 py-4-5">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="stats-icon blue">
                            <i class="fas fa-sack-dollar"></i>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <h6 class="text-muted font-semibold">Terbayar</h6>
                          <h6 class="font-extrabold mb-0">@currency($bayar->sum('total'))</h6>
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
                            <i class="fas fa-sack-dollar"></i>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <h6 class="text-muted font-semibold">Belum Terbayar</h6>
                          <h6 class="font-extrabold mb-0">@currency($belumbayar->sum('total'))</h6>
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
                          <div class="stats-icon green">
                            <i class="fas fa-sack-dollar"></i>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <h6 class="text-muted font-semibold">Total Uang</h6>
                          <h6 class="font-extrabold mb-0">@currency($total->sum('total'))</h6>
                      </div>
                  </div>
              </div>
          </div>
        </div>

      </div>      
    </div>
    {{-- row data halaman pelanggan end --}}


    {{-- tabel pelanggan start --}}
    <div class="col-12 col-xl-12">
      <!--START SESSION ALERT-->
      @if(session()->get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>e-Billing</strong>   {{ session()->get('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif 

      @if(session()->get('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>e-Billing</strong>   {{ session()->get('error') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <!--END SESSION ALERT-->
      
      <div class="card container-fluid">
        <div class="card-header row justify-content-between">
          <div class="d-flex col-md-8">
            <h4>e-Billing</h4>
          </div>


          <div class="d-flex col-md-4 justify-content-end">
	          <div>
              <div class="btn-group btn-group-md mx-2">
                <a class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="refresh" href="">
                  <i class="bi bi-arrow-clockwise"></i>
                </a>
              </div>                
            </div>

            <div>
              <div class="btn-group btn-group-md" type="button" data-bs-toggle="modal" data-bs-target="#search">
                <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="search">
                  <i class="bi bi-search"></i>
                </a>
              </div>                
            </div>
            

            <div>
              <div class="btn-group btn-group-md mx-2" role="group" aria-label="..." type="button" data-bs-toggle="modal" data-bs-target="#print">
                <a class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                  <i class="bi bi-printer-fill"></i>
                </a>
              </div>                
            </div>

            <div>
              <div class="btn-group btn-group-md" role="group" aria-label="...">
                <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah" style="font-size: 12px;">
                  Add Register 
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                  </svg>
                </a>
              </div>                
            </div>               
          </div>                     
        </div>
        



        {{-- search modal print start --}}
        <div class="modal fade" id="print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="">
                  <div class="card-body card-7">
                    <form class="row from" action="{{ url("/billing/print") }}" method="get" >
                      <div class="input-group input--medium">
                        <label class="label">Kode Reg</label>
                        <input class="input--style-1" type="text" placeholder="XXXXXXX" id="input-start" name="kode_reg" value="{{Request::get('kode_reg')}}">
                      </div>

                      <div class="input-group input--large">
                        <label class="label">Nama</label>
                        <input class="input--style-1" type="text" placeholder="Nama Pelanggan" id="input-start" name="nama" value="{{Request::get('nama')}}">
                      </div>

                      <div class="input-group input--medium">
                        <label class="label">Tanggal</label>
                        <input class="input--style-1" type="date" placeholder="yyyy/mm/dd" id="input-start" name="start_reg" value="{{Request::get('start_reg')}}">
                      </div>
            
                      <div class="input-group input--medium">
                          <label class="label">Tanggal</label>
                          <input class="input--style-1" type="date" placeholder="yyyy/mm/dd" id="input-end" name="end_tanggal" value="{{Request::get('end_tanggal')}}">
                      </div>      
            
                      <div class="input-group input--medium">
                        <label class="label">Status</label>
                        <select name="value" id="input-start" class="input--style-1" type="text" value="{{Request::get('value')}}" style="border: none;">
                          @if(Request::get('value'))
                          <option value="Request::get('value')" selected disabled>{{ Request::get('value')}}</option>
                          @else
                          <option value="" selected disabled>Pilih Status</option>
                          @endif
                          <option value="">Semua</option>
                          <option value="Belum Bayar">Belum Bayar</option>
                          <option value="Aktif">Aktif</option>
                          <option value="Perpanjang">Perpanjang</option>
                          <option value="Expired">Expired</option>
                        </select>
                      </div>
            
                      <div class="input-group input--medium">
                        <button class="btn-submit" type="submit">search</button>
                      </div>      
                            
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- search modal print end --}}






        {{-- search modal start --}}
        <div class="modal fade" id="search" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="">
                  <div class="card-body card-7">
                    <form class="row from" action="{{ url("/billing/search") }}" method="get" >
                      <div class="input-group input--medium">
                        <label class="label">Kode Reg</label>
                        <input class="input--style-1" type="text" placeholder="XXXXXXX" id="input-start" name="kode_reg" value="{{Request::get('kode_reg')}}">
                      </div>

                      <div class="input-group input--large">
                        <label class="label">Nama</label>
                        <input class="input--style-1" type="text" placeholder="Nama Pelanggan" id="input-start" name="nama" value="{{Request::get('nama')}}">
                      </div>

                      <div class="input-group input--medium">
                        <label class="label">Tanggal</label>
                        <input class="input--style-1" type="date" placeholder="yyyy/mm/dd" id="input-start" name="start_reg" value="{{Request::get('start_reg')}}">
                      </div>
            
                      <div class="input-group input--medium">
                          <label class="label">Tanggal</label>
                          <input class="input--style-1" type="date" placeholder="yyyy/mm/dd" id="input-end" name="end_tanggal" value="{{Request::get('end_tanggal')}}">
                      </div>      
            
                      <div class="input-group input--medium">
                        <label class="label">Status</label>
                        <select name="value" id="input-start" class="input--style-1" type="text" value="{{Request::get('value')}}" style="border: none;">
                          @if(Request::get('value'))
                          <option value="Request::get('value')" selected disabled>{{ Request::get('value')}}</option>
                          @else
                          <option value="" selected disabled>Pilih Status</option>
                          @endif
                          <option value="">Semua</option>
                          <option value="Belum Bayar">Belum Bayar</option>
                          <option value="Aktif">Aktif</option>
                          <option value="Perpanjang">Perpanjang</option>
                          <option value="Expired">Expired</option>
                        </select>
                      </div>
            
                      <div class="input-group input--medium">
                        <button class="btn-submit" type="submit">search</button>
                      </div>      
                            
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- search modal end --}}

        <div class="card-body">
          <div class="table-responsive">
              <table id="example" class="table table-striped">
                <thead>
                    <tr style="font-size: 13px">
                      <th>NO</th>
                      <th>Register</th>
                      <th>Pelanggan</th>
                      <th>Paket</th>
                      <th>Biaya</th>
                      <th>Daftar</th>
                      <th>Expired</th>
                      <th>Aksi</th>
                    </tr>
                </thead>
                
                <tbody>
                @php $no = 1; @endphp
                @foreach ($register as $item)
                {{-- Start Kondisi Sudah Bayar --}}
                @if(Request::get('value') == "Expired")  
                  @if($item->end_reg <= date("Y-m-d"))
                    @if ($item->status_reg == 'Berlangganan')
                      <tr>
                        <td class="col-auto">
                          <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $no++ }}</p>
                        </td>
                        <td class="col-auto">
                          <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $item->kode_reg }}</p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">{{ $item->nama }}</p>
                        </td>
                        <td class="col-auto">
                          <p class="font-bold mb-0" style="font-size: 12px">{{ $item->nama_paket }}</p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">@currency($item->subtotal) </p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_reg)) }}</p>
                        </td>

                        
                        {{-- status masa aktif paket --}}                            
                        @if($item->end_reg <= date("Y-m-d")) 
                        <td class="col-auto">
                          <span class="text-danger mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_reg)) }}</span>
                        </td>          
                        @endif                                
                        {{-- status masa aktif paket --}}


                        {{-- Aksi start --}}
                        <td class="col-auto">
                          <div class="d-flex text-sm justify-content-around">
                            {{-- button invoice --}}
                            <div>
                              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a type="button" data-bs-toggle="modal" data-bs-target="#invoice{{ $item->kode_reg }}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                  <i class="bi bi-receipt-cutoff text-dark"></i>
                                </a>
                              </div>                
                            </div>
                            {{-- button invoice --}}
                            


                            {{-- button perpanjang --}}
                            @if(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d')) 
                            <div>
                              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a type="button" data-bs-toggle="modal" data-bs-target="#expired{{ $item->kode_reg }}" class="btn btn-danger" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                                  <i class="bi bi-check2-circle"></i>
                                </a>
                              </div>                
                            </div>
                            @endif

                            <div>
                              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a type="button" data-bs-toggle="modal" data-bs-target="#nonaktif{{ $item->kode_reg }}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                                  <i class="bi bi-x-circle-fill"></i>
                                </a>
                              </div>                
                            </div>
                            {{-- button perpanjang --}}
                          </div>
                        </td>
                        {{-- Aksi End --}}
                      </tr>
                      {{-- End Kondisi Sudah Bayar --}}
                    @endif
                  @endif




                @elseif(Request::get('value') == "Perpanjang")
                  @if(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                    @if ($item->status_reg == 'Berlangganan')
                      <tr>
                        <td class="col-auto">
                          <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $no++ }}</p>
                        </td>
                        <td class="col-auto">
                          <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $item->kode_reg }}</p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">{{ $item->nama }}</p>
                        </td>
                        <td class="col-auto">
                          <p class="font-bold mb-0" style="font-size: 12px">{{ $item->nama_paket }}</p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">@currency($item->subtotal) </p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_reg)) }}</p>
                        </td>


                        
                        {{-- status masa aktif paket --}}                            
                        @if(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d')) 
                        <td class="col-auto">
                          <span class="text-warning mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_reg)) }}</span>
                        </td>          
                        @endif                                
                        {{-- status masa aktif paket --}}


                        {{-- Aksi start --}}
                        <td class="col-auto">
                          <div class="d-flex text-sm justify-content-around">
                            {{-- button invoice --}}
                            <div>
                              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a type="button" data-bs-toggle="modal" data-bs-target="#invoice{{ $item->kode_reg }}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                  <i class="bi bi-receipt-cutoff text-dark"></i>
                                </a>
                              </div>                
                            </div>
                            {{-- button invoice --}}

                            
                            {{-- button perpanjang --}}
                            @if(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                            <div>
                              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a type="button" data-bs-toggle="modal" data-bs-target="#perpanjang{{ $item->kode_reg }}" class="btn btn-warning" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                                  <i class="bi bi-check2-circle"></i>
                                </a>
                              </div>                
                            </div>
                            @endif
                            <div>
                              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a type="button" data-bs-toggle="modal" data-bs-target="#nonaktif{{ $item->kode_reg }}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                                  <i class="bi bi-x-circle-fill"></i>
                                </a>
                              </div>                
                            </div>
                            {{-- button perpanjang --}}
                          </div>
                        </td>
                        {{-- Aksi End --}}
                      </tr>
                      {{-- End Kondisi Sudah Bayar --}}
                    @endif
                  @endif


                @elseif(Request::get('value') == "Aktif")
                  @if($item->start_reg <= $item->end_reg == date('Y-m-d'))
                    @if ($item->status_reg == 'Berlangganan')
                      <tr>
                        <td class="col-auto">
                          <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $no++ }}</p>
                        </td>
                        <td class="col-auto">
                          <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $item->kode_reg }}</p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">{{ $item->nama }}</p>
                        </td>
                        <td class="col-auto">
                          <p class="font-bold mb-0" style="font-size: 12px">{{ $item->nama_paket }}</p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">@currency($item->subtotal) </p>
                        </td>
                        <td class="col-auto">
                          <p class=" mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_reg)) }}</p>
                        </td>


                        
                        {{-- status masa aktif paket --}}                            
                        @if($item->start_reg <= $item->end_reg == date('Y-m-d')) 
                        <td class="col-auto">
                          <span class="text-success mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_reg)) }}</span>
                        </td>          
                        @endif                                
                        {{-- status masa aktif paket --}}


                        {{-- Aksi start --}}
                        <td class="col-auto">
                          <div class="d-flex text-sm justify-content-around">
                            {{-- button invoice --}}
                            <div>
                              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a type="button" data-bs-toggle="modal" data-bs-target="#invoice{{ $item->kode_reg }}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                  <i class="bi bi-receipt-cutoff text-dark"></i>
                                </a>
                              </div>                
                            </div>
                            {{-- button invoice --}}

                            
                            {{-- button perpanjang --}}
                            @if($item->start_reg <= $item->end_reg == date('Y-m-d'))
                            <div>
                              <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a class="btn btn-secondary" style="font-size: 10px; cursor: not-allowed;" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                                  <i class="bi bi-check2-circle"></i>
                                </a>
                              </div>                
                            </div>
                            @endif
                            {{-- button perpanjang --}}
                          </div>
                        </td>
                        {{-- Aksi End --}}
                      </tr>
                      {{-- End Kondisi Sudah Bayar --}}
                    @endif
                  @endif



                @elseif(Request::get('value') == "Belum Bayar")
                  @if ($item->status_reg == 'BelumBayar')
                    {{-- Start Kondisi Belum Bayar --}}
                    <tr>
                      <td class="col-auto">
                        <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $no++ }}</p>
                      </td>
                      <td class="col-auto">
                        <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $item->kode_reg }}</p>
                      </td>
                      <td class="col-auto">
                        <p class=" mb-0" style="font-size: 12px">{{ $item->nama }}</p>
                      </td>
                      <td class="col-auto">
                        <p class="font-bold mb-0" style="font-size: 12px">{{ $item->nama_paket }}</p>
                      </td>
                      <td class="col-auto">
                        <p class=" mb-0" style="font-size: 12px">@currency($item->subtotal) </p>
                      </td>
                      <td class="col-auto">
                        @if ($item->start_reg == '')
                        <p class=" mb-0" style="font-size: 12px">Bayar</p>
                        @else    
                        <p class=" mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_reg)) }}</p>
                        @endif
                      </td>



                      {{-- status masa aktif paket --}}                            
                      <td class="col-auto">
                        @if ($item->start_reg == '')
                        <p class=" mb-0" style="font-size: 12px">Bayar</p>
                        @else    
                        <span class="text-dark mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_reg)) }}</span>
                        @endif
                      </td>                             
                      {{-- status masa aktif paket --}}



                      {{-- Aksi start --}}
                      <td class="col-auto">
                        <div class="d-flex text-sm justify-content-around">
                          {{-- button invoice --}}
                          <div>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                              <a type="button" data-bs-toggle="modal" data-bs-target="#invoice{{ $item->kode_reg }}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                <i class="bi bi-receipt-cutoff text-dark"></i>
                              </a>
                            </div>                
                          </div>
                          {{-- button invoice --}}



                          {{-- button perpanjang --}}
                          <div>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                              <a type="button" data-bs-toggle="modal" data-bs-target="#bayar{{ $item->kode_reg }}" class="btn btn-dark" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                                <i class="bi bi-check2-circle"></i>
                              </a>
                            </div>                
                          </div>
                          {{-- button perpanjang --}}
                        </div>
                      </td>
                      {{-- Aksi End --}}
                    </tr>
                    {{-- End Kondisi Belum Bayar --}}
                  @endif

                @elseif(Request::get('value') == "")
                  @if ($item->status_reg == 'Berlangganan')
                  <tr>
                    <td class="col-auto">
                      <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $no++ }}</p>
                    </td>
                    <td class="col-auto">
                      <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $item->kode_reg }}</p>
                    </td>
                    <td class="col-auto">
                      <p class=" mb-0" style="font-size: 12px">{{ $item->nama }}</p>
                    </td>
                    <td class="col-auto">
                      <p class="font-bold mb-0" style="font-size: 12px">{{ $item->nama_paket }}</p>
                    </td>
                    <td class="col-auto">
                      <p class=" mb-0" style="font-size: 12px">@currency($item->subtotal) </p>
                    </td>
                    <td class="col-auto">
                      <p class=" mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_reg)) }}</p>
                    </td>


                    
                    {{-- status masa aktif paket --}}   
                    @if(date('Y-m-d', strtotime("+1 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                    <td class="col-auto">
                      <span class="text-danger mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_reg)) }}</span>
                    </td>          

                    @elseif(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d')) 
                    <td class="col-auto">
                      <span class="text-warning mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_reg)) }}</span>
                    </td>                                   
                    
                    @elseif($item->start_reg <= $item->end_reg  == date('Y-m-d'))
                    <td class="col-auto">
                      <span class="text-success mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_reg)) }}</span>
                    </td> 
                    @endif                                
                    {{-- status masa aktif paket --}}

                    {{-- <td><span>{{ date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) }}</span></td> --}}




                    {{-- Aksi start --}}
                    <td class="col-auto">
                      <div class="d-flex text-sm justify-content-around">
                        {{-- button invoice --}}
                        <div>
                          <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#invoice{{ $item->kode_reg }}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                              <i class="bi bi-receipt-cutoff text-dark"></i>
                            </a>
                          </div>                
                        </div>
                        {{-- button invoice --}}

                        

                        {{-- button perpanjang --}}
                        @if(date('Y-m-d', strtotime("+1 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                        <div>
                          <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#expired{{ $item->kode_reg }}" class="btn btn-danger" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                              <i class="bi bi-check2-circle"></i>
                            </a>
                          </div>                
                        </div>

                        @elseif(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                        <div>
                          <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#perpanjang{{ $item->kode_reg }}" class="btn btn-warning" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                              <i class="bi bi-check2-circle"></i>
                            </a>
                          </div>                
                        </div>
                        
                        @elseif($item->start_reg <= $item->end_reg == date('Y-m-d'))
                        <div>
                          <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a class="btn btn-secondary" style="font-size: 10px; cursor: not-allowed;" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                              <i class="bi bi-check2-circle"></i>
                            </a>
                          </div>                
                        </div>
                        @endif

                        <div>
                          <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <a type="button" data-bs-toggle="modal" data-bs-target="#nonaktif{{ $item->kode_reg }}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                              <i class="bi bi-x-circle-fill"></i>
                            </a>
                          </div>                
                        </div>
                        {{-- button perpanjang --}}
                      </div>
                    </td>
                    {{-- Aksi End --}}
                  </tr>
                  {{-- End Kondisi Sudah Bayar --}}


                  @elseif($item->status_reg == 'BelumBayar')
                    {{-- Start Kondisi Belum Bayar --}}
                    <tr>
                      <td class="col-auto">
                        <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $no++ }}</p>
                      </td>
                      <td class="col-auto">
                        <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $item->kode_reg }}</p>
                      </td>
                      <td class="col-auto">
                        <p class=" mb-0" style="font-size: 12px">{{ $item->nama }}</p>
                      </td>
                      <td class="col-auto">
                        <p class="font-bold mb-0" style="font-size: 12px">{{ $item->nama_paket }}</p>
                      </td>
                      <td class="col-auto">
                        <p class=" mb-0" style="font-size: 12px">@currency($item->subtotal) </p>
                      </td>
                      <td class="col-auto">
                        @if ($item->start_reg == '')
                        <p class=" mb-0" style="font-size: 12px">Bayar</p>
                        @else    
                        <p class=" mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_reg)) }}</p>
                        @endif
                      </td>



                      {{-- status masa aktif paket --}}                            
                      <td class="col-auto">
                        @if ($item->start_reg == '')
                        <p class=" mb-0" style="font-size: 12px">Bayar</p>
                        @else    
                        <span class="text-dark mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_reg)) }}</span>
                        @endif
                      </td>                             
                      {{-- status masa aktif paket --}}



                      {{-- Aksi start --}}
                      <td class="col-auto">
                        <div class="d-flex text-sm justify-content-around">
                          {{-- button invoice --}}
                          <div>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                              <a type="button" data-bs-toggle="modal" data-bs-target="#invoice{{ $item->kode_reg }}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                <i class="bi bi-receipt-cutoff text-dark"></i>
                              </a>
                            </div>                
                          </div>
                          {{-- button invoice --}}



                          {{-- button perpanjang --}}
                          <div>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                              <a type="button" data-bs-toggle="modal" data-bs-target="#bayar{{ $item->kode_reg }}" class="btn btn-dark" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                                <i class="bi bi-check2-circle"></i>
                              </a>
                            </div>                
                          </div>

                          <div>
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                              <a type="button" data-bs-toggle="modal" data-bs-target="#nonaktif{{ $item->kode_reg }}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Perpanjang">
                                <i class="bi bi-x-circle-fill"></i>
                              </a>
                            </div>                
                          </div>
                          {{-- button perpanjang --}}
                        </div>
                      </td>
                      {{-- Aksi End --}}
                    </tr>
                    {{-- End Kondisi Belum Bayar --}}
                  @endif
                @endif

                    
                @endforeach  
                </tbody>  
            </table>
          </div>
        </div>
      </div>
    </div>
    {{-- tabel pelanggan end --}}
  </section>
  
</div>







{{-- modal start tambah --}}
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Register Order</h5>
            <a type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>
        <form action="{{ route('addregis') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">  
                <div class="mb-0">
                  <h4>Registrasi</h4>
                  <hr>
                </div>

                <input type="hidden" value="{{ $kode_reg }}" name="kode_reg">
                <input type="hidden" value="{{ $kode_inv }}" name="id_invoice">

                <div class="mb-1 col-lg-12">
                  <label for="kode" class="col-form-label font-label text-secondary text-xs opacity-7">Pelanggan:</label>
                  <select  type="text" id="kode" name="kode_pelanggan" data-width="100%" class="form-control js-example-basic-single">
                    <option selected disabled value="">--Pilih Pelanggan--</option>
                    @foreach ($pelanggan as $item)    
                      <option value="{{ $item->kode_pelanggan }}">{{ $item->nama }}</option>
                    @endforeach
                  </select>  
                </div>

		
		<div class="row">
                  <div class="mb-1 col-md-6">
                    <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
                    <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_reg" name="start_reg" value="<?php echo date('Y-m-d'); ?>">
                  </div>
      
                  <div class="mb-1 col-md-6">
                    <label for="end_reg" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
                    <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" id="end_bayar" name="end_reg" readonly>
                  </div>
                </div>

                
                <div class="mb-1 col-lg-12">
                  <label for="paket" class="col-form-label font-label text-secondary text-xs opacity-7">Paket:</label>
                  <select type="text" id="Kode" name="kode_paket" data-width="100%" class="form-control js-example-basic-single">
                    <option selected disabled value="">--Pilih Paket--</option>
                    @foreach ($paket as $item)    
                      <option value="{{ $item->kode }}">{{ $item->nama_paket }}</option>
                    @endforeach
                  </select>
                </div>


                <div class="row">
                  <div class="mb-1 col-md-4">
                    <label for="kategori" class="col-form-label font-label text-secondary text-xs opacity-7">Kategori:</label>
                    <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="kategori" placeholder="Kategori Paket">
                  </div>

                  <div class="mb-1 col-md-5">
                    <label for="harga" class="col-form-label font-label text-secondary text-xs opacity-7">Harga:</label>
                    <input type="number" class="form-control border p-2 text-dark text-xs opacity-7" id="harga_paket" name="harga"  placeholder="Rp.">
                  </div>

                  {{-- <input type="hidden" id="pajak" name="pajak"> --}}

                  <div class="mb-1 col-md-3">
                    <label for="pajak" class="col-form-label font-label text-secondary text-xs opacity-7">Pajak:</label>
                    <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="pajak" id="pajak">
                  </div>      
                </div>

          
                <input type="hidden" name="subtotal" id="totalawal">
                <!-- <input type="text" name="total" id="total"> -->



                <input type="hidden" name="created_at" value="<?php echo date('Y-m-d'); ?>">
                <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d'); ?>">
                <input type="hidden" name="bulan" value="<?php echo date('m'); ?>">

                <div class="row d-none">
                  <div class="mb-1 col-md-6">
                    <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
                    <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_inv" name="start_inv" value="<?php echo date('Y-m-d'); ?>">
                  </div>
      
      
                  <div class="mb-1 col-md-6">
                    <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
                    <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" id="end_invoice" name="end_inv">
                  </div>
                </div>


		              <div class="mb-1 col-md-12">
                    <label for="kategori" class="col-form-label font-label text-secondary text-xs opacity-7">Berlangganan:</label>
                    <select type="text" data-width="100%" class="form-control js-example-basic-single" name="berlangganan" id="berlangganan">
                      <option value="" disabled selected>Pilih Berlangganan</option>
                      @foreach ($berlangganan as $item)
                        <option value="{{ $item->berlangganan }}">{{ $item->berlangganan }} Bulan</option>
                      @endforeach
                    </select>
                  </div>


                <div class="mb-1 col-md-12">
                  <label for="note" class="col-form-label font-label text-secondary text-xs opacity-7">Note:</label>
                  <textarea type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="note" name="note" placeholder="Note" cols="30" rows="5"></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
  </div>
</div>
{{-- modal tambah end --}}







{{-- modal bayar register start --}}
@foreach ($invoice as $item)
@if ($item->status_reg == "BelumBayar")
<div class="modal fade" id="bayar{{ $item->kode_reg }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bayar Berlangganan</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form action="/billing/bayar/{{$item->kode_reg}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          {{-- <p>--- update status start ---</p> --}}
          <div class="d-none">
            <input type="text" name="kode_pelanggan" value="{{ $item->kode_pelanggan }}">
            <input type="text" value="{{ $kode_inv }}" name="id_invoice">
            <input type="text" value="{{ $item->kode_paket }}" name="kode_paket">
            <input type="text" name="status_reg" value="Berlangganan">
            <input type="text" name="status_inv" value="Berlangganan">
          </div>
          {{-- <p>--- update status end ---</p> --}}

          @foreach ($register as $data)  
          @if ($item->kode_reg == $data->kode_reg)
          {{-- start set tanggal --}}

          {{-- start set date register --}}
          @if($data->berlangganan == '1')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+1 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);


            $setend = $setbulaninv;
            $setbulanend = strtotime("+1 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '2')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+2 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+2 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?> 

            @elseif($data->berlangganan == '3')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+3 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+3 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>     
            
            
            @elseif($data->berlangganan == '4')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+4 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);
            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+4 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              


            @elseif($data->berlangganan == '5')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+5 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+5 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '6')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+6 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+6 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '7')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+7 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+7 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '8')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+8 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+8 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>  

            @elseif($data->berlangganan == '9')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+9 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+9 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>   

            @elseif($data->berlangganan == '10')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+10 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+10 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>

            @elseif($data->berlangganan == '11')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+11 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+11 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>  

            @elseif($data->berlangganan == '12')
            <?php
            $tanggal_start = $item->start_reg;
            // 1 bulan
            $setbulan = strtotime("+12 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+12 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              
          @endif
          {{-- end set date register --}}


          
          <div class="row">
            <div class="mb-1 col-md-6">
              <label for="end_reg" class="col-form-label font-label text-secondary text-xs opacity-7">No. Register:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" value="{{ $item->kode_reg }}">
            </div>

            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Nama Pelanggan:</label>
              <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7"  value="{{ $item->nama }}">
            </div>
          </div>

          <div class="row">
            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
              <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_reg" name="start_reg" value="{{ $tanggal_start }}">
            </div>

            <div class="mb-1 col-md-6">
              <label for="end_reg" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
              <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" name="end_reg" value="{{ $berakhir }}">
            </div>
          </div>



          <div class="row d-none">
            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
              <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_inv" name="start_inv" value="{{ $startdate }}">
            </div>


            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
              <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" name="end_inv" value="{{ $startend }}">
            </div>
          </div>
          {{-- end set tanggal --}}




          <div class="row">
            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Harga:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="harga" value="{{ $item->harga }}">
              <p>Harga: @currency( $item->harga)</p>
            </div>

            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Pajak:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="pajak" value="{{ $item->pajak }}">
              <p>Pajak: @currency($item->pajak)</p>
            </div>
          </div>

          <?php
            $hitungtotal = $item->harga + $item->pajak;
            $berlangganan = $item->berlangganan;
          ?>

          <div class="mb-1 col-md-12">
            <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Subtotal:</label>
            <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="subtotal" value="{{ $hitungtotal }}">
            <p>Subtotal: @currency( $hitungtotal )</p>
          </div>

          <div class="mb-1 col-md-12">
            <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Total:</label>
            <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="total" id="total_bayar" value="{{ $hitungtotal * $berlangganan }}">
            <p>Subtotal: @currency($hitungtotal * $berlangganan)</p>
          </div>

          <div class="d-none">
            <input type="text" name="berlangganan" value="{{ $item->berlangganan }}">
            <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="bulan" value="<?php echo date('m'); ?>">
          </div>
          @endif
          @endforeach

          <div class="mb-1 col-md-12">
            <label for="note" class="col-form-label font-label text-secondary text-xs opacity-7">Note:</label>
            <textarea type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="note" name="note" placeholder="Note" cols="30" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark btn-sm">Bayar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endforeach
{{-- modal bayar register end --}}







{{-- modal nonaktif register start --}}
@foreach ($invoice as $item)
<div class="modal fade" id="nonaktif{{ $item->kode_reg }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nonaktif</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/billing/nonaktif/{{$item->kode_reg}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          {{-- <p>--- update status start ---</p> --}}
          <div class="d-none">
            <input type="text" name="id_invoice" value="{{ $item->id_invoice }}">
            <input type="text" name="option" value="nonaktif">
          </div>
          {{-- <p>--- update status end ---</p> --}}

          @foreach ($register as $data)  
          @if ($item->kode_reg == $data->kode_reg)
          <div class="mb-1 col-md-12">
            <label for="kategori" class="col-form-label font-label text-secondary text-xs opacity-7">Nonaktikan:</label>
            <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" name="option" value="nonaktif" readonly>
          </div>
          @endif
          @endforeach
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark btn-sm">Nonaktifkan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
{{-- modal nonaktif register end --}}







{{-- modal Expired register start --}}
@foreach ($invoice as $item)
@if ($item->status_reg == "Berlangganan")
<div class="modal fade" id="expired{{ $item->kode_reg }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bayar Berlangganan</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form action="/billing/perpanjang/{{$item->kode_reg}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          {{-- <p>--- update status start ---</p> --}}
          <div class="d-none">
            <input type="text" name="kode_pelanggan" value="{{ $item->kode_pelanggan }}">
            <input type="text" value="{{ $kode_inv }}" name="id_invoice">
            <input type="text" value="{{ $item->kode_paket }}" name="kode_paket">
            <input type="text" name="status_reg" value="Berlangganan">
            <input type="text" name="status_inv" value="Berlangganan">
          </div>
          {{-- <p>--- update status end ---</p> --}}

          @foreach ($register as $data)  
          @if ($item->kode_reg == $data->kode_reg)
          {{-- start set tanggal --}}

          {{-- start set date register --}}
          @if($data->berlangganan == '1')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+1 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);


            $setend = $setbulaninv;
            $setbulanend = strtotime("+1 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '2')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+2 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+2 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?> 

            @elseif($data->berlangganan == '3')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+3 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+3 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>     
            
            
            @elseif($data->berlangganan == '4')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+4 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);
            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+4 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              


            @elseif($data->berlangganan == '5')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+5 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+5 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '6')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+6 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+6 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '7')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+7 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+7 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '8')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+8 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+8 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>  

            @elseif($data->berlangganan == '9')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+9 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+9 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>   

            @elseif($data->berlangganan == '10')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+10 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+10 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>

            @elseif($data->berlangganan == '11')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+11 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+11 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>  

            @elseif($data->berlangganan == '12')
            <?php
            $tanggal_start = date('Y-m-d');
            // 1 bulan
            $setbulan = strtotime("+12 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+12 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              
          @endif
          {{-- end set date register --}}


          


          <div class="row">
            <div class="mb-1 col-md-6">
              <label for="end_reg" class="col-form-label font-label text-secondary text-xs opacity-7">No. Register:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" value="{{ $item->kode_reg }}">
            </div>

            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Nama Pelanggan:</label>
              <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7"  value="{{ $item->nama }}">
            </div>
          </div>


          <div class="row">
            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
              <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_reg" name="start_reg" value="<?php echo date('Y-m-d'); ?>" >
            </div>

            <div class="mb-1 col-md-6">
              <label for="end_reg" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
              <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" name="end_reg" value="{{ $berakhir }}">
            </div>
          </div>



          <div class="row d-none">
            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
              <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_inv" name="start_inv" value="{{ $startdate }}">
            </div>


            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
              <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" name="end_inv" value="{{ $startend }}">
            </div>
          </div>
          {{-- end set tanggal --}}




          <div class="row">
            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Harga:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="harga" value="{{ $item->harga }}">
              <p>Harga: @currency( $item->harga)</p>
            </div>

            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Pajak:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="pajak" value="{{ $item->pajak }}">
              <p>Pajak: @currency($item->pajak)</p>
            </div>
          </div>

          <?php
            $hitungtotal = $item->harga + $item->pajak;
            $berlangganan = $item->berlangganan;
          ?>

          <div class="mb-1 col-md-12">
            <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Subtotal:</label>
            <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="subtotal" value="{{ $hitungtotal }}">
            <p>Subtotal: @currency( $hitungtotal )</p>
          </div>

          <div class="mb-1 col-md-12">
            <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Total:</label>
            <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="total" id="total_bayar" value="{{ $hitungtotal * $berlangganan }}">
            <p>Subtotal: @currency($hitungtotal * $berlangganan)</p>
          </div>

          <div class="d-none">
            <input type="text" name="berlangganan" value="{{ $item->berlangganan }}">
            <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="created_at" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="bulan" value="<?php echo date('m'); ?>">
          </div>
          @endif
          @endforeach

          <div class="mb-1 col-md-12">
            <label for="note" class="col-form-label font-label text-secondary text-xs opacity-7">Note:</label>
            <textarea type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="note" name="note" placeholder="Note" cols="30" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark btn-sm">Perpanjang</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endforeach
{{-- modal Expired register end --}}







{{-- modal perpanjang register start --}}
@foreach ($invoice as $item)
@if ($item->status_reg == "Berlangganan")
<div class="modal fade" id="perpanjang{{ $item->kode_reg }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Perpanjang Berlangganan</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form action="/billing/perpanjang/{{$item->kode_reg}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          {{-- <p>--- update status start ---</p> --}}
          <div class="d-none">
            <input type="text" name="kode_pelanggan" value="{{ $item->kode_pelanggan }}">
            <input type="text" value="{{ $kode_inv }}" name="id_invoice">
            <input type="text" value="{{ $item->kode_paket }}" name="kode_paket">
            <input type="text" name="status_reg" value="Berlangganan">
            <input type="text" name="status_inv" value="Berlangganan">
          </div>
          {{-- <p>--- update status end ---</p> --}}

          @foreach ($register as $data)  
          @if ($item->kode_reg == $data->kode_reg)
          {{-- start set tanggal --}}

          {{-- start set date register --}}
          @if($data->berlangganan == '1')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+1 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);


            $setend = $setbulaninv;
            $setbulanend = strtotime("+1 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '2')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+2 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+2 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?> 

            @elseif($data->berlangganan == '3')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+3 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+3 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>     
            
            
            @elseif($data->berlangganan == '4')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+4 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);
            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+4 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              


            @elseif($data->berlangganan == '5')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+5 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+5 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '6')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+6 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+6 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '7')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+7 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+7 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              

            @elseif($data->berlangganan == '8')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+8 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+8 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>  

            @elseif($data->berlangganan == '9')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+9 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+9 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>   

            @elseif($data->berlangganan == '10')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+10 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+10 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>

            @elseif($data->berlangganan == '11')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+11 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+11 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>  

            @elseif($data->berlangganan == '12')
            <?php
            $tanggal_start = $item->end_reg;
            // 1 bulan
            $setbulan = strtotime("+12 month", strtotime($tanggal_start));
            $berakhir = date('Y-m-d', $setbulan);

            // {{-- start set date invoice --}}
            $setbulaninv = $berakhir;
            // $set = strtotime("+1 day", strtotime($setbulaninv));
            $set = strtotime($setbulaninv);
            $startdate = date('Y-m-d', $set);

            $setend = $setbulaninv;
            $setbulanend = strtotime("+12 month", strtotime($setend));
            $startend = date('Y-m-d', $setbulanend);
            // {{-- end set date invoice--}}
            ?>              
          @endif
          {{-- end set date register --}}


          <div class="row">
            <div class="mb-1 col-md-6">
              <label for="end_reg" class="col-form-label font-label text-secondary text-xs opacity-7">No. Register:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" value="{{ $item->kode_reg }}">
            </div>

            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Nama Pelanggan:</label>
              <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7"  value="{{ $item->nama }}">
            </div>
          </div>

	        <div class="row">
            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
              <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_reg" name="start_reg" value="{{ $item->end_reg }}" readonly>
            </div>

            <div class="mb-1 col-md-6">
              <label for="end_reg" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
              <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" name="end_reg" value="{{ $berakhir }}" readonly>
            </div>
          </div>

          {{-- <div class="row">
            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
              <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_reg" name="start_reg" value="{{ $item->end_reg }}" >
            </div>

            <div class="mb-1 col-md-6">
              <label for="end_reg" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
              <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" name="end_reg" value="{{ $berakhir }}" >
            </div>
          </div> --}}



          <div class="row d-none">
            <div class="mb-1 col-md-6">
              <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
              <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="start_inv" name="start_inv" value="{{ $startdate }}">
            </div>


            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
              <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" name="end_inv" value="{{ $startend }}">
            </div>
          </div>
          {{-- end set tanggal --}}




          <div class="row">
            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Harga:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="harga" value="{{ $item->harga }}">
              <p>Harga: @currency( $item->harga)</p>
            </div>

            <div class="mb-1 col-md-6">
              <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Pajak:</label>
              <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="pajak" value="{{ $item->pajak }}">
              <p>Pajak: @currency($item->pajak)</p>
            </div>
          </div>

          <?php
            $hitungtotal = $item->harga + $item->pajak;
            $berlangganan = $item->berlangganan;
          ?>

          <div class="mb-1 col-md-12">
            <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Subtotal:</label>
            <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="subtotal" value="{{ $hitungtotal }}">
            <p>Subtotal: @currency( $hitungtotal )</p>
          </div>

          <div class="mb-1 col-md-12">
            <label for="end_inv" class="col-form-label font-label text-secondary text-xs opacity-7">Total:</label>
            <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="total" id="total_bayar" value="{{ $hitungtotal * $berlangganan }}">
            <p>Subtotal: @currency($hitungtotal * $berlangganan)</p>
          </div>

          <div class="d-none">
            <input type="text" name="berlangganan" value="{{ $item->berlangganan }}">
            <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="bulan" value="<?php echo date('m'); ?>">
          </div>
          @endif
          @endforeach

          <div class="mb-1 col-md-12">
            <label for="note" class="col-form-label font-label text-secondary text-xs opacity-7">Note:</label>
            <textarea type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="note" name="note" placeholder="Note" cols="30" rows="5"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark btn-sm">Perpanjang</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endforeach
{{-- modal perpanjang register end --}}






{{--//////////////////////////DETAIL START/////////////////////////////// --}}
{{-- modal start invoice --}}
@foreach ($register as $item)
  <div class="modal fade" id="invoice{{ $item->kode_reg }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Invoice</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            {{-- @if($item->status_reg == "BelumBayar")
            <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-hutang{{ $item->kode_pelanggan }}" class="btn btn-danger mb-3">Invoice Tagihan Bulan Ini</a> 

            @elseif(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d'))  --}}
            <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-hutang{{ $item->kode_reg }}" class="btn btn-danger mb-3" target="_blank">Invoice Tagihan Bulan Ini</a>

            {{-- @elseif($item->status_reg == "Berlangganan") --}}
            <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-terbayar{{ $item->kode_reg }}" class="btn btn-primary" target="_blank">Invoice Tagihan Bulan Lalu</a>
            {{-- @endif --}}
          </div>
        </div>
      </div>
    </div>
  </div>
@endforeach
{{-- modal end invoice --}}



@foreach ($register as $item)
  <div class="modal fade" id="invoice-terbayar{{ $item->kode_reg }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Invoice Detail</h5>
          <button type="button" class="btn-close" aria-label="Close" data-bs-toggle="modal" data-bs-target="#invoice{{ $item->kode_reg }}"></button>
        </div>
        <div class="modal-body">
          <h4 class="mb-4">Terbayar</h4>
  
          {{-- <p style="line-height: 2px;">Terbayar</p> --}}
          {{-- <div class="form-group">
            <input type="text" name="search" id="search" class="form-control" placeholder="Invoice Terbayar" />
          </div> --}}
          <div>
            <ul class="list-group list-group-flush">
              @foreach ($invoice as $data)
              @if ($item->kode_reg == $data->kode_reg) 
                @if ($data->status_inv == 'Berlangganan')
                <li class="list-group-item text-dark" style="border-bottom: 1px solid rgb(191, 191, 191);">
                  <div class="justify-content-between d-flex">
                    <div><span class="text-uppercase">{{ $data->id_invoice }}</span></div>
                    
                    <div class="d-flex text-sm">
                      {{-- button invoice --}}
                      <div class="d-flex">
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                          <a href="/invoicewng/{{ $data->id_invoice}}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                            <i class="bi bi-receipt-cutoff text-dark"></i> WNG
                          </a>
                        </div> 
                        
                        <div class="btn-group btn-group-sm mx-2" role="group" aria-label="...">
                          <a href="/invoicewng/print/{{$data->id_invoice}}" class="btn btn-secondary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                            <i class="bi bi-printer-fill"></i>
                          </a>
                        </div>                
                      </div>

                      <div> <span class="text-secondary" style="border-right: 1px solid;"></span> </div>

                      <div class="d-flex">
                        <div class="btn-group btn-group-sm mx-2" role="group" aria-label="...">
                          <a href="/invoicesry/{{ $data->id_invoice}}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                            <i class="bi bi-receipt-cutoff"></i> Surya Candra
                          </a>
                        </div>    
                        
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                          <a href="/print/{{ $data->id_invoice}}" class="btn btn-secondary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                            <i class="bi bi-printer-fill"></i>
                          </a>
                        </div>
                      </div>
                      {{-- button invoice --}}
                    </div>
                  </div>
                </li>
                @endif    
              @endif
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  





  <div class="modal fade" id="invoice-hutang{{ $item->kode_reg }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Invoice Detail</h5>
          <button type="button" class="btn-close" aria-label="Close" data-bs-toggle="modal" data-bs-target="#invoice{{ $item->kode_reg }}"></button>
        </div>
        <div class="modal-body">
          <h4 class="mb-4">Belum Terbayar</h4>
  
          {{-- <p style="line-height: 2px;">Terbayar</p> --}}
          {{-- <div class="form-group">
            <input type="text" name="search" id="search" class="form-control" placeholder="Invoice Terbayar" />
          </div> --}}
          <div>
            <ul class="list-group list-group-flush">
              @foreach ($invoice as $data)
              @if ($item->kode_reg == $data->kode_reg) 
                @if ($data->status_inv == 'BelumBayar')
                <li class="list-group-item text-dark" style="border-bottom: 1px solid rgb(191, 191, 191);">
                  <div class="justify-content-between d-flex">
                    <div><span class="text-uppercase">{{ $data->id_invoice }}</span></div>
                    
                    <div class="d-flex text-sm">
                      {{-- button invoice --}}
                      <div class="d-flex">
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                          <a href="/invoicewng/{{ $data->id_invoice}}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                            <i class="bi bi-receipt-cutoff text-dark"></i> WNG
                          </a>
                        </div> 
                        
                        <div class="btn-group btn-group-sm mx-2" role="group" aria-label="...">
                          <a href="/invoicewng/print/{{$data->id_invoice}}" class="btn btn-secondary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                            <i class="bi bi-printer-fill"></i>
                          </a>
                        </div>                
                      </div>

                      <div> <span class="text-secondary" style="border-right: 1px solid;"></span> </div>

                      <div class="d-flex">
                        <div class="btn-group btn-group-sm mx-2" role="group" aria-label="...">
                          <a href="/invoicesry/{{ $data->id_invoice}}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                            <i class="bi bi-receipt-cutoff"></i> Surya Candra
                          </a>
                        </div>    
                        
                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                          <a href="/print/{{ $data->id_invoice}}" class="btn btn-secondary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                            <i class="bi bi-printer-fill"></i>
                          </a>
                        </div>
                      </div>
                      {{-- button invoice --}}
                    </div>
                  </div>
                </li>
                @endif    
              @endif
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
@endforeach
{{-- modal end invoice --}}
{{--//////////////////////////DETAIL END///////////////////////////////// --}}






{{--/////////////////////////////////////////////////////////////////////JAVASCRIPT START///////////////////////////////////////////////////////////// --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- for export all -->


<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>

<script type="text/javascript">
  /////register js start
  $(document).ready(function() {
      $('#Kode').on('change', function() {
          var KodePaket = $(this).val();

          
          if(KodePaket) {
              $.ajax({
                  url: '/getPaket/'+KodePaket,
                  type: "GET",
                  data : {"_token":"{{ csrf_token() }}"},
                  dataType: "json",
                  success:function(data)
                  {
                    if(data){
                      $('#kategori').empty();
                      $.each(data, function(key, paket){
                        $('#kategori').val(paket.kategori);
                      });
                      }else{
                        $('#kategori').empty();
                      }
                  }
              });
          }else{
              $('#kategori').empty();
          }



          if(KodePaket) {
              $.ajax({
                  url: '/getPaket/'+KodePaket,
                  type: "GET",
                  data : {"_token":"{{ csrf_token() }}"},
                  dataType: "json",
                  success:function(data)
                  {
                    if(data){
                      $('#harga_paket').empty();
                      $.each(data, function(key, paket){
                        $('#harga_paket').val(paket.harga_paket);
                      });
                      }else{
                        $('#harga_paket').empty();
                      }
                  }
              });
          }else{
              $('#harga_paket').empty();
          }


          if(KodePaket) {
              $.ajax({
                  url: '/getPaket/'+KodePaket,
                  type: "GET",
                  data : {"_token":"{{ csrf_token() }}"},
                  dataType: "json",
                  success:function(data)
                  {
                    if(data){
                      $('#pajak').empty();
                      $.each(data, function(key, paket){
                        $('#pajak').val(paket.nilai_pajak);
                      });
                      }else{
                        $('#pajak').empty();
                      }
                  }
              });
          }else{
              $('#pajak').empty();
          }

          if(KodePaket) {
              $.ajax({
                  url: '/getPaket/'+KodePaket,
                  type: "GET",
                  data : {"_token":"{{ csrf_token() }}"},
                  dataType: "json",
                  success:function(data)
                  {
                    if(data){
                      $('#totalawal').empty();
                      $.each(data, function(key, paket){
                        var next = Number(paket.harga_paket) + Number(paket.nilai_pajak);

                        $('#totalawal').val(next);
                      });
                      }else{
                        $('#totalawal').empty();
                      }
                  }
              });
          }else{
              $('#totalawal').empty();
          }

      });
  });
  /////register js end
</script>


<script>
  /////bayar js start
  $(document).ready(function() {
      $('#berlangganan').on('change', function() {
          var bulan = $(this).val();


          if(bulan) {
            console.log('hallo')
            $.ajax({
                url: '/getBulan/'+bulan,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                  if(data){
                    $('#end_bayar').empty();

                    $.each(data, function(key, bulan){ 
                      let tambahbulan = bulan.berlangganan;
                      
                      
                      //tanggal
                      let start_reg = $('#start_reg').val();
                      // let totalawal = $('#totalawal').val();

                      // const next = new Date(date.getFullYear(), date.getMonth() + Number(tambahbulan), date.getDate());

                      let next = moment(start_reg).add(tambahbulan, 'M');   
                      // let total = Number(totalawal) * Number(tambahbulan); 

                      //output
                      let output = next;

                      //register
                      $('#end_bayar').val(moment(next).format('YYYY-MM-DD'));
                      // $('#total').val($total);

                      //invoice
                      $('#end_invoice').val(moment(next).format('YYYY-MM-DD'));
                      $('#start_inv').val(moment(start_reg).format('YYYY-MM-DD'));


                    });
                    }else{
                      $('#start_reg').empty();
                      $('#end_bayar').empty();
                      $('#end_invoice').empty();
                      $('#total').empty();
                    }
                }
            });
          }else{
            $('#start_reg').empty();
            $('#end_bayar').empty();
            $('#end_invoice').empty();
            $('#out').empty();
          }
      });
  });
  /////bayar js end  
</script>

<script>
  function myFunction() {
    let checkBox = document.getElementById("berlangganan");
    let text = document.getElementById("number");

    if (checkBox.checked == true){
      let d1;
      let d2;
      let d3;
      d1 = parseFloat($('#number').val());
      d3 = d1 * 0.11;
      // d3 = d1 * 0.11 + d1 ;
      // text.value = d3;
        
      let output = d3;
      $('#pajak').val(output);

    } else {
      $('#pajak').val('');
    }
  }
</script>



<script>
  /////bayar js start
  $(document).ready(function() {
      $('#kode_reg').on('change', function() {
          var bayar = $(this).val();

          if(bayar) {
            $.ajax({
                url: '/getBayar/'+bayar,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                  if(data){
                    $('#end_reg').empty();

                    $.each(data, function(key, bayar){ 
                      var tambahbulan = bayar.berlangganan;

                      var tambah = bayar.berlangganan;
                      var harga = bayar.harga;
                      var pajak = bayar.pajak;

                      //bayar
                      var bayar = Number(harga) * Number(tambah);
                      var pajak_bayar = Number(pajak) * Number(tambahbulan);
                      var total = Number(bayar) + Number(pajak_bayar);

                      var bulan = moment(tambahbulan).format('MM')

                      //tanggal
                      var date = new Date();
                      const next = new Date(date.getFullYear(), date.getMonth() + Number(bulan), date.getDate());

                      //output
                      let output = next;
                      
                      //register
                      $('#end_bayar').val(moment(next).format('YYYY-MM-DD'));

                      //invoice
                      $('#end_invoice').val(moment(next).format('YYYY-MM-DD'));

                      //bayar
                      $('#subtotal_bayar').val(bayar);
                      $('#pajak_bayar').val(pajak_bayar);
                      $('#total_bayar').val(total);

                    });
                    }else{
                      $('#end_bayar').empty();
                      $('#extend_bayar').empty();
                      $('#end_invoice').empty();
                      $('#extend_invoice').empty();
                    }
                }
            });
          }else{
            $('#end_bayar').empty();
            $('#extend_bayar').empty();
            $('#end_invoice').empty();
            $('#extend_invoice').empty();
          }

      });
  });
  /////bayar js end  
</script>

<script>
    /////bayar js start
  $(document).ready(function() {
      $('#reg_perpanjang').on('change', function() {
          var perpanjang = $(this).val();

          if(perpanjang) {
            $.ajax({
                url: '/getBayar/'+perpanjang,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                  if(data){
                    $('#expired').empty();

                    $.each(data, function(key, bayar){ 
                      var tambahbulan = bayar.berlangganan;
                      var end = bayar.end_reg

                      var tambah = bayar.berlangganan;
                      var harga = bayar.harga;
                      var pajak = bayar.pajak;

                      //bayar
                      var bayar = Number(harga) * Number(tambah);
                      var pajak_bayar = Number(pajak) * Number(tambahbulan);
                      var total = Number(bayar) + Number(pajak_bayar);

                      var bulan = moment(tambahbulan).format('MM');
                      var tgl = moment().format('YYY-MM-DD');

                      //tanggal
                      // var date = new Date();
                      const next = tgl + bulan;

                      //output
                      let output = next;
                      
                      //register
                      $('#expired').val(moment(next).format('YYYY-MM-DD'));

                      //invoice
                      $('#expired1').val(moment(next).format('YYYY-MM-DD'));

                      //bayar
                      $('#sub_perpanjang').val(bayar);
                      $('#pjk_perpanjang').val(pajak_bayar);
                      $('#total_perpanjang').val(total);

                    });
                    }else{
                      $('#expired').empty();
                      $('#expired1').empty();
                    }
                }
            });
          }else{
            $('#expired').empty();
            $('#expired1').empty();
          }

      });
  });
  /////bayar js end  
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function(){
      $('#example').DataTable({
        info: false,
        retrieve: true,
      });
  });
</script>

{{--/////////////////////////////////////////////////////////////////////JAVASCRIPT END///////////////////////////////////////////////////////////// --}}
@endsection




