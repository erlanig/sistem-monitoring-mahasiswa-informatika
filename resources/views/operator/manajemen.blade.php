@extends('operator.layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
       <div class="grid grid-cols-1 gap-4 mb-4">

         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
           <p class="text-3xl font-bold text-gray-900 dark:text-white">Manajemen Akun Mahasiswa</p>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
           <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                   <tr>
                       <th scope="col" class="px-6 py-5 text-sm">
                           NIM
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           Nama
                       </th>
                       <th scope="col" class="px-6 py-5 text-sm">
                           Tindakan
                       </th>
                   </tr>
               </thead>
               <tbody>
                   @foreach($mahasiswa as $mahasiswa)
                       <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                           <td class="px-6 py-4">{{ $mahasiswa->NIM }}
                           <td class="px-6 py-4">{{ $mahasiswa->Nama }}
                           <td class="flex items-center px-6 py-4 space-x-3">
                             <button class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Reset</button>
                           </td>
                       </tr>
                  @endforeach
               </tbody>
           </table>
        </div>
        @php
           $mahasiswaCount = \App\Models\Mahasiswa::count();
       @endphp
           <p class="d-flex justify-content-end">Total Mahasiswa : {{$mahasiswaCount}}</p>
       </div>
    </div>
 </div>
@endsection
