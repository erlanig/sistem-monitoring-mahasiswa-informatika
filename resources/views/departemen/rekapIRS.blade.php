@extends('departemen.layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Data IRS Mahasiswa</p>
            </div>

            <div class="relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-separate">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                        <th scope="col" class="px-6 py-5 text-xl" colspan="8">
                            ANGKATAN
                        </th>
                        </tr>
                        <tr class="text-center">
                        <th scope="col" class="px-6 py-5 text-sm" colspan="2">
                            2020
                        </th>
                        <th scope="col" class="px-6 py-5 text-sm" colspan="2">
                            2021
                        </th>
                        <th scope="col" class="px-6 py-5 text-sm" colspan="2">
                            2022
                        </th>
                        <th scope="col" class="px-6 py-5 text-sm" colspan="2">
                            2023
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            @for($i = 0; $i < 4; $i++)
                                <td class="py-2 font-medium">Sudah IRS</td>
                                <td class="py-2 font-medium">Belum IRS</td>
                            @endfor
                        </tr>
                        <tr class="text-center">
                            @foreach ($years as $year)
                                <td class="py-2 text-blue-500 font-medium text-base text-center">
                                    <a href="{{ route('departemen.sudahirs', ['tahun' => $year]) }}">
                                        {{ $jumlahMahasiswaIRS[$year] }}
                                    </a>
                                </td>
                                <td class="py-2 text-blue-500 font-medium text-base text-center">                                    
                                    <a href="{{ route('departemen.belumirs', ['tahun' => $year]) }}">
                                        {{ $jumlahMahasiswaBlmIRS[$year] }}
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
