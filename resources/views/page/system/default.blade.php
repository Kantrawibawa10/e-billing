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
    <h3>Halaman System</h3>
    <p>Halaman Pengaturan {{ auth()->user()->level }}</p>
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


{{-- <div class="page-content pt-0 mt-0">
  <section class="row">
     tabel pelanggan start 
    <div class="col-12 col-xl-12">
      <!--START SESSION ALERT-->
      @if(session()->get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Default</strong> {{ session()->get('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif 

      @if(session()->get('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Default</strong> {{ session()->get('error') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <!--END SESSION ALERT-->
      
      <div class="card">
          <div class="card-header d-flex justify-content-between">
              <h4>Set Waktu</h4>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="example" class="table table-striped">
                      <thead>
                          <tr style="font-size: 13px">
                              <th>NO</th>
                              <th>Hari</th>
                              <th>Status</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @php $no = 1; @endphp
                        @foreach ($set_time as $item)
                        <tr>
                          <td class="col-auto">
                            <p class=" mb-0" style="font-size: 12px">{{ $no++ }}</p>
                          </td>

                          <td class="col-auto">
                            <p class=" mb-0" style="font-size: 12px">{{$item->set_day}} Hari</p>
                          </td>

                        
                          @if ($item->value == 'true')
                            <td class="col-auto">
                              <span class="badge bg-success mb-0" style="font-size: 12px">Aktif</span>
                            </td>   
                            @elseif($item->value == 'false')
                            <td class="col-auto">
                              <span class="badge bg-dark mb-0" style="font-size: 12px">NonAktif</span>
                            </td>     
                          @endif

                            <td class="col-auto">
                              <div class="d-flex text-sm">
                                <div class="mx-2">
                                  <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a type="buttom" data-bs-toggle="modal" data-bs-target="#setday{{ $item->id }}" class="btn btn-primary" style="font-size: 10px">
                                      <i class="bi bi-pencil-fill"></i>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </td>
                        </tr>
                        @endforeach
                          
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
    </div>
     tabel pelanggan end 
  </section>
</div> --}}


<!-- setday users -->
{{-- @foreach ($set_time as $item)
<div class="modal fade" id="setday{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Hari</h5>
            <a type="buttom" data-bs-toggle="modal" data-bs-dismiss="modal" class="close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>

        <form action="/system/setday/{{ $item->id }}" method="POST">
        @csrf            
        <div class="container">
            <div class="row">
                <div class="mb-4">
                    <input type="hidden" value="{{ $item->id }}" name="id">
                    <label for="setday" class="col-form-label font-label">Set Day:</label>
                    <input type="number" class="form-control" name="set_day" value="{{ $item->set_day }}">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="buttom" data-bs-dismiss="modal" class="btn btn-danger">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>

    </div>
  </div>
</div>
@endforeach --}}
<!-- end setday users -->




{{-- SET BERLANGGANAN START --}}
<div class="page-content pt-0 mt-0">
  <section class="row">
    {{-- tabel pelanggan start --}}
    <div class="col-12 col-xl-12">  
      <div class="card">
          <div class="card-header d-flex justify-content-between">
              <h4>Set Berlangganan</h4>
              <a type="buttom" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary" style="font-size: 10px">
                Tambah
              </a>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="dataTable" class="table table-striped">
                      <thead>
                          <tr style="font-size: 13px">
                              <th>NO</th>
                              <th>Bulan</th>
                              <th>Status</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                        @php $no = 1; @endphp
                        @foreach ($set_berlangganan as $item)
                        <tr>
                          <td class="col-auto">
                            <p class=" mb-0" style="font-size: 12px">{{ $no++ }}</p>
                          </td>

                          <td class="col-auto">
                            <p class=" mb-0" style="font-size: 12px">{{$item->berlangganan}} Bulan</p>
                          </td>

                        
                          @if ($item->value == 'true')
                            <td class="col-auto">
                              <span class="badge bg-success mb-0" style="font-size: 12px">Aktif</span>
                            </td>   
                            @elseif($item->value == 'false')
                            <td class="col-auto">
                              <span class="badge bg-dark mb-0" style="font-size: 12px">NonAktif</span>
                            </td>     
                          @endif

                            <td class="col-auto">
                              <div class="d-flex text-sm">
                                <div class="mx-2">
                                  <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <a type="buttom" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id }}" class="btn btn-primary btn-sm" style="font-size: 10px">
                                      <i class="bi bi-pencil-fill"></i> 
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </td>
                        </tr>
                        @endforeach
                          
                      </tbody>
                  </table>

                  {{-- {{ $set_berlangganan->links('layouts.pagination') }} --}}
                                   
              </div>
          </div>
      </div>
    </div>
    {{-- tabel pelanggan end --}}
  </section>
</div>
{{-- SET BERLANGGANAN END --}}


<!-- berlangganan users -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add Bulan</h5>
            <a type="buttom" data-bs-toggle="modal" data-bs-dismiss="modal" class="close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>

        <form action="{{ route('berlangganan') }}" method="POST">
        @csrf            
        <div class="container">
            <div class="row">
                <div class="mb-1">
                    <label for="setday" class="col-form-label font-label">Add Berlangganan:</label>
                    <div class="d-flex justify-content-between">
                      <div class="col-md-9">
                        <input type="number" class="form-control" name="berlangganan" required>
                      </div>
                      <div class="col-md-3 text-end">
                        <h1>Bulan</h1>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="buttom" data-bs-dismiss="modal" class="btn btn-danger">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>

    </div>
  </div>
</div>
<!-- end berlangganan users -->



<!-- berlangganan users -->
@foreach ($set_berlangganan as $item)
<div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Bulan</h5>
            <a type="buttom" data-bs-toggle="modal" data-bs-dismiss="modal" class="close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>

        <form action="/system/berlangganan/{{ $item->id }}" method="POST">
        @csrf            
        <div class="container">
            <div class="row">
                <div class="mb-1">
                    <input type="hidden" value="{{ $item->id }}" name="id">
                    <label for="setday" class="col-form-label font-label">Set Berlangganan:</label>
                    <div class="d-flex justify-content-between">
                      <div class="col-md-9">
                        <input type="number" class="form-control" name="berlangganan" value="{{ $item->berlangganan }}">
                      </div>
                      <div class="col-md-3 text-end">
                        <h1>Bulan</h1>
                      </div>
                    </div>
                </div>

                <div class="mb-2 row col-md-6">
                  <label for="status" class="col-form-label font-label text-secondary text-xs opacity-7">Status:</label>

                  <div class="col-md-5 mx-1">
                    
                    @if ($item->value == 'true')
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="radio" name="value" id="exampleRadios1" value="{{ $item->value }}" checked>
                      <label class="form-check-label" for="exampleRadios1">
                        Aktif
                      </label>
                    </div>
                    @else
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="radio" name="value" id="exampleRadios1" value="true">
                      <label class="form-check-label" for="exampleRadios1">
                        Aktif
                      </label>
                    </div> 
                    @endif
                    
                  </div>

                  <div class="col-md-3">

                    @if ($item->value == 'false')
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="radio" name="value" id="exampleRadios1" value="{{ $item->value }}" checked>
                      <label class="form-check-label" for="exampleRadios1">
                        NonAktif
                      </label>
                    </div>
                    @else
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="radio" name="value" id="exampleRadios1" value="false">
                      <label class="form-check-label" for="exampleRadios1">
                        NonAktif
                      </label>
                    </div> 
                    @endif

                  </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="buttom" data-bs-dismiss="modal" class="btn btn-danger">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>

    </div>
  </div>
</div>
@endforeach
<!-- end berlangganan users -->


<script src="../assets/js/bootstrap.bundle.min.js"></script>
@endsection