<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <link rel="stylesheet" href="../assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/search.css">
    <link rel="shortcut icon" href="../assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="mt-5">
        <div class="card">
            <h1 class="text-center mt-4">Laporan Transaksi</h1>
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
                          </tr>
                        </thead>
    
                        <tbody>
                          @php $no = 1; @endphp
                          @foreach ($register as $item)
                            {{-- Start Kondisi Sudah Bayar --}}
        
                            
        
                            @if(Request::get('value') == "Perpanjang")
        
        
                       
                              @if(date('Y-m-d', strtotime("-7 day", strtotime($item->end_reg))) <= date('Y-m-d'))
                              {{-- @if(date('Y-m-d', strtotime("-7 day", strtotime($item->end_reg))) >= date('Y-m-d')) --}}
        
        
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
                                <p class=" mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->start_reg)) }}</p>
                              </td>
        
                              
                              {{-- status masa aktif paket --}}                            
                              @if($item->end_reg < date("Y-m-d"))
                              <td class="col-auto">
                                <span class="text-danger mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->end_reg)) }}</span>
                              </td>   
                              @elseif(date('Y-m-d', strtotime("-7 day", strtotime($item->end_reg))) <= date('Y-m-d')) 
                              <td class="col-auto">
                                <span class="text-warning mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->end_reg)) }}</span>
                              </td>          
                              @elseif($item->end_reg  == date('Y-m-d'))
                              <td class="col-auto">
                                <span class="text-success mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->end_reg)) }}</span>
                              </td> 
                              @endif                                
                              {{-- status masa aktif paket --}}

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
                                <p class=" mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->start_reg)) }}</p>
                                @endif
                              </td>
        
        
        
                              {{-- status masa aktif paket --}}                            
                              <td class="col-auto">
                                @if ($item->start_reg == '')
                                <p class=" mb-0" style="font-size: 12px">Bayar</p>
                                @else    
                                <span class="text-dark mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->start_reg)) }}</span>
                                @endif
                              </td>                             
                              {{-- status masa aktif paket --}}
        
      
                            </tr>
                            {{-- End Kondisi Belum Bayar --}}
                            @endif
                            
        
                              @endif
        
                            @else
                              
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
                                <p class=" mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->start_reg)) }}</p>
                              </td>
        
        
                              
                              {{-- status masa aktif paket --}}                            
                              @if($item->end_reg < date("Y-m-d"))
                              <td class="col-auto">
                                <span class="text-danger mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->end_reg)) }}</span>
                              </td>   
                              @elseif(date('Y-m-d', strtotime("-7 day", strtotime($item->end_reg))) <= date('Y-m-d')) 
                              <td class="col-auto">
                                <span class="text-warning mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->end_reg)) }}</span>
                              </td>          
                              @elseif($item->start_reg <= $item->end_reg  == date('Y-m-d'))
                              <td class="col-auto">
                                <span class="text-success mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->end_reg)) }}</span>
                              </td> 
                              @endif                                
                              {{-- status masa aktif paket --}}
        
                              {{-- <td><span>{{ date('Y-m-d', strtotime("-7 day", strtotime($item->end_reg))) }}</span></td> --}}
        
      
                            </tr>
                            {{-- End Kondisi Sudah Bayar --}}
        
        
        
        
        
        
        
        
        
        
        
        
                            @elseif($item->status_reg == 'BelumBayar')
                            {{-- Start Kondisi Belum Bayar --}}
                            <tr>
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
                                <p class=" mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->start_reg)) }}</p>
                                @endif
                              </td>
        
        
        
                              {{-- status masa aktif paket --}}                            
                              <td class="col-auto">
                                @if ($item->start_reg == '')
                                <p class=" mb-0" style="font-size: 12px">Bayar</p>
                                @else    
                                <span class="text-dark mb-0" style="font-size: 12px">{{ date('d M, Y', strtotime($item->start_reg)) }}</span>
                                @endif
                              </td>                             
                              {{-- status masa aktif paket --}}
        
      
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
</body>
<script>
  window.print();
</script>

<script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
{{-- <script src="../assets/js/bootstrap.bundle.min.js"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="../assets/vendors/apexcharts/apexcharts.js"></script>
<script src="../assets/js/pages/dashboard.js"></script>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/moment.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</html>