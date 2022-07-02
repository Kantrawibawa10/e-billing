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
    <h3>Print e-Billing</h3>
    <p>Print Laporan e-Billing</p>
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
      
      <div class="card container-fluid">
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
                      <th>Register</th>
                      <th>Pelanggan</th>
                      <th>Paket</th>
                      <th>Biaya</th>
                      <th>Daftar</th>
                      <th>Expired</th>
                      <th>Status</th>
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


                        @if($item->end_reg <= date("Y-m-d")) 
                            {{-- status start --}}
                            <td class="col-auto">
                                <p class="text-warning mb-0" style="font-size: 12px">Perpanjang</p>
                            </td>
                            {{-- status End --}}
                        @endif
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


                        @if(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                            {{-- status start --}}
                            <td class="col-auto">
                                <p class="text-warning mb-0" style="font-size: 12px">Perpanjang</p>
                            </td>
                            {{-- status End --}}
                        @endif
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


                        @if($item->start_reg <= $item->end_reg == date('Y-m-d'))
                            {{-- status start --}}
                            <td class="col-auto">
                                <p class="text-success mb-0" style="font-size: 12px">Aktif</p>
                            </td>
                            {{-- status End --}}
                        @endif
                  
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



                      {{-- status start --}}
                      <td class="col-auto">
                        <p class="text-dark mb-0" style="font-size: 12px">Bayar</p>
                      </td>
                      {{-- status End --}}
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




                    {{-- button perpanjang --}}
                    @if(date('Y-m-d', strtotime("+1 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                    {{-- status start --}}
                    <td class="col-auto">
                        <p class="text-danger mb-0" style="font-size: 12px">Expired</p>
                    </td>
                    {{-- status End --}}

                    @elseif(date('Y-m-d', strtotime("-14 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                    {{-- status start --}}
                    <td class="col-auto">
                        <p class="text-warning mb-0" style="font-size: 12px">Perpanjang</p>
                    </td>
                    {{-- status End --}}
                    
                    @elseif($item->start_reg <= $item->end_reg == date('Y-m-d'))
                    {{-- status start --}}
                    <td class="col-auto">
                        <p class="text-success mb-0" style="font-size: 12px">Aktif</p>
                    </td>
                    {{-- status End --}}
                    @endif
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

                      {{-- status start --}}
                       <td class="col-auto">
                            <p class="text-dark mb-0" style="font-size: 12px">Belum Bayar</p>
                       </td>
                      {{-- status End --}}
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
  














{{--/////////////////////////////////////////////////////////////////////JAVASCRIPT START///////////////////////////////////////////////////////////// --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>

{{-- <script>
    $(document).ready(function(){
        $('#example').DataTable({
            ordering: false,
            info: false,
            retrieve: true,
        });
    });
  </script> --}}

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
{{--/////////////////////////////////////////////////////////////////////JAVASCRIPT END///////////////////////////////////////////////////////////// --}}
@endsection




