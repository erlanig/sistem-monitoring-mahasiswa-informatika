@extends('departemen.layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
       <div class="grid grid-cols-1 gap-4 mb-4">

         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
           <p class="text-3xl font-bold text-gray-900 dark:text-white">Data Skripsi Mahasiswa</p>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
           <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                           Lama Studi
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           Tangal Sidang
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
                   @foreach($skripsi as $skripsi)
                       <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                           <td class="px-6 py-4">{{ $skripsi->NIM }}
                           <td class="px-6 py-4">{{ $skripsi->nama }}
                           <td class="px-6 py-4">{{ $skripsi->angkatan }}
                           <td class="px-6 py-4">{{ $skripsi->lama_studi }}
                           <td class="px-6 py-4">{{ $skripsi->tanggal_sidang }}
                           <td class="px-6 py-4">{{ $skripsi->status_skripsi }}
                           <td class="px-6 py-4">{{ $skripsi->berkas_skripsi }}
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