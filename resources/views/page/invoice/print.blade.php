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
    <h3>Print Data Invoice Pelanggan</h3>
    <p>Print Data Invoice Pelanggan {{ auth()->user()->level }}</p>
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


    {{-- tabel pelanggan start --}}
    <div class="col-12 col-xl-12">
      
      <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div class="d-flex">
              <h4>Print</h4>
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
                              <p class="font-bold mb-0 text-danger" style="font-size: 12px">{{ date('Y-d-m', strtotime($item->start_inv)) }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-danger" style="font-size: 12px">{{ date('Y-d-m', strtotime($item->end_inv)) }}</p>
                            </td> 
                            
                            @elseif(date('Y-m-d', strtotime("-14 day", strtotime($item->end_inv))) <= date('Y-m-d'))
                            <td class="col-auto">
                              <p class=" mb-0 text-warning" style="font-size: 12px">{{$item->nama}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0" style="font-size: 12px">{{$item->no_telpn}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-warning" style="font-size: 12px">{{ date('Y-d-m', strtotime($item->start_inv)) }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-warning" style="font-size: 12px">{{ date('Y-d-m', strtotime($item->end_inv)) }}</p>
                            </td>
                              
                            @elseif($item->start_inv <= $item->end_inv  == date('Y-m-d'))
                            <td class="col-auto">
                              <p class=" mb-0 text-success" style="font-size: 12px">{{$item->nama}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0" style="font-size: 12px">{{$item->no_telpn}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-success" style="font-size: 12px">{{ date('Y-d-m', strtotime($item->start_inv)) }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0 text-success" style="font-size: 12px">{{ date('Y-d-m', strtotime($item->end_inv)) }}</p>
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



<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


<script src="../js/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#example').DataTable({
            ordering: true,
            info: false,
            retrieve: true,
            paging: false,
            pageLength: 25,
            responsive: true,
            searching: false,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                // { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'e-billing.register'},
                {extend: 'pdf', title: 'e-billing.register'},

                {extend: 'print',
                 customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
                }
            ]
        });
    });

</script>
@endsection