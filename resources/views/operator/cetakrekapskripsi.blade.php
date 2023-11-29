<!DOCTYPE html>
<html>
<head>
	<title>Rekap Data Skripsi Informatika Undip</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
</head>
<body>
    <style type="text/css">
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table tr td,
        table tr th {
            font-size: 12pt;
            border: 1px solid #000;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            height: 80px;
        }
        .header h5 {
            margin-top: 10px;
        }
        .university-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .university-info img {
            width: 80px;
            height: 80px;
        }
    </style>
	<div class="university-info">
        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgYujZbyh4_SknyY77m81bEOMtH6TtlAzyT42r9uIZERBhwtbgahT655BwbXp0TnH-YH8nNrChsAhAxseV8qpszeH2HfDbRCVGeK5zbJh3nOB5tFvf5adWVzk4vsX8tdzW_KPxw_BVK28-m9qY82ilvI2SN7n9Id7Yh_mdfJFxJUlTIchZflfZxtw/s1740/Undip%20Logo.png" alt="Logo" class="w-16 h-16">
        <h4>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</h4>
        <h4>DEPARTEMEN INFORMATIKA</h4>
        <h4>FAKULTAS SAINS DAN MATEMATIKA</h4>
        <h4>UNIVERSITAS DIPONEGORO</h4>
    </div>
    <div class="header">
        <h5 class="mt-4 font-bold">Rekap Data Skripsi Informatika Undip</h5>
    </div>
	<table class="mt-4">
		<thead>
			<tr>
				<th class="p-2">No</th>
				<th class="p-2">NIM</th>
				<th class="p-2">Nama</th>
				<th class="p-2">Angkatan</th>
				<th class="p-2">Status</th>
				<th class="p-2">Nilai</th>
                <th class="p-2">Tanggal Sidang</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($skripsi as $s)
			<tr>
				<td class="p-2">{{ $i++ }}</td>
				<td class="p-2">{{$s->NIM}}</td>
				<td class="p-2">{{$s->nama}}</td>
				<td class="p-2">{{$s->angkatan}}</td>
                <td class="p-2">{{$s->status_skripsi }}</td>
				<td class="p-2">{{$s->nilai_skripsi}}</td>
				<td class="p-2">{{$s->tanggal_sidang}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
