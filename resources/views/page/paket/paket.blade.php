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
    <h3>Halaman Data Paket</h3>
    <p>Berisi Data Pake yang di Jual {{ auth()->user()->level }}</p>
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
                          <h6 class="text-muted font-semibold">Paket Tersedia</h6>
                          <h6 class="font-extrabold mb-0">{{ $paket->count() }}</h6>
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
        <form class="row from" action="{{ url("/paket/search") }}" method="get" >
          <div>
            <h4>Search</h4>
          </div> 

          <div class="input-group input--medium">
            <label class="label">Kode</label>
            <input class="input--style-1" type="text" name="kode" placeholder="Kode Paket" id="input-start" value="{{Request::get('kode')}}">
          </div>    

          <div class="input-group input--large">
            <label class="label">Paket</label>
            <input class="input--style-1" type="text" placeholder="Nama Paket" name="nama_paket" value="{{Request::get('nama_paket')}}">
          </div>        

          <div class="input-group input--medium">
            <label class="label">Status</label>
            <select name="value" id="input-start" class="input--style-1" type="text" value="{{Request::get('value')}}" style="border: none;">
              <option value="" selected disabled>Pilis Status</option>
              <option value="">Semua</option>
              <option value="true">Aktif</option>
              <option value="false">NonAktif</option>
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
        <strong>{{ auth()->user()->username }}</strong> {{ session()->get('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif 

      @if(session()->get('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ auth()->user()->username }}</strong> {{ session()->get('error') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <!--END SESSION ALERT-->
      
      <div class="card">
          <div class="card-header row justify-content-between">
              <div class="d-flex col-md-9">
                <h4>Daftar Paket</h4>              
              </div>

          <div class="d-flex col-md-3 justify-content-end">
	    <div>
              <div class="btn-group btn-group-md mx-2">
                <a class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="refresh" href="">
                  <i class="bi bi-arrow-clockwise"></i>
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
         
          <div class="card-body">
              <div class="table-responsive">
                  <table id="example" class="table table-striped">
                      <thead>
                          <tr style="font-size: 13px">
                              <th>NO</th>
                              <th>Kode</th>
                              <th>Paket</th>
                              <th>Harga</th>
                              <th>Dibuat</th>
                              <th>Status</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php $no = 1; @endphp
                          @foreach ($paket as $item)
                          <tr>
                            <td class="col-auto">
                              <p class=" mb-0" style="font-size: 12px">{{ $no++ }}</p>
                            </td>

                            <td class="col-auto">
                              <p class=" mb-0" style="font-size: 12px">{{ $item->kode }}</p>
                            </td>

                            <td class="col-auto">
                              <p class=" mb-0" style="font-size: 12px">{{$item->nama_paket}}</p>
                            </td>

                              <td class="col-auto">
                                <p class=" mb-0" style="font-size: 12px">@currency($item->harga_paket)</p>
                              </td>

                              <td class="col-auto">
                                <p class=" mb-0" style="font-size: 12px">{{ date('Y-m-d', strtotime($item->created_at)) }}</p>
                              </td>

                              @if ($item->value == 'true')
                              <td class="col-auto">
                                <span class="badge bg-success mb-0" style="font-size: 12px">Tersedia</span>
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
                                      <a type="buttom" data-bs-toggle="modal" data-bs-target="#edit{{ $item->kode }}" class="btn btn-primary" style="font-size: 10px">
                                        <i class="bi bi-pencil-fill"></i>
                                      </a>
                                    </div>
                                  </div>
            
                                  <!-- <div>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                      <a type="buttom" data-bs-toggle="modal" data-bs-target="#hapus{{ $item->kode }}" class="btn btn-danger" style="font-size: 10px">
                                        <i class="bi bi-trash"></i>
                                      </a>
                                    </div>                
                                  </div> -->
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
            <h5 class="modal-title" id="staticBackdropLabel">Add Paket</h5>
            <a type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>
        <form action="{{ route('addpaket') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">  
                
                <div class="mb-1 col-md-12">
                  <label for="paket" class="col-form-label font-label text-secondary text-xs opacity-7">Kode Paket:</label>
                  <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="kode" value="{{ $kode_paket }}" readonly>
                </div>

                <div class="mb-0">
                  <h4>Required</h4>
                  <hr>
                </div>

                <div class="row">
                  <div class="mb-1 col-md-8">
                    <label for="paket" class="col-form-label font-label text-secondary text-xs opacity-7">Paket:</label>
                    <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="paket" name="nama_paket" required placeholder="Nama Paket">
                  </div>

                  <div class="mb-1 col-md-4">
                    <label for="kategori" class="col-form-label font-label text-secondary text-xs opacity-7">Kategori:</label>
                    <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="kategori" name="kategori" placeholder="Kategori Paket">
                  </div>
                </div>
                
                <div class="row">
                  <div class="mb-1 col-md-5">
                    <label for="harga" class="col-form-label font-label text-secondary text-xs opacity-7">Nominal:</label>
                    <input name="harga_paket" id="number" onkeypress="return hanyaAngka(event)" type="number" class="form-control text-dark" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Harga..." autocomplete="off" >
                  </div>

                  <div class="mb-1 col-md-5">
                    <label for="harga" class="col-form-label font-label text-secondary text-xs opacity-7">Total Pajak:</label>
                    <input name="nilai_pajak" id="pajak" onkeypress="return hanyaAngka(event)" type="number" class="form-control text-dark" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Pajak..." autocomplete="off">
                  </div>
                               
                  <div class="col-md-2 d-flex justify-content-start">
                    <div class="form-check mx-2">
                      <input class="form-check-input mt-5"  type="checkbox"  onclick="myFunction()" id="checkbox">  
                      <label class="form-check-label mt-4 pt-4" for="flexCheckDefault">
                        Pajak
                      </label>
                    </div>                      
                  </div>   
                </div>

                <div class="mb-1">
                  <label for="harga" class="col-form-label font-label text-secondary text-xs opacity-7">Total:</label>
                  <input name="total" id="total" onkeypress="return hanyaAngka(event)" type="number" class="form-control text-dark" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Harga + pajak" autocomplete="off" >
                </div>

                

                <div class="row d-none">
                  <div class="mb-1 col-md-6">
                      <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
                      <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="created_at" name="created_at" required value="<?php  echo date('Y-m-d'); ?>">
                  </div>

                  <div class="mb-1 col-md-6">
                    <label for="lama_paket" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
                    <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" id="updated_at" name="updated_at" value="<?php  echo date('Y-m-d'); ?>">
                  </div>
                </div>


                <div class="mb-0 mt-4">
                  <h4>Opsional</h4>
                  <hr>
                </div>

                <div id="tampil"></div>

                <div class="row">
                  <div class="mb-1 col-md-12">
                    <label for="deskripsi" class="col-form-label font-label text-secondary text-xs opacity-7">Deskripsi:</label>
                    <textarea class="form-control border p-2 text-dark text-xs opacity-7" placeholder="Note" name="deskripsi"></textarea>
                  </div>

                  {{-- <div class="mb-1 col-md-12">
                    <input type="file" name="file" class="from-control border p-2 text-dark text-xs opacity-7" style="font-size: 15px;">
                  </div> --}}
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

@foreach ($paket as $item)
<!-- Modal -->
<div class="modal fade" id="edit{{ $item->kode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Edit Paket</h5>
            <a type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close"><i class="bi bi-x-circle-fill text-danger" style="font-size: 20px"></i></a>
        </div>
        <form action="/paket/update/{{ $item->kode }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">  
              <div class="mb-1 col-md-12">
                <label for="paket" class="col-form-label font-label text-secondary text-xs opacity-7">Kode Paket:</label>
                <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" name="kode" value="{{ $item->kode }}" readonly>
              </div>

              <div class="mb-0">
                <h4>Required</h4>
                <hr>
              </div>

              <div class="row">
                <div class="mb-1 col-md-8">
                  <label for="paket" class="col-form-label font-label text-secondary text-xs opacity-7">Paket:</label>
                  <input type="text" class="form-control border p-2 text-dark text-xs opacity-7" id="paket" name="nama_paket" required placeholder="Nama Paket" value="{{ $item->nama_paket }}">
                </div>

                <div class="mb-1 col-md-4">
                  <label for="kategori" class="col-form-label font-label text-secondary text-xs opacity-7">Kategori:</label>
                  <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="kategori" name="kategori" required placeholder="Kategori Paket" value="{{ $item->kategori }}">
                </div>
              </div>
              
              <div class="row">
                
                <div class="mb-1 col-md-6">
                  <label for="harga" class="col-form-label font-label text-secondary text-xs opacity-7">Nominal:</label>
                  <input name="harga_paket" id="number1" onkeypress="return hanyaAngka(event)" type="number" class="form-control text-dark" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Harga..." autocomplete="off" value="{{ $item->harga_paket }}" readonly>
                  {{-- <input type="hidden" name="harga_paket" value="{{ $item->harga_paket }}"> --}}
                  <p>Harga: @currency($item->harga_paket)</p>
                </div>

                <div class="mb-1 col-md-6">
                  <label for="harga" class="col-form-label font-label text-secondary text-xs opacity-7">Total Pajak:</label>
                  <input name="nilai_pajak" id="pajak1" onkeypress="return hanyaAngka(event)" type="number" class="form-control text-dark" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Pajak..." autocomplete="off" value="{{ $item->nilai_pajak }}" readonly>
                  {{-- <input type="hidden" name="nilai_pajak" value="{{ $item->nilai_pajak }}"> --}}
                  <p>Pajak: @currency($item->nilai_pajak)</p>
                </div>
                             
                <!-- <div class="col-md-2 d-flex justify-content-start">
                  <div class="form-check mx-2">
                    <input class="form-check-input mt-5"  type="checkbox"  onclick="myFunction1()" id="checkbox1">  
                    <label class="form-check-label mt-4 pt-4" for="flexCheckDefault">
                      Pajak
                    </label>
                  </div>                      
                </div>    -->
              </div>

              <div class="row d-none">
                <div class="mb-1 col-md-6">
                    <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Start:</label>
                    <input type="date" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" id="created_at" name="created_at" required value="<?php  echo date('Y-m-d'); ?>">
                </div>

                <div class="mb-1 col-md-6">
                  <label for="lama_paket" class="col-form-label font-label text-secondary text-xs opacity-7">End:</label>
                  <input type="date" class="form-control border p-2 text-dark text-xs opacity-7" id="updated_at" name="updated_at" value="<?php  echo date('Y-m-d'); ?>">
                </div>
              </div>


              <div class="mb-1">
                <label for="created_at" class="col-form-label font-label text-secondary text-xs opacity-7">Harga Akhir:</label>
                @if($item->total == "")
                <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" readonly value="@currency($item->harga_paket)">
                @else
                <input type="text" class="form-control border p-2 text-capitalize text-dark text-xs opacity-7" readonly value="@currency($item->total)">
                @endif
              </div>

              <div class="mb-0 mt-4">
                <h4>Opsional</h4>
                <hr>
              </div>

              <div class="row">
                <div class="mb-1 col-md-12">
                  <label for="deskripsi" class="col-form-label font-label text-secondary text-xs opacity-7">Deskripsi:</label>
                  <textarea class="form-control border p-2 text-dark text-xs opacity-7" placeholder="Note" name="deskripsi">{{ $item->deskripsi }}</textarea>
                </div>

                {{-- <div class="mb-1 col-md-12">
                  <input type="file" name="file" class="from-control border p-2 text-dark text-xs opacity-7" style="font-size: 15px;">
                </div> --}}
              </div>       
              
              <div class=" row col-md-6">
                <label for="status" class="col-form-label font-label text-secondary text-xs opacity-7">Status:</label>

                <div class="col-md-4 mx-1">
                  
                  @if ($item->value == 'true')
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="radio" name="value" id="exampleRadios1" value="{{ $item->value }}" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      Tersedia
                    </label>
                  </div>
                  @else
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="radio" name="value" id="exampleRadios1" value="true">
                    <label class="form-check-label" for="exampleRadios1">
                      Tersedia
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
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
  </div>
</div>  



<!-- Modal -->
<div class="modal fade" id="hapus{{ $item->kode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-center">Yakin Ingin Menghapus Paket Ini?</p>
      </div>
      <div class="modal-footer">
        <a href="/paket/deleted/{{ $item->kode }}" class="btn btn-danger btn-sm">Hapus</a>
      </div>
    </div>
  </div>
</div>
@endforeach









<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="../js/jquery-3.5.1.min.js"></script>
<script>
  function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))

      return false;
    return true;
  }
</script>


<script>
  function myFunction() {
    let checkBox = document.getElementById("checkbox");
    let text = document.getElementById("number");

    if (checkBox.checked == true){
      let d1;
      let d2;
      let d3;
      let d4;
      d1 = parseFloat($('#number').val());
      d3 = Math.round(d1 * 0.11);
      d4 = d3 + d1;
      // d3 = d1 * 0.11 + d1 ;
      // text.value = d3;
        
      let total = Math.ceil(d4);
      let pajak = Math.ceil(d3);
      $('#pajak').val(pajak);
      $('#total').val(total);

    } else {
      $('#pajak').val('');
      $('#total').val('');
    }
  }
</script>

<!-- <script>
  function myFunction1() {
    let checkBox = document.getElementById("checkbox1");
    let text = document.getElementById("number1");

    if (checkBox.checked == true){
      let d1;
      let d2;
      let d3;
      d1 = parseFloat($('#number1').val());
      d3 = d1 * 0.11;
      // d3 = d1 * 0.11 + d1 ;
      // text.value = d3;
        
      let output = Math.ceil(d3);
      $('#pajak1').val(output);

    } else {
      $('#pajak1').val('');
    }
  }
</script> -->

<script>
  $(document).ready(function(){
      $('#example').DataTable({
          info: false,
          retrieve: true,
          searching: false,
      });
  });
</script>

@endsection