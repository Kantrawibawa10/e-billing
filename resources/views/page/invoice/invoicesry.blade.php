<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Surya Candra</title>
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
    <style>

        body{
background:#fff;
margin-top: 50px;
}
.text-danger strong {
        	color: #9f181c;
		}
		.receipt-main {
			background: #ffffff none repeat scroll 0 0;
			margin-top: 50px;
			margin-bottom: 50px;
			padding: 40px 30px !important;
			position: relative;
			box-shadow: 0 1px 21px #acacac;
		}
		.receipt-main p {
			line-height: 1.42857;
		}
		.receipt-footer h1 {
			font-size: 15px;
			font-weight: 400 !important;
			margin: 0 !important;
		}
		.receipt-main::after {
			content: "";
			height: 5px;
			left: 0;
			position: absolute;
			right: 0;
			top: -13px;
		}
		.receipt-main thead {
			background: #d6d6d6 none repeat scroll 0 0;
		}
		.receipt-main thead th {
			color:#000;
		}
		.receipt-right h5 {
			font-size: 16px;
			font-weight: bold;
			margin: 0 0 7px 0;
		}
		.receipt-right p {
			font-size: 12px;
			margin: 0px;
		}
		.receipt-right p i {
			text-align: center;
			width: 18px;
		}
		.receipt-main td {
			padding: 9px 20px !important;
		}
		.receipt-main th {
			padding: 13px 20px !important;
		}
		.receipt-main td {
			font-size: 13px;
			font-weight: initial !important;
		}
		.receipt-main td p:last-child {
			margin: 0;
			padding: 0;
		}	
		.receipt-main td h2 {
			font-size: 20px;
			font-weight: 900;
			margin: 0;
			text-transform: uppercase;
		}
		.receipt-header-mid .receipt-left h1 {
			font-weight: 100;
			margin: 34px 0 0;
			text-align: right;
			text-transform: uppercase;
		}
		.receipt-header-mid {
			margin: 24px 0;
			overflow: hidden;
		}
		
		#container {
			background-color: #fff;
		}
    </style>
    <div class="col-md-12">   
        <div class="row">
               
               <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3 m-auto">
                
                @foreach ($invoicesry as $item)
                @if ($item->status_inv == "Berlangganan")
                <div style="position: absolute">
                 <img src="../assets/img/lunas.png" class="img-fluid" width="300" alt="">
                </div>
                @else
                    
                @endif
                @endforeach
                   <div class="d-flex justify-content-between">
                       <div class="col-md-6 mb-5">
                        <img src="../assets/img/logo-inv1.png" alt="" class="img-fluid" style="max-width: 300px">
                       </div>    
                       
                        

                        <div class="col-md-5 mb-5 text-end">
                            <h1 class="text-end text-secondary" style="font-weight: 700;">INVOICE</h1>
                            <p class="text-start px-1 text-dark" style="background: #d6d6d6 none repeat scroll 0 0; border: 1px solid black; font-weight: 800;">Date : <?php echo date('d M Y'); ?></p>
                            @foreach ($invoicesry as $item)
                            <p class="text-start">{{ $item->nama }} | <span style="text-transform: uppercase">{{ $item->id_invoice }}</span></p>
                            @endforeach
                        </div>
                   </div>
                   
                   
                   <div>
                       <table class="table table-bordered">
                           <thead>
                               <tr>
                                   <th>DESCRIPTION</th>
                                   <th>UNIT PRICE</th>
                                   <th>AMOUNT</th>
                               </tr>
                           </thead>
                           @foreach ($invoicesry as $item)
                           <tbody>
                               <tr>
                                   <td class="text-right">
                                   <p class="text-dark" style="font-size: 14px;">
                                       {{ $item->nama_paket }}({{ date('d/m/Y', strtotime($item->start_inv)) }} - {{ date('d/m/Y', strtotime($item->end_inv)) }})
                                   </p>
                                   </td>

                                   <td>
                                    <p>
                                        <strong>@currency($item->harga)</strong>
                                    </p>
                                   </td>

                                   <td>
                                   <p>
                                       <strong>@currency($item->subtotal)</strong>
                                   </p>
                                   </td>
                               </tr>
                               <tr>
                                   <td></td>
                                   <td class="text-right"><h4><strong>Total: </strong></h4></td>
                                   @if($item->total == '')
                                   <td class="text-left text-danger"><h4><strong>@currency($item->subtotal * $item->berlangganan)</strong></h4></td>
                                   @else
                                   <td class="text-left text-danger"><h4><strong>@currency($item->total)</strong></h4></td>
                                   @endif
                               </tr>
                           </tbody>
                           @endforeach
                       </table>
                   </div>

                   <h4>Pembayaran melalui transfer pada rekening berikut</h4>
                   
                   
                    <div class="row">
                        <div class="receipt-header receipt-header-mid receipt-footer">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                                <div class="receipt-right">
                                     <div class="d-flex text-dark"><p style="width: 200px; font-size: 15px;"><b>BCA 0402716671 :</b></p> <p style="font-size: 15px;">OSEL FUROSI</div>
                                     <div class="d-flex text-dark"><p style="width: 200px; font-size: 15px;"><b>BNI 0772408216 :</b></p> <p style="font-size: 15px;">OSEL FUROSI</p></div>
                                     <div class="d-flex text-dark"><p style="width: 200px; font-size: 15px;"><b>BRI 463501003666539 :</b></p> <p style="font-size: 15px;">NI MADE SURYANI</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                   
               </div>    
           </div>
       </div>
</body>

</html>