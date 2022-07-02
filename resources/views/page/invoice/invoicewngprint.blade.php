<!DOCTYPE html>
<html>
	<head>
		<link href="/assets2/css/sb-admin-2.min.css" rel="stylesheet">
		<meta charset="utf-8" />
		<title>Invoice WNG</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 14px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}


			.invoice-box table tr.top table td.title {
				font-size: 20px;
				line-height: 30px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading th {
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.heading1 td {
				border-bottom: 1px solid #ddd;
				border-top: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.heading2 td {
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>
	@foreach ($invoicewng as $item)
	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2">
						<table style="border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; padding-bottom: -100px;">
							<tr>
								<td class="title">
									<img src="/assets/img/invwng.png" style="width: 35%; max-width: 300px" />
								</td>

								<td>
									<h1 style=" text-transform:uppercase;">#{{ $item->id_invoice }}</h1>
								</td>
							</tr>			
						</table>
					</td>
				</tr>

				<tr>
					<td style="">
						@if ($item->status_inv == "Berlangganan")
						<h1 style="text-align: center; border: 2px solid rgb(35, 144, 194); padding: 10px;">SUDAH BAYAR</h1>
						@else
						<h1 style="text-align: center; border: 2px solid rgb(237, 33, 70); padding: 10px;">BELUM BAYAR</h1>
						@endif
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Kepada: {{ $item->nama }}.<br />
									Id Pelanggan: {{ $item->kode_pelanggan }}<br />
									{{ $item->alamat }}<br />
									{{$item->no_telpn}}
								</td>

								<td>
									Dari : <b>PT Wisuandha Network Globalindo</b>.<br />
									Jalan Mawar No.40 Delod Peken Tabanan, Bali -<br />
									Indonesia 82113<br />
									03617995406
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<table>
					
					@if ($item->status_inv == 'BelumBayar')
					<tr class="heading bg-danger text-white text-center">
						<th>Paket Layanan</th>
						<th>Tipe</th>
						<th>Deskripsi</th>
						<th>Sub total</th>
					</tr>
					@elseif($item->status_inv == 'Berlangganan')
					<tr class="heading bg-info text-white text-center">
						<th>Paket Layanan</th>
						<th>Tipe</th>
						<th>Deskripsi</th>
						<th>Sub total</th>
					</tr>
					@endif
					

					<tr class="details text-center">
						<td style="text-align: center; padding-top: 10px;">{{ $item->nama_paket }}</td>
						<td style="text-align: center; padding-top: 10px;">{{ $item->kategori }}</td>
						@if ($item->note == "")
						<td style="text-align: center; padding-top: 10px;">Tidak Ada Deskripsi</td>
						@else
						<td style="text-align: center; padding-top: 10px;">{{ $item->note }}</td>
						@endif
						<td style="text-align: center; padding-top: 10px;"> @currency($item->subtotal)</td>
					</tr>
				</table>

				<?php

				$tgl_end = $item->end_inv;

				$penagihan = strtotime("-14 days", strtotime($tgl_end));
				$convert = date('Y-m-d', $penagihan);

				$jatuhtempo = strtotime("+0 days", strtotime($item->end_inv));
				$set = date('Y-m-d', $jatuhtempo);
				?>              
                

				<table>
					<tr class="heading1">
						<td style="padding-bottom: 12px; padding-top: 5px;">Dibayar Pada</td>
						<td style="padding-bottom: 12px; padding-top: 5px;">{{ date('d M, Y', strtotime($item->start_inv)) }}</td>
					</tr>
				</table>

				<table>
					<tr class="heading2">
						<td style="padding-bottom: 12px; padding-top: 5px;">Penagihan Selanjutnya</td>
						<td style="padding-bottom: 12px; padding-top: 5px;">{{ date('d M, Y', strtotime($convert)) }}</td>
					</tr>
				</table>

				<table>
					<tr class="heading2">
						<td style="padding-bottom: 12px; padding-top: 5px;">Jatuh Tempo</td>
						<td style="padding-bottom: 12px; padding-top: 5px;">{{ date('d M, Y', strtotime($set)) }}</td>
					</tr>
				</table>

				<table>
					<tr class="heading2">
						<td style="padding-bottom: 12px; padding-top: 5px;">Sub total</td>
						<td style="padding-bottom: 12px; padding-top: 5px;">@currency($item->subtotal)</td>
					</tr>
				</table>

				<table>
					<tr class="heading2">
						<td style="padding-bottom: 12px; padding-top: 5px;">PPN</td>
						<td style="padding-bottom: 12px; padding-top: 5px;">@currency($item->pajak)</td>
					</tr>
				</table>


				<table>
					<tr class="heading2">
						<td style="padding-bottom: 12px; padding-top: 5px;">Total</td>
						@if($item->total == '')
						<td style="padding-bottom: 12px; padding-top: 5px;">@currency($item->subtotal * $item->berlangganan)</td>
						@else
						<td style="padding-bottom: 12px; padding-top: 5px;">@currency($item->total)</td>
						@endif
					</tr>
				</table>

			</table>

			<ul style="line-height: 25px;">
				@if ($item->status_inv == "Berlangganan")
				<li style=" width: 95%;"><p style="font-size: 12px;">Terima kasih sudah melunasi tagihan anda, data tagihan anda sudah diperbaharui dan masa aktif layanan anda sudah diperpanjang</p></li>
				@else
				<li style=" width: 95%;"><p style="font-size: 12px;">Silahkan segera melunasi tagihan anda, untuk menghindari penangguhan layanan yang dapat mengganggu layanan anda</p></li>
				@endif
				<li style=""><p style="font-size: 12px;">Jika informasi pada bukti pembayaran ini ada kesalahan, silahkan hubungi kami</p></li>
				<tr>
					<td>
						<b><p style="font-size: 12px;">PT Wisuandha Network Globalindo<br />
						Jalan Mawar No.40 Delod Peken Tabanan, Bali - Indonesia 82113<br />
						03617995406</p></b>
					</td>
				</tr>
			</ul>

			<p style="text-align: center; border-top: 1px solid #ddd; padding-top: 10px; font-size: 12px;">Tanda Terima Pembayaran Sah Dari PT Wisuandha Network Globalindo</p>
		</div>

		{{-- <button onclick="window.print()" class="btn btn-primary btn-sm">Print</button> --}}
	</body>	
	@endforeach
	<script>
        window.print();
    </script>
</html>
