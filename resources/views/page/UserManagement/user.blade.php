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
    <h3>Halaman Users</h3>
    <p>Berisi Data dari Users {{ auth()->user()->level }}</p>
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
                                  <h6 class="text-muted font-semibold">Users</h6>
                                  <h6 class="font-extrabold mb-0">{{ $users->count() }}</h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>      
        </div>
        {{-- row data halaman pelanggan end --}}

    {{-- start search halaman pelanggan --}}
    <div class="col-12 col-xl-12">
      <div class="card-body card-7">
        <form class="row from" action="{{ url("/user/search") }}" method="get">
          <div>
            <h4>Search</h4>
          </div> 

          <div class="input-group input--medium">
            <label class="label">Kode</label>
            <input class="input--style-1" type="text" name="kode" placeholder="Kode Users" id="input-start" value="{{Request::get('kode')}}">
          </div>    


          <div class="input-group input--large">
            <label class="label">User</label>
            <input class="input--style-1" type="text" placeholder="Nama Users" name="nama" value="{{Request::get('nama')}}">
          </div>      
          

          <div class="input-group input--medium">
            <label class="label">Username</label>
            <input class="input--style-1" type="text" name="username" placeholder="Username Users" id="input-start" value="{{Request::get('username')}}">
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
    {{-- end search halaman pelanggan --}}

    

    {{-- tabel pelanggan start --}}
    <div class="col-12 col-xl-12">
      <!--START SESSION ALERT-->
      @if(session()->get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Users!</strong> {{ session()->get('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif 

      @if(session()->get('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Users!</strong> {{ session()->get('error') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <!--END SESSION ALERT-->
      
      <div class="card">
          <div class="card-header d-flex justify-content-between">
              <h4>Daftar Users</h4>

              <a type="button" class="p-2 bg-primary text-white" data-bs-toggle="modal" data-bs-target="#tambah" style="font-size: 12px; border-radius: 10px;">
                Add Users <i class="bi bi-person-plus-fill"></i>
              </a>                        
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="example" class="table table-striped">
                      <thead>
                          <tr style="font-size: 13px">
                              <th>NO</th>
                              <th>Kode</th>
                              <th>Nama</th>
                              <th>Username</th>
                              <th>Role</th>
                              <th>Created</th>
                              <th>Status</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php $no = 1; @endphp
                          @foreach ($users as $item)
                          <tr>
                            <td class="col-auto">
                              <p class=" mb-0" style="font-size: 12px">{{ $no++ }}</p>
                            </td>
                            
                            <td class="col-auto">
                              <p class="text-uppercase mb-0" style="font-size: 12px">{{ $item->kode }}</p>
                            </td>

                            <td class="col-auto">
                              <p class="text-capitalize mb-0" style="font-size: 12px">{{$item->nama}}</p>
                            </td>

                            <td class="col-auto">
                              <p class="font-bold mb-0" style="font-size: 12px">{{$item->username}}</p>
                            </td>

                              <td class="col-auto">
                                  <p class="text-capitalize mb-0" style="font-size: 12px">{{$item->role}}</p>
                              </td>

                              <td class="col-auto">
                                <p class=" mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->created_at)) }}</p>
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
                                      <a type="buttom" data-bs-toggle="modal" data-bs-target="#edit{{ $item->kode }}" class="btn btn-primary" style="font-size: 10px">
                                        <i class="bi bi-pencil-fill"></i>
                                      </a>
                                    </div>
                                  </div>
            
                                  <div>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                      <a href="" class="btn btn-warning" style="font-size: 10px">
                                        <i class="bi bi-eye-fill"></i>
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
    {{-- tabel pelanggan end --}}

  </section>
</div>



<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add Users</h5>
            <a type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>

        <form action="{{ route('adduser') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">  
                {{-- <input type="hidden" name="generate_no" value="{{$id}}"> --}}
                <input type="hidden" name="kode" value="{{$kode}}">

                <div class="mb-0">
                  <h4>Required</h4>
                  <hr>
                </div>

                <div class="mb-1">
                    <label for="Nama" class="col-form-label font-label text-secondary text-xs opacity-7">Nama:</label>
                    <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="Nama" name="nama" required placeholder="Nama Users">
                </div>
                
                <div class="row">
                    <div class="mb-1 col-md-6">
                      <label for="username" class="col-form-label font-label text-secondary text-xs opacity-7">Username:</label>
                      <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="username" name="username" required placeholder="Username">
                    </div>

                    <div class="mb-1 col-md-6">
                      <label for="password" class="col-form-label font-label text-secondary text-xs opacity-7">Password:</label>
                      <input type="password" class="form-control border p-2 text-dark text-xs opacity-7" id="password" name="password" required placeholder="******">
                    </div>
                </div>

                <div class="mb-1">
                  <label for="Role" class="col-form-label font-label text-secondary text-xs opacity-7">Role:</label>
                  <select name="id_role" id="id_role" class="form-control border p-2 text-dark text-xs opacity-7">
                    <option value="" selected disabled>-- Select Role --</option>
                    @foreach ($role as $roles)
                    <option value="{{ $roles->id_role }}" class="text-capitalize">{{ $roles->role }}</option>               
                    @endforeach
                  </select>                  
                </div>

                <input type="hidden" name="created_at" value="<?php echo date('Y-m-d'); ?>">
                <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d'); ?>">

                <div class="mb-0 mt-4">
                  <h4>Opsional</h4>
                  <hr>
                </div>

                <div class="row">
                  <div class="mb-1 col-md-12">
                    <label for="keterangan" class="col-form-label font-label text-secondary text-xs opacity-7">Catatan:</label>
                    <textarea class="form-control border p-2 text-dark text-xs opacity-7" placeholder="Note" name="note"></textarea>
                  </div>

                  <div class="mb-1 col-md-12">
                    <input type="file" name="img" class="from-control border p-2 text-dark text-xs opacity-7" style="font-size: 15px;">
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




@foreach ($users as $item)
<!-- Modal -->
<div class="modal fade" id="edit{{ $item->kode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Users</h5>
            <a type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>

        <form action="/user/update/{{ $item->kode }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">  
              {{-- <input type="hidden" name="generate_no" value="{{$id}}"> --}}
              <input type="hidden" name="kode" value="{{ $item->kode }}">

              <div class="mb-0">
                <h4>Required</h4>
                <hr>
              </div>

              <div class="mb-1">
                  <label for="Nama" class="col-form-label font-label text-secondary text-xs opacity-7">Nama:</label>
                  <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="Nama" name="nama" required placeholder="Nama Users" value="{{ $item->nama }}">
              </div>
              
              <div class="row">
                  <div class="mb-1 col-md-6">
                    <label for="username" class="col-form-label font-label text-secondary text-xs opacity-7">Username:</label>
                    <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="username" name="username" required placeholder="Username" value="{{ $item->username }}">
                  </div>

                  <div class="mb-1 col-md-6">
                    <label for="Role" class="col-form-label font-label text-secondary text-xs opacity-7">Role:</label>
                    <select name="id_role" id="id_role" class="form-control border p-2 text-dark text-xs opacity-7">
                      <option value="" selected disabled>-- Select Role --</option>
                      @foreach ($role as $roles)

                      @if ( $roles->id_role == $item->id_role )
                      <option selected value="{{ $roles->id_role }}" class="text-capitalize">{{ $roles->role }}</option>               
                      @else    
                      <option value="{{ $roles->id_role }}" class="text-capitalize">{{ $roles->role }}</option>               
                      @endif

                      @endforeach
                    </select>                  
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

              <div class="mb-1">
                <label for="password" class="col-form-label font-label">Password:</label>
                <div class="d-flex">
                    <a href="" class="btn btn-dark col-12 pt-2" style="font-size: 13px; font-weight: 600;" type="button" data-bs-toggle="modal" data-bs-target="#password{{$item->kode}}" data-bs-dismiss="modal">Ubah Password</a>
                </div>
              </div>
              

              <input type="hidden" name="updated_at" value="<?php echo date('Y-m-d'); ?>">

              <div class="mb-0 mt-4">
                <h4>Opsional</h4>
                <hr>
              </div>

              <div class="row">
                <div class="mb-1 col-md-12">
                  <label for="keterangan" class="col-form-label font-label text-secondary text-xs opacity-7">Catatan:</label>
                  <textarea class="form-control border p-2 text-dark text-xs opacity-7" placeholder="Note" name="note">{{ $item->note }}</textarea>
                </div>

                <div class="mb-1 col-md-12">
                  <input type="file" name="img" class="from-control border p-2 text-dark text-xs opacity-7" style="font-size: 15px;">
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



<!-- Password users -->
<div class="modal fade" id="password{{ $item->kode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Password</h5>
            <a type="buttom" data-bs-toggle="modal" data-bs-target="#edit{{ $item->kode }}" data-bs-dismiss="modal" class="close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>

        <form action="/user/updatepassword/{{$item->kode}}" method="POST">
        @csrf            
        <div class="container">
            <div class="row">
                <div class="mb-4">
                    <label for="password" class="col-form-label font-label">Password Baru:</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="buttom" data-bs-toggle="modal" data-bs-target="#edit{{ $item->kode }}" data-bs-dismiss="modal" class="btn btn-danger">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>

    </div>
  </div>
</div>
<!-- end Password users -->
@endforeach
<script src="../assets/js/bootstrap.bundle.min.js"></script>

@endsection