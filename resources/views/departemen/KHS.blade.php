@extends('departemen.layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
       <div class="grid grid-cols-1 gap-4 mb-4">

         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
           <p class="text-3xl font-bold text-gray-900 dark:text-white">Data KHS Mahasiswa</p>
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
                            Semester Aktif
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           SKS Semester
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           SKS Kumulatif
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           IP Semester
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           IP Kumulatif
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
                   @foreach($khs as $khs)
                       <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                           <td class="px-6 py-4">{{ $khs->NIM }}
                           <td class="px-6 py-4">{{ $khs->nama }}
                           <td class="px-6 py-4">{{ $khs->angkatan }}
                           <td class="px-6 py-4">{{ $khs->smt_aktif }}
                           <td class="px-6 py-4">{{ $khs->SKS_semester }}
                           <td class="px-6 py-4">{{ $khs->SKS_kumulatif }}
                           <td class="px-6 py-4">{{ $khs->IP_smt }}
                           <td class="px-6 py-4">{{ $khs->IP_kumulatif }}
                           <td class="px-6 py-4">{{ $khs->status_khs }}
                           <td class="px-6 py-4">{{ $khs->berkas_KHS }}
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
