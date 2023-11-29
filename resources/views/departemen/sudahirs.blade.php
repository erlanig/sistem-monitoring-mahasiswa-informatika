@extends('departemen.layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
       <div class="grid grid-cols-1 gap-4 mb-4">

         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
           <p class="text-3xl font-bold text-gray-900 dark:text-white">Data Sudah IRS Mahasiswa</p>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
           <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-center">
                   <tr>
                       <th scope="col" class="px-6 py-5 text-sm">
                           NIM
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           Nama Mahasiswa
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           Angkatan
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                            Semester Aktif
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           Jumlah SKS
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           Status
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           Berkas
                       </th>
                   </tr>
               </thead>
               <tbody>
                   @foreach($irs as $irs)
                       <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                           <td class="px-6 py-4">{{ $irs->NIM }}</td>
                           <td class="px-6 py-4">{{ $irs->nama }}</td>
                           <td class="px-6 py-4">{{ $irs->angkatan }}</td>
                           <td class="px-6 py-4">{{ $irs->smst_aktif }}</td>
                           <td class="px-6 py-4">{{ $irs->jumlah_sks }}</td>
                           <td class="px-6 py-4">{{ $irs->status_irs }}</td>
                           <td class="px-6 py-4">{{ $irs->berkas_irs }}</td>
                       </tr>
                  @endforeach
               </tbody>
           </table>
        </div>
        @php
           $mahasiswaCount = \App\Models\Mahasiswa::count();
       @endphp
           {{-- <p class="d-flex justify-content-end">Total Mahasiswa : {{$mahasiswaCount}}</p> --}}
       </div>
    </div>
 </div>
@endsection
