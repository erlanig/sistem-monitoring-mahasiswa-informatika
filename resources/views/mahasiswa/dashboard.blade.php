@extends('mahasiswa.layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-8">
    <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
       <p class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Mahasiswa</p>
    </div>
    <div class="flex items-center justify-center">
        @if (session('errors'))
            <div class="text-center p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 w-full">
                {{ session('errors') }}
            </div>
        @endif
    </div>
    <div class="grid grid-cols-3 gap-4 mb-4">
         <div class="flex items-center justify-center h-80 rounded bg-gray-50 dark:bg-gray-800">
         <p class="text-xl font-semibold text-gray-900 dark:text-white">
         <div class="text-gray-900 dark:text-white text-center">
         <img class="mx-auto w-48 h-48 rounded-full border border-gray-800" src="{{ asset('fotoProfil/'.$mahasiswa->foto) }}" alt="Foto Pengguna">
         <div class="text-xl font-semibold">{{ $mahasiswa->nama }}</div>
            <p class="text-l font-semibold">{{$mahasiswa->NIM}}</p>
            <p class="text-s">{{$mahasiswa->email}}</p>
            <p class="text-s">S1-Informatika <a class="font-semibold">({{$mahasiswa->fakultas}})</a></p>
        </div>
         </div>
        <div class="flex items-center justify-center h-80 rounded bg-gray-50 dark:bg-gray-800 col-span-2 row-span-4">
            <table>
                <tr>
                    <td class="text-left font-semibold">Nama Dosen Wali</td>
                    <td class="px-4"> : </td>
                    <td  class="text-left font-semibold">{{ $mahasiswa->nama_doswal }}</td>
                </tr>
                <tr>
                    <td class="text-left font-semibold">NIP Dosen Wali</td>
                    <td class="px-4"> : </td>
                    <td  class="text-left font-semibold">{{ $mahasiswa->nip }}</td>
                </tr>
                <tr class="mt-3 mb-4">
                    <td class="text-left font-semibold">Semester Terakhir Upload</td>
                    <td class="px-4"> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->semaktif }}</td>
                </tr>
                <tr class="mt-3">
                    <td class="text-left font-semibold">Angkatan</td>
                    <td class="px-4"> : </td>
                    <td  class="text-left font-semibold"> {{ $mahasiswa->angkatan }}</td>
                </tr>
            </table>
        </div>
      </div>
      <div class="grid grid-cols-4 gap-4 mb-4">
      <div class="flex items-center justify-center rounded bg-gray-50 h-72 dark:bg-gray-800 relative">
        <div class="text-xl font-semibold text-center absolute top-2 left-0 right-0 mt-0">IRS</div>
            <div class="mx-auto mt-3">
                <table>
                    <tr>
                        <td>SKS Terakhir Upload</td>
                        <td class="px-1"> : </td>
                        <td class="text-left font-semibold">{{ $mahasiswa->sks }} SKS</td>
                    </tr>
                    <tr>
                        <td>Semester Terakhir Upload</td>
                        <td class="px-1"> : </td>
                        <td class="text-left font-semibold">{{ $mahasiswa->semaktif }}</td>
                    </tr>
                </table>
            </div>
        </div>

      <div class="flex items-center justify-center rounded bg-gray-50 h-72 dark:bg-gray-800 relative">
        <div class="text-xl font-semibold text-center absolute top-2 left-0 right-0 mt-0">KHS</div>
        <table class="flex items-center justify-center">
            <tr class="mx-auto mt-3">
                    <td>SKS Semester</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->skssem }} SKS</td>
            </tr>
            <tr class="mt-3">
                    <td>IP Semester</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->ipsem }}</td>
            </tr>
            <tr class="mt-3">
                    <td>SKS Kumulatif</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->skskum }} SKS</td>
            </tr>
            <tr class="mt-3">
                    <td>IPK Kumulatif</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->ipk }}</td>
            </tr>
            <tr class="mt-3">
                <td>Semester Terakhir Upload</td>
                <td class="px-1 "> : </td>
                <td class="text-left font-semibold"> {{ $mahasiswa->smtKHS }}</td>
            </tr>
        </table>
    </div>
      <div class="flex items-center justify-center rounded bg-gray-50 h-72 dark:bg-gray-800 relative">
        <div class="text-xl font-semibold text-center absolute top-2 left-0 right-0 mt-0">PKL</div>
        <table class="flex items-center justify-center">
            <tr class="mt-3">
                    <td>Status PKL</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->statuspkl }}</td>
            </tr>
            <tr class="mt-3">
                    <td>Nilai PKL</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->nilaipkl }}</td>
            </tr>
        </table>
    </div>
      <div class="flex items-center justify-center rounded bg-gray-50 h-72 dark:bg-gray-800 relative">
        <div class="text-xl font-semibold text-center absolute top-2 left-0 right-0 mt-0">Skripsi</div>
        <table class="flex items-center justify-center">
            <tr class="mt-3">
                    <td>Status Skripsi</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->statusskripsi }}</td>
            </tr>
            <tr class="mt-3">
                    <td>Nilai Skripsi</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->nilaiskripsi }}</td>
            </tr>
            <tr class="mt-3">
                    <td>Lama Studi</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->lamastudi }}</td>
            </tr>
            <tr class="mt-3">
                    <td>Tanggal Sidang</td>
                    <td class="px-1 "> : </td>
                    <td class="text-left font-semibold"> {{ $mahasiswa->tglsidang }}</td>
            </tr>
        </table>
        <p class="text-2xl text-gray-400 dark:text-gray-500"></p>
    </div>
      </div>
   </div>
</div>
@endsection


