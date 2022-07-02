@extends('layouts.app')
@extends('layouts.sidebar')
@section('content')
<header class="mb-3">
  <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
  </a>
</header>

<div class="page-heading mb-0 pb-0 row justify-content-between">
  <div class="col-12 col-lg-9 col-md-12 pb-3">
    <h3>Halaman Data Invoice Pelanggan</h3>
    <p>Berisi Data Invoice Pelanggan {{ auth()->user()->level }}</p>
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
                            <div class="stats-icon blue">
                              <i class="iconly-boldBookmark"></i>
                            </div>
                          </div>
                          <div class="col-md-8">
                              <h6 class="text-muted font-semibold">Data Invoice</h6>
                              <h6 class="font-extrabold mb-0">{{ $invoice->count() }}</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- <style>
            svg path {fill: #ffffff}
          </style> -->

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
                            <h6 class="text-muted font-semibold">Terbayar</h6>
                            <h6 class="font-extrabold mb-0">@currency($bayar->sum('subtotal'))</h6>
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
                            <h6 class="font-extrabold mb-0">@currency($belumbayar->sum('subtotal'))</h6>
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
                            <h6 class="text-muted font-semibold">Total Uang</h6>
                            <h6 class="font-extrabold mb-0">@currency($invoice->sum('subtotal'))</h6>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>      
    </div>
    {{-- row data halaman pelanggan end --}}
    

    {{-- search modal start --}}
    <div class="modal fade" id="search" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Search</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="col-12 col-xl-12">
              <div class="card-body card-7">
                <form class="row from" action="{{ route('searchinvoice') }}" method="get" >        
                  <div class="input-group input--medium">
                    <label class="label">ID Invoice</label>
                    <input class="input--style-1" type="text" name="id_invoice" placeholder="ID Invoice" id="input-start" value="{{Request::get('id_invoice')}}">
                  </div>   
                
                  <div class="input-group input--large">
                    <label class="label">Pelanggan</label>
                    <input class="input--style-1" type="text" placeholder="Nama Pelanggan" name="nama" value="{{Request::get('nama')}}">
                  </div>           
        
                  <div class="input-group input--medium">
                    <label class="label">Tanggal</label>
                    <input class="input--style-1" type="date" placeholder="yyyy/mm/dd" id="input-start" name="start_inv" value="{{Request::get('start_inv')}}">
                  </div>
        
                  <div class="input-group input--medium">
                      <label class="label">Tanggal</label>
                      <input class="input--style-1" type="date" placeholder="yyyy/mm/dd" id="input-end" name="end_tanggal" value="{{Request::get('end_tanggal')}}">
                  </div>      
        
                  <div class="input-group input--medium">
                    <label class="label">Status</label>
                    <select name="status_inv" id="input-start" class="input--style-1" type="text" value="{{Request::get('status_inv')}}" style="border: none;">
                      @if(Request::get('status_inv'))
                      <option value="Request::get('status_inv')" selected disabled>{{ Request::get('status_inv')}}</option>
                      @else
                      <option value="" selected disabled>Pilih Status</option>
                      @endif
                      <option value="">Semua</option>
                      <option value="Berlangganan">Terbayar</option>
                      <option value="BelumBayar">Belum Bayar</option>
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


    {{-- print modal start --}}
    <div class="modal fade" id="print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Search</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="col-12 col-xl-12">
              <div class="card-body card-7">
                <form class="row from" action="{{ route('printinvoice') }}" method="get" >        
                  <div class="input-group input--medium">
                    <label class="label">ID Invoice</label>
                    <input class="input--style-1" type="text" name="id_invoice" placeholder="ID Invoice" id="input-start" value="{{Request::get('id_invoice')}}">
                  </div>   
                
                  <div class="input-group input--large">
                    <label class="label">Pelanggan</label>
                    <input class="input--style-1" type="text" placeholder="Nama Pelanggan" name="nama" value="{{Request::get('nama')}}">
                  </div>           
        
                  <div class="input-group input--medium">
                    <label class="label">Tanggal</label>
                    <input class="input--style-1" type="date" placeholder="yyyy/mm/dd" id="input-start" name="start_inv" value="{{Request::get('start_inv')}}">
                  </div>
        
                  <div class="input-group input--medium">
                      <label class="label">Tanggal</label>
                      <input class="input--style-1" type="date" placeholder="yyyy/mm/dd" id="input-end" name="end_tanggal" value="{{Request::get('end_tanggal')}}">
                  </div>      
        
                  <div class="input-group input--medium">
                    <label class="label">Status</label>
                    <select name="status_inv" id="input-start" class="input--style-1" type="text" value="{{Request::get('status_inv')}}" style="border: none;">
                      @if(Request::get('status_inv'))
                      <option value="Request::get('status_inv')" selected disabled>{{ Request::get('status_inv')}}</option>
                      @else
                      <option value="" selected disabled>Pilih Status</option>
                      @endif
                      <option value="">Semua</option>
                      <option value="Berlangganan">Terbayar</option>
                      <option value="BelumBayar">Belum Bayar</option>
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
    {{-- print modal end --}}

    

    {{-- tabel pelanggan start --}}
    <div class="col-12 col-xl-12">
      
      <div class="card">
          <div class="card-header row justify-content-between">
            <div class="d-flex col-md-9">
              <h4>Invoice</h4>
            </div>

            <div class="d-flex col-3 justify-content-end">
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
            </div>  
       

          <div class="card-body">
              <div class="table-responsive">
                  <table id="example" class="table table-striped">
                      <thead>
                          <tr style="font-size: 13px">
                              <th>NO</th>
                              <th>ID Invoice</th>
                              <th>Nama Pelanggan</th>
                              <th>Telpn</th>
                              <th>Start</th>
                              <th>End</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php $no = 1; @endphp
                          @foreach ($invoice as $item)
                          <tr>
                            <td class="col-auto">
                              <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $no++ }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="mb-0 text-uppercase" style="font-size: 12px">{{ $item->id_invoice }}</p>
                            </td>

                            


                            @if ($item->status_inv == 'BelumBayar')
                            <td class="col-auto">
                              <p class=" mb-0 text-dark" style="font-size: 12px">{{$item->nama}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0" style="font-size: 12px">{{$item->no_telpn}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-dark" style="font-size: 12px">Bayar</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-dark" style="font-size: 12px">Bayar</p>
                            </td>

                            
                            @elseif($item->status_inv == 'Berlangganan')

                            {{-- status masa aktif paket --}}
                            @if($item->end_inv <= date("Y-m-d"))
                            <td class="col-auto">
                              <p class=" mb-0 text-danger" style="font-size: 12px">{{$item->nama}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0" style="font-size: 12px">{{$item->no_telpn}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-danger" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_inv)) }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-danger" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_inv)) }}</p>
                            </td> 
                            
                            @elseif(date('Y-m-d', strtotime("-14 day", strtotime($item->end_inv))) <= date('Y-m-d'))
                            <td class="col-auto">
                              <p class=" mb-0 text-warning" style="font-size: 12px">{{$item->nama}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0" style="font-size: 12px">{{$item->no_telpn}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-warning" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_inv)) }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-warning" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_inv)) }}</p>
                            </td>
                              
                            @elseif($item->start_inv <= $item->end_inv  == date('Y-m-d'))
                            <td class="col-auto">
                              <p class=" mb-0 text-success" style="font-size: 12px">{{$item->nama}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0" style="font-size: 12px">{{$item->no_telpn}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-success" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->start_inv)) }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-success" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->end_inv)) }}</p>
                            </td>
                            
                            @endif  
                            @endif

                            @if ($item->status_inv == 'BelumBayar')
                            <td class="col-auto">
                              <div class="d-flex text-sm">
                                {{-- button invoice --}}
                                <div>
                                  <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-hutang{{ $item->id_invoice }}" class="btn btn-danger" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                      <i class="bi bi-receipt-cutoff text-white"></i>
                                    </a>
                                  </div>                
                                </div>

                                <div>
                                  <div class="btn-group btn-group-sm mx-1" role="group" aria-label="...">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-print-hutang{{ $item->id_invoice }}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                      <i class="bi bi-printer-fill"></i>
                                    </a>
                                  </div>                
                                </div>
                                {{-- button invoice --}}
                              </div>
                            </td>

                            
                            @elseif($item->status_inv == 'Berlangganan')
                            @if($item->end_inv <= date("Y-m-d"))
                            <td class="col-auto">
                              <div class="d-flex text-sm">
                                {{-- button invoice --}}
                                <div>
                                  <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-hutang{{ $item->id_invoice }}" class="btn btn-danger" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                      <i class="bi bi-receipt-cutoff text-white"></i>
                                    </a>
                                  </div>                
                                </div>

                                <div>
                                  <div class="btn-group btn-group-sm mx-1" role="group" aria-label="...">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-print-hutang{{ $item->id_invoice }}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                      <i class="bi bi-printer-fill"></i>
                                    </a>
                                  </div>                
                                </div>
                                {{-- button invoice --}}
                              </div>
                            </td>

                            @elseif(date('Y-m-d', strtotime("-14 day", strtotime($item->end_inv))) <= date('Y-m-d'))
                            <td class="col-auto">
                              <div class="d-flex text-sm">
                                {{-- button invoice --}}
                                <div>
                                  <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-hutang{{ $item->id_invoice }}" class="btn btn-danger" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                      <i class="bi bi-receipt-cutoff text-white"></i>
                                    </a>
                                  </div>                
                                </div>

                                <div>
                                  <div class="btn-group btn-group-sm mx-1" role="group" aria-label="...">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-print-hutang{{ $item->id_invoice }}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                      <i class="bi bi-printer-fill"></i>
                                    </a>
                                  </div>                
                                </div>
                                {{-- button invoice --}}
                              </div>
                            </td>

                            @elseif($item->start_inv <= $item->end_inv  == date('Y-m-d'))
                            <td class="col-auto">
                              <div class="text-sm d-flex">
                                {{-- button invoice --}}
                                <div>
                                  <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-terbayar{{ $item->id_invoice }}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice">
                                      <i class="bi bi-receipt-cutoff text-dark"></i>
                                    </a>
                                  </div>                
                                </div>

                                <div>
                                  <div class="btn-group btn-group-sm mx-1" role="group" aria-label="...">
                                    <a type="button" data-bs-toggle="modal" data-bs-target="#invoice-print-tebayar{{ $item->id_invoice }}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                      <i class="bi bi-printer-fill"></i>
                                    </a>
                                  </div>                
                                </div>
                                {{-- button invoice --}}
                              </div>
                              
                            </td>  
                            @endif           
                            @endif
                            

                          </tr>
                          @endforeach
                          
                      </tbody>
                  </table>
                  {{-- <div class="text-end">                   
                    <p>Invoice Terbayar: @currency($bayar->sum('subtotal'))</p>
                    <p>Invoice Belum Bayar: @currency($belumbayar->sum('subtotal'))</p>
                  </div> --}}
              </div>
          </div>
      </div>
    </div>
    {{-- tabel pelanggan end --}}

  </section>
</div>

<style>
.scroll {
  width: 100;
  overflow: auto;
  white-space: nowrap;
}
</style>

@foreach ($invoice as $item)
<div class="modal" id="invoice-terbayar{{ $item->id_invoice }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Invoice Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="line-height: 2px;">Terbayar</p>
        {{-- <div class="form-group">
          <input type="text" name="search" id="search" class="form-control" placeholder="Invoice Terbayar" />
        </div> --}}
        <div class="scroll">
          <ul class="list-group list-group-flush">
            {{-- @foreach ($invoice as $data)
            @if ($data->status_inv == 'Berlangganan')
              @if ($item->kode_pelanggan == $data->kode_pelanggan)  --}}
              <li class="list-group-item text-dark" style="border-bottom: 1px solid rgb(191, 191, 191);">
                <div class="justify-content-between d-flex">
                  <div><span class="text-uppercase">{{ $item->id_invoice }}</span> | {{ date('d M, Y', strtotime($item->start_inv)) }} s/d {{ date('d M, Y', strtotime($item->end_inv)) }}</div>
                  
                  <div class="d-flex text-sm">
                    {{-- button invoice --}}
                    <div>
                      <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <a href="/invoicewng/{{ $item->id_invoice}}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                          <i class="bi bi-receipt-cutoff text-dark"></i> WNG
                        </a>
                      </div>                
                    </div>

                    <div>
                      <div class="btn-group btn-group-sm mx-2" role="group" aria-label="...">
                        <a href="/invoicesry/{{ $item->id_invoice}}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                          <i class="bi bi-receipt-cutoff"></i> Surya Candra
                        </a>
                      </div>                
                    </div>
                    {{-- button invoice --}}
                  </div>
                </div>
              </li>
              {{-- @endif    
            @endif
            @endforeach --}}
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="invoice-print-tebayar{{ $item->id_invoice }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Invoice Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="line-height: 2px;">Terbayar</p>
        {{-- <div class="form-group">
          <input type="text" name="search" id="search" class="form-control" placeholder="Invoice Terbayar" />
        </div> --}}
        <div class="scroll">
          <ul class="list-group list-group-flush">
            {{-- @foreach ($invoice as $data)
            @if ($data->status_inv == 'Berlangganan')
              @if ($item->kode_pelanggan == $data->kode_pelanggan)  --}}
              <li class="list-group-item text-dark" style="border-bottom: 1px solid rgb(191, 191, 191);">
                <div class="justify-content-between d-flex">
                  <div><span class="text-uppercase">{{ $item->id_invoice }}</span> | {{ date('d M, Y', strtotime($item->start_inv)) }} s/d {{ date('d M, Y', strtotime($item->end_inv)) }}</div>
                  
                  <div class="d-flex text-sm">
                    {{-- button invoice --}}
                    <div>
                      <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <a href="/invoicewng/print/{{ $item->id_invoice}}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                          <i class="bi bi-receipt-cutoff text-dark"></i> WNG
                        </a>
                      </div>                
                    </div>

                    <div>
                      <div class="btn-group btn-group-sm mx-2" role="group" aria-label="...">
                        <a href="/print/{{ $item->id_invoice}}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                          <i class="bi bi-receipt-cutoff"></i> Surya Candra
                        </a>
                      </div>                
                    </div>
                    {{-- button invoice --}}
                  </div>
                </div>
              </li>
              {{-- @endif    
            @endif
            @endforeach --}}
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="invoice-hutang{{ $item->id_invoice }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Invoice Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="line-height: 2px;">Belum Terbayar</p>
        {{-- <div class="form-group">
          <input type="text" name="search" id="search" class="form-control" placeholder="Invoice Belum Bayar" />
        </div> --}}
        <div class="scroll">
          <ul class="list-group list-group-flush">
            {{-- @foreach ($invoice as $data)
            @if ($data->status_inv == 'BelumBayar')
              @if ($item->kode_pelanggan == $data->kode_pelanggan)  --}}
              <li class="list-group-item text-dark" style="border-bottom: 1px solid rgb(191, 191, 191);">
                <div class="justify-content-between d-flex">
                  <div><span class="text-uppercase">{{ $item->id_invoice }}</span> | {{ date('d M, Y', strtotime($item->start_inv)) }} s/d {{ date('d M, Y', strtotime($item->end_inv)) }}</div>
                  
                  <div class="d-flex text-sm">
                    {{-- button invoice --}}
                    <div>
                      <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <a href="/invoicewng/{{$item->id_invoice}}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                          <i class="bi bi-receipt-cutoff text-dark"></i> WNG
                        </a>
                      </div>                
                    </div>

                    <div>
                      <div class="btn-group btn-group-sm mx-2" role="group" aria-label="...">
                        <a href="/invoicesry/{{ $item->id_invoice}}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                          <i class="bi bi-receipt-cutoff"></i> Surya Candra
                        </a>
                      </div>                
                    </div>
                    {{-- button invoice --}}
                  </div>
                </div>
              </li>
              {{-- @endif    
            @endif
            @endforeach --}}
          </ul>
        </div>


      </div>
    </div>
  </div>
</div>


<div class="modal" id="invoice-print-hutang{{ $item->id_invoice }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Invoice Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="line-height: 2px;">Belum Terbayar</p>
        {{-- <div class="form-group">
          <input type="text" name="search" id="search" class="form-control" placeholder="Invoice Belum Bayar" />
        </div> --}}
        <div class="scroll">
          <ul class="list-group list-group-flush">
            {{-- @foreach ($invoice as $data)
            @if ($data->status_inv == 'BelumBayar')
              @if ($item->kode_pelanggan == $data->kode_pelanggan)  --}}
              <li class="list-group-item text-dark" style="border-bottom: 1px solid rgb(191, 191, 191);">
                <div class="justify-content-between d-flex">
                  <div><span class="text-uppercase">{{ $item->id_invoice }}</span> | {{ date('d M, Y', strtotime($item->start_inv)) }} s/d {{ date('d M, Y', strtotime($item->end_inv)) }}</div>
                  
                  <div class="d-flex text-sm">
                    {{-- button invoice --}}
                    <div>
                      <div class="btn-group btn-group-sm" role="group" aria-label="...">
                        <a href="/invoicewng/print/{{$item->id_invoice}}" class="btn btn-info" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                          <i class="bi bi-receipt-cutoff text-dark"></i> WNG
                        </a>
                      </div>                
                    </div>

                    <div>
                      <div class="btn-group btn-group-sm mx-2" role="group" aria-label="...">
                        <a href="/print/{{ $item->id_invoice}}" class="btn btn-primary" style="font-size: 10px" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice" target="_blank">
                          <i class="bi bi-receipt-cutoff"></i> Surya Candra
                        </a>
                      </div>                
                    </div>
                    {{-- button invoice --}}
                  </div>
                </div>
              </li>
              {{-- @endif    
            @endif
            @endforeach --}}
          </ul>
        </div>


      </div>
    </div>
  </div>
</div>
@endforeach
{{-- modal end invoice --}}


<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


<script src="../js/jquery-3.5.1.min.js"></script>
<script>
  $(document).ready(function(){
      $('#example').DataTable({
          info: false,
          retrieve: true,
      });
  });
</script>
@endsection