@extends('dosen.layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
        <p class="text-3xl font-bold text-gray-900 dark:text-white">Daftar Mahasiswa Perwalian</p>
        </div>
        <form action="{{ route('doswal.daftarmahasiswa') }}" method="GET" class="mb-4">
            <input type="text" name="search" placeholder="Search by Nama, NIM, Angkatan, Status, Alamat, Jalur Masuk, or Nama Kota" class="p-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Search</button>
        </form>
        <div class="flex items-center justify-center">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-s text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">NAMA</th>
                        <th scope="col" class="px-6 py-3">ANGKATAN</th>
                        <th scope="col" class="px-6 py-3">STATUS</th>
                        <th scope="col" class="px-6 py-3">JALUR MASUK</th>
                        <th scope="col" class="px-6 py-3">ALAMAT</th>
                        <th scope="col" class="px-6 py-3">KOTA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $mhs)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <td class="px-6 py-4">
                            <a href="{{ route('doswal.perwalian', ['nim' => $mhs->NIM]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $mhs->nama }}</a>
                        </td>
                        <td class="px-6 py-4">{{ $mhs->angkatan }}</td>
                        <td class="px-6 py-4">{{ $mhs->status }}</td>
                        <td class="px-6 py-4">{{ $mhs->jalur_masuk }}</td>
                        <td class="px-6 py-4">{{ $mhs->alamat }}</td>
                        <td class="px-6 py-4">{{ $mhs->nama_kota_kab }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex items-center justify-center rounded bg-gray-50 h-48 dark:bg-gray-800 relative col-span-2 row-span-4 mt-3">
        <table class="flex items-center justify-center">
                
        </table>
    </div>
</div>
@endsection