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
            <h1 class="text-center mt-4">Laporan Data Pelanggan</h1>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped">
                        <thead>
                            <tr style="font-size: 11px">
                                <th>NO</th>
                                <th>Kode</th>
                                <th>NIK</th>
                                <th>Pelanggan</th>
                                <th>Telpn</th>
                                <th>Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($pelanggan as $item)
                            <tr>
                            <td class="col-auto">
                                <p class=" mb-0" style="font-size: 10px">{{ $no++ }}</p>
                            </td>
                            <td class="col-auto">
                                <p class=" mb-0" style="font-size: 10px">{{ $item->kode_pelanggan }}</p>
                            </td>

                            <td class="col-auto">
                                <p class=" mb-0" style="font-size: 10px">{{ $item->nik }}</p>
                            </td>

                            <td class="col-auto">
                                <p class="font-bold mb-0" style="font-size: 10px">{{$item->nama}}</p>
                            </td>

                                <td class="col-auto">
                                    <p class=" mb-0" style="font-size: 10px">{{$item->no_telpn}}</p>
                                </td>

                                <td class="col-auto">
                                <p class=" mb-0" style="font-size: 10px">{{ date('d M, Y', strtotime($item->created_at)) }}</p>
                                </td>

                                @if ($item->status == 'aktif')
                                <td class="col-auto">
                                <span class="text-success mb-0" style="font-size: 10px">Aktif</span>
                                </td>   
                                @elseif($item->status == 'nonaktif')
                                <td class="col-auto">
                                <span class="text-dark mb-0" style="font-size: 10px">NonAktif</span>
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
</body>
<script>
    window.print();
</script>
</html>