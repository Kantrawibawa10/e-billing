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
    <h3>Halaman Pelanggan</h3>
    <p>Berisi Data dari Pelanggan {{ auth()->user()->level }}</p>
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
                              <i class="iconly-boldProfile"></i>
                            </div>
                          </div>
                          <div class="col-md-8">
                              <h6 class="text-muted font-semibold">Pelanggan</h6>
                              <h6 class="font-extrabold mb-0">{{ $pelanggan->count() }}</h6>
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
                                  <i class="iconly-boldProfile"></i>
                              </div>
                          </div>
                          <div class="col-md-8">
                              <h6 class="text-muted font-semibold">Pelanggan Bulan Ini</h6>
                              <h6 class="font-extrabold mb-0">{{ $bulanini->count() }}</h6>
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
        <strong>Pelanggan</strong>  {{ session()->get('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif 

      @if(session()->get('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Pelanggan</strong>  {{ session()->get('error') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <!--END SESSION ALERT-->
      
      <div class="card">
        <div class="card-header row justify-content-between">
          <div class="d-flex col-md-8">
            <h4>Daftar Pelangan</h4>
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
                              <th>Aksi</th>
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

                              <td class="col-auto">
                                <div class="d-flex text-sm">
                                  <div class="mx-2">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                      <a type="buttom" data-bs-toggle="modal" data-bs-target="#edit{{ $item->kode_pelanggan }}" class="btn btn-primary" style="font-size: 10px">
                                        <i class="bi bi-pencil-fill"></i>
                                      </a>
                                    </div>
                                  </div>
            
                                  {{-- <div>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                      <a href="" class="btn btn-warning" style="font-size: 10px">
                                        <i class="bi bi-eye-fill"></i>
                                      </a>
                                    </div>                
                                  </div> --}}
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
    {{-- tabel pelanggan end --}}

  </section>
</div>






<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add Pelanggan</h5>
            <a type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>
        <form action="{{ route('addpelanggan') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">  
                {{-- <input type="hidden" name="generate_no" value="{{$id}}"> --}}
                <input type="hidden" name="kode_pelanggan" value="{{$kode_pelanggan}}">

                <div class="mb-0">
                  <h4>Required</h4>
                  <hr>
                </div>


                <div class="mb-1">
                    <label for="NIK" class="col-form-label font-label text-secondary text-xs opacity-7">NIK:</label>
                    <input type="text" min="0" maxlength="16" pattern="\d{16}" class="form-control border p-2 text-dark text-xs opacity-7" id="nik" name="nik"  placeholder="NIK" onkeypress="return hanyaAngka(event)">
                </div>
                
                <div class="row">
                    <div class="mb-1 col-md-6">
                        <label for="nama" class="col-form-label font-label text-secondary text-xs opacity-7">Nama:</label>
                        <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="nama" name="nama"  placeholder="Nama Lengkap">
                    </div>

                    <div class="mb-1 col-md-3">
                      <label for="nama" class="col-form-label font-label text-secondary text-xs opacity-7">No. Telpn:</label>
                      <input type="text" maxlength="12" class="form-control border p-2 text-dark text-xs opacity-7 no_hp" id="no_telpn" name="no_telpn"  placeholder="+62" onkeypress="return hanyaAngka(event)">
                    </div>

                    <div class="mb-1 col-md-3">
                      <label for="email" class="col-form-label font-label text-secondary text-xs opacity-7">Email:</label>
                      <input type="email" class="form-control border p-2 text-dark text-xs opacity-7" id="email" name="text"  placeholder="Email">
                    </div>
                </div>

                <div class="mb-1 col-md-12">
                  <label for="alamat" class="col-form-label font-label text-secondary text-xs opacity-7">Alamat:</label>
                  <textarea class="form-control border p-2 text-dark text-xs opacity-7" placeholder="Alamat" name="alamat" id="alamat"></textarea>
                </div>

                <div class="d-none">
                  @foreach ($kategori as $item)
                  <input type="text" name="id_kategori" value="{{ $item->id }}">    
                  @endforeach
                </div>

                <input type="hidden" name="created_at" value="<?php echo date('Y-m-d'); ?>">
                <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d'); ?>">
                <input type="hidden" name="bulan" value="<?php echo date('m'); ?>">

                <div class="mb-0 mt-4">
                  <h4>Opsional</h4>
                  <hr>
                </div>

                <div class="row">
                  <div class="mb-1 col-md-12">
                    <label for="keterangan" class="col-form-label font-label text-secondary text-xs opacity-7">Catatan:</label>
                    <textarea class="form-control border p-2 text-dark text-xs opacity-7" placeholder="Note" name="catatan"></textarea>
                  </div>

                  <div class="mb-1 col-md-12">
                    <input type="file" name="file" class="from-control border p-2 text-dark text-xs opacity-7" style="font-size: 15px;">
                  </div>
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









@foreach ($pelanggan as $item)
<!-- Modal -->
<div class="modal fade" id="edit{{ $item->kode_pelanggan }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add Pelanggan</h5>
            <a type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>
        <form action="/pelanggan/update/{{ $item->kode_pelanggan }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">  
                <div class="mb-0">
                  <h4>Required</h4>
                  <hr>
                </div>

                <input type="hidden" name="kode_pelanggan" value="{{ $item->kode_pelanggan }}">

                <div class="mb-1">
                  <label for="NIK" class="col-form-label font-label text-secondary text-xs opacity-7">NIK:</label>
                  <input type="text" min="0" maxlength="16" pattern="\d{16}" class="form-control border p-2 text-dark text-xs opacity-7" id="nik" name="nik" placeholder="NIK" onkeypress="return hanyaAngka(event)" value="{{ $item->nik }}">
                </div>
                
                <div class="row">
                    <div class="mb-1 col-md-6">
                        <label for="nama" class="col-form-label font-label text-secondary text-xs opacity-7">Nama:</label>
                        <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="nama" name="nama" required placeholder="Nama Lengkap" value="{{ $item->nama }}">
                    </div>

                    <div class="mb-1 col-md-3">
                      <label for="nama" class="col-form-label font-label text-secondary text-xs opacity-7">No. Telpn:</label>
                      <input type="text" maxlength="12" class="form-control border p-2 text-dark text-xs opacity-7 no_hp" id="no_telpn" name="no_telpn" required placeholder="+62" onkeypress="return hanyaAngka(event)" value="{{ $item->no_telpn }}">
                    </div>

                    <div class="mb-1 col-md-3">
                      <label for="email" class="col-form-label font-label text-secondary text-xs opacity-7">Email:</label>
                      <input type="email" class="form-control border p-2 text-dark text-xs opacity-7" id="email" name="email"  placeholder="Email" value="{{ $item->email }}">
                    </div>
                </div>

                <div class="mb-1 col-md-12">
                  <label for="alamat" class="col-form-label font-label text-secondary text-xs opacity-7">Alamat:</label>
                  <textarea class="form-control border p-2 text-dark text-xs opacity-7" placeholder="Alamat" name="alamat" id="alamat">{{ $item->alamat }}</textarea>
                </div>


                <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d'); ?>">

                <div class="mb-0 mt-4">
                  <h4>Opsional</h4>
                  <hr>
                </div>

                <div class="row">
                  <div class="mb-1 col-md-12">
                    <label for="keterangan" class="col-form-label font-label text-secondary text-xs opacity-7">Catatan:</label>
                    <textarea class="form-control border p-2 text-dark text-xs opacity-7" placeholder="Note" name="catatan">{{ $item->catatan }}</textarea>
                  </div>

                  <div class="mb-1 col-md-12">
                    <div class="d-flex justify-content-between">
                      <input type="file" name="file" class="from-control border p-2 text-dark text-xs opacity-7" style="font-size: 15px;">
                      @if($item->file == "")

                      @else
                      <button type="button" data-bs-toggle="modal" data-bs-target="#img{{ $item->kode_pelanggan }}" class="btn btn-primary" >Foto</button>
                      @endif
                    </div>
                  </div>
                </div>    
                
                <div class=" row col-md-6">
                  <label for="status" class="col-form-label font-label text-secondary text-xs opacity-7">Status:</label>

                  <div class="col-md-3 mx-1">
                    
                    @if ($item->status == 'aktif')
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="{{ $item->status }}" checked>
                      <label class="form-check-label" for="exampleRadios1">
                        Aktif
                      </label>
                    </div>
                    @else
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="aktif">
                      <label class="form-check-label" for="exampleRadios1">
                        Aktif
                      </label>
                    </div> 
                    @endif
                    
                  </div>

                  <div class="col-md-3">

                    @if ($item->status == 'nonaktif')
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="{{ $item->status }}" checked>
                      <label class="form-check-label" for="exampleRadios1">
                        NonAktif
                      </label>
                    </div>
                    @else
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="nonaktif">
                      <label class="form-check-label" for="exampleRadios1">
                        NonAktif
                      </label>
                    </div> 
                    @endif

                  </div>

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




<!-- Modal -->
<div class="modal fade" id="img{{ $item->kode_pelanggan }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#edit{{ $item->kode_pelanggan }}"></button>
      </div>
      <div class="modal-body">
        <img src="{{ url('file/'. $item->file ) }}" class="img-fluid" alt="">
      </div>
    </div>
  </div>
</div>
@endforeach




<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1ef022ab/dist/jquery.mask.min.js"></script>
<script src="https://raw.githubusercontent.com/igorescobar/jQuery-Mask-Plugin/master/src/jquery.mask.js"></script>


<script>
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }
</script>

<script>
  $(document).ready(function($){
      $(".no_hp").mask("+62 00000000000"); 
  });
</script>

<script>
$(document).ready(function () {
    $('#example').DataTable();
});
</script>
  
<script>
  $(document).ready(function(){
      $('#example').DataTable({
        info: false,
        searching: false,
        retrieve: true,
      });
  });
</script>

@endsection