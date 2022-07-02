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
    <h3>Print Pelanggan</h3>
    <p>Print Laporan Pelanggan</p>
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




        {{-- search start --}}
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
                    <form class="row from" action="{{ route('searchpelanggan') }}" method="get" >
                      <div class="input-group input--medium">
                        <label class="label">Kode</label>
                        <input class="input--style-1" type="text" name="kode_pelanggan" placeholder="Kode Pelanggan" id="input-start" value="{{Request::get('kode_pelanggan')}}">
                      </div>   
                    
                      <div class="input-group input--large">
                        <label class="label">Pelanggan</label>
                        <input class="input--style-1" type="text" placeholder="Nama Pelanggan" name="nama" value="{{Request::get('nama')}}">
                      </div>           
            
                      <div class="input-group input--medium">
                        <label class="label">Tanggal</label>
                        <input class="input--style-1" type="date" name="created_at" placeholder="mm/dd/yyyy" id="input-start" value="{{Request::get('created_at')}}">
                      </div>
            
                      <div class="input-group input--medium">
                        <label class="label">Tanggal</label>
                        <input class="input--style-1" type="date" name="end_tanggal" placeholder="mm/dd/yyyy" id="input-end" value="{{Request::get('end_tanggal')}}">
                      </div> 
                      
                      <div class="input-group input--medium">
                        <label class="label">Status</label>
                        <select name="status" id="input-start" class="input--style-1" type="text" value="{{Request::get('status')}}" style="border: none;">
                          <option value="" selected disabled>Pilis Status</option>
                          <option value="">Semua</option>
                          <option value="aktif">Aktif</option>
                          <option value="nonaktif">NonAktif</option>
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
        {{-- search end --}}


        {{-- print start --}}
        <div class="modal fade" id="print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="col-12 col-xl-12">
                  <div class="card-body card-7">
                    <form class="row from" action="{{ route('printpelanggan') }}" method="get" >
                      <div class="input-group input--medium">
                        <label class="label">Kode</label>
                        <input class="input--style-1" type="text" name="kode_pelanggan" placeholder="Kode Pelanggan" id="input-start" value="{{Request::get('kode_pelanggan')}}">
                      </div>   
                    
                      <div class="input-group input--large">
                        <label class="label">Pelanggan</label>
                        <input class="input--style-1" type="text" placeholder="Nama Pelanggan" name="nama" value="{{Request::get('nama')}}">
                      </div>           
            
                      <div class="input-group input--medium">
                        <label class="label">Tanggal</label>
                        <input class="input--style-1" type="date" name="created_at" placeholder="mm/dd/yyyy" id="input-start" value="{{Request::get('created_at')}}">
                      </div>
            
                      <div class="input-group input--medium">
                        <label class="label">Tanggal</label>
                        <input class="input--style-1" type="date" name="end_tanggal" placeholder="mm/dd/yyyy" id="input-end" value="{{Request::get('end_tanggal')}}">
                      </div> 
                      
                      <div class="input-group input--medium">
                        <label class="label">Status</label>
                        <select name="status" id="input-start" class="input--style-1" type="text" value="{{Request::get('status')}}" style="border: none;">
                          <option value="" selected disabled>Pilis Status</option>
                          <option value="">Semua</option>
                          <option value="aktif">Aktif</option>
                          <option value="nonaktif">NonAktif</option>
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
        {{-- print end --}}



          <div class="card-body">
              <div class="table-responsive">
                  <table id="example" class="table table-striped">
                      <thead>
                          <tr style="font-size: 13px">
                              <th>NO</th>
                              <th>Kode</th>
                              <th>Pelanggan</th>
                              <th>Telpn</th>
                              <th>Created</th>
                              <th>Updated</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php $no = 1; @endphp
                          @foreach ($pelanggan as $item)
                          <tr>
                            <td class="col-auto">
                              <p class=" mb-0" style="font-size: 12px">{{ $no++ }}</p>
                            </td>

                            <td class="col-auto">
                              <p class=" mb-0" style="font-size: 12px">{{ $item->kode_pelanggan }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0" style="font-size: 12px">{{$item->nama}}</p>
                            </td>

                              <td class="col-auto">
                                  <p class=" mb-0" style="font-size: 12px">{{$item->no_telpn}}</p>
                              </td>

                              <td class="col-auto">
                                <p class=" mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->created_at)) }}</p>
                              </td>

                              <td class="col-auto">
                                <p class=" mb-0" style="font-size: 12px" >{{ date('Y-m-d', strtotime($item->updated_at)) }}</p>
                              </td>

                              @if ($item->status == 'aktif')
                              <td class="col-auto">
                                <span class="badge bg-success mb-0" style="font-size: 12px">Aktif</span>
                              </td>   
                              @elseif($item->status == 'nonaktif')
                              <td class="col-auto">
                                <span class="badge bg-dark mb-0" style="font-size: 12px">NonAktif</span>
                              </td>     
                              @endif
                          </tr>
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




<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>
<script src="https://raw.githubusercontent.com/igorescobar/jQuery-Mask-Plugin/master/src/jquery.mask.js"></script>


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