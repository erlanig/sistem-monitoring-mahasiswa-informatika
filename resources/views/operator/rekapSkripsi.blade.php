@extends('operator.layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Data Rekap Skripsi Mahasiswa</p>
            </div>
            <div>
                <a href="{{ route('operator.cetakrekapskripsi') }}" class="text-white bg-blue-500 hover:bg-blue-600 font-medium text-base text-center py-2 px-4 rounded-full" target="_blank">Cetak Rekap</a>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-5">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                        <th scope="col" class="px-6 py-5 text-xl" colspan="{{ $jumlahAngkatan * 2 }}">
                            ANGKATAN
                        </th>
                        </tr>
                            @foreach($tahun as $tahunItem)
                                <th scope="col" class="px-6 py-5 text-lg text-center" colspan="2">
                                    {{ $tahunItem }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            @for($i = 0; $i < $jumlahAngkatan; $i++)
                                <td class="py-2 font-medium">Sudah Skripsi</td>
                                <td class="py-2 font-medium">Belum Skripsi</td>
                            @endfor
                        </tr>
                        <tr class="text-center">
                            @foreach ($tahun as $year)
                                <td class="py-2 text-blue-500 font-medium text-base text-center">
                                    <a href="{{ route('operator.sudahskripsi', ['tahun' => $year]) }}">
                                        {{ $jumlahMahasiswaSkripsi[$year] }}
                                    </a>
                                </td>
                                <td class="py-2 text-blue-500 font-medium text-base text-center">                                    
                                    <a href="{{ route('operator.belumskripsi', ['tahun' => $year]) }}">
                                        {{ $jumlahMahasiswaBlmSkripsi[$year] }}
                                    </a></td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 </div>
@endsection
