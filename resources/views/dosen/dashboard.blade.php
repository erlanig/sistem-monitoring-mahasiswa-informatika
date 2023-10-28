@extends('dosen.layouts.main')



<div class="p-1 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
    <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
       <p class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Dosen Wali</p>

      </div>
      <div class="grid grid-cols-3 gap-4 mb-4">
         <div class="flex items-center justify-center h-72 rounded bg-gray-50 dark:bg-gray-800">
         <p class="text-xl font-semibold text-gray-900 dark:text-white">
         <div class="text-gray-900 dark:text-white text-center">
         <img class="mx-auto rounded-full w-25 h-25 mb-3" src="{{ asset('fotoProfil/'.$doswal->foto) }}" alt="image description">
         <div class="text-xl font-semibold">{{$doswal->nama_doswal}}</div>
            <p class="text-l font-semibold">{{$doswal->NIP}}</p>
            <p class="text-s">{{$doswal->email}}</p>
            <p class="text-s">S1-Informatika <a class="font-semibold">(Sains dan Matematika)</a></p>
        </div>
      </div>
        <div class="flex items-center justify-center rounded h-72 bg-gray-50 dark:bg-gray-800 col-span-2 row-span-4">
            <table>
                <tr>
                  <td class="text-left font-semibold px-4">Status IRS Mahasiswa</td>
                  <td> : </td>
                  <td>
                  <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700" style="width: {{$jumlahMahasiswa * 10}}">
                      <div class="h-5 bg-red-300 rounded-full dark:bg-red-500" style="width: {{$totalpersenIRS}}%"></div>
                  </div>
                  </td>
                  <td class="text-left px-4">{{$jumlahMahasiswaIRS}} Mahasiswa Sudah IRS</td>
                </tr>
                <tr>
                  <td class="text-left font-semibold px-4"></td>
                  <td> : </td>
                  <td>
                  <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700" style="width: {{$jumlahMahasiswa * 10}}">
                      <div class="h-5 bg-red-500 rounded-full dark:bg-red-500" style="width: {{$totalpersenBlmIRS}}%"></div>
                  </div>
                  </td>
                  <td class="text-left px-4">{{$jumlahMahasiswaBlmIRS}} Mahasiswa Belum IRS</td>
                </tr>
                <tr>
                    <td class="text-left font-semibold"></td>
                    <td class="px-4"> </td>
                    <td  class="text-left font-semibold"></td>
                </tr>

                <tr>
                  <td class="text-left font-semibold px-4">Status KHS Mahasiswa</td>
                  <td> : </td>
                  <td>
                  <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700" style="width: {{$jumlahMahasiswa * 10}}">
                      <div class="h-5 bg-yellow-300 rounded-full" style="width: {{$totalpersenKHS}}%"></div>
                  </div>
                  </td>
                  <td class="text-left px-4">{{$jumlahMahasiswaKHS}} Mahasiswa Sudah KHS</td>
                </tr>
                <tr>
                  <td class="text-left font-semibold px-4"></td>
                  <td> : </td>
                  <td>
                  <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700" style="width: {{$jumlahMahasiswa * 10}}">
                      <div class="h-5 bg-yellow-500 rounded-full dark:bg-yellow-500" style="width: {{$totalpersenBlmKHS}}%"></div>
                  </div>
                  </td>
                  <td class="text-left px-4">{{$jumlahMahasiswaBlmKHS}} Mahasiswa Belum KHS</td>
                </tr>
                <tr>
                    <td class="text-left font-semibold"></td>
                    <td class="px-4"> </td>
                    <td  class="text-left font-semibold"></td>
                </tr>
                <tr>
                  <td class="text-left font-semibold px-4">Status PKL Mahasiswa</td>
                  <td> : </td>
                  <td>
                  <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700" style="width: {{$jumlahMahasiswa * 10}}">
                      <div class="h-5 bg-blue-300 rounded-full dark:bg-blue-500" style="width: {{$totalPersenPKL}}%"></div>
                  </div>
                  </td>
                  <td class="text-left px-4">{{$jumlahMahasiswaPKL}} Mahasiswa Sudah PKL</td>
                </tr>
                <tr>
                  <td class="text-left font-semibold px-4"></td>
                  <td> : </td>
                  <td>
                  <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700" style="width: {{$jumlahMahasiswa * 10}}">
                      <div class="h-5 bg-blue-500 rounded-full dark:bg-blue-500" style="width: {{$totalPersenBlmPKL}}%"></div>
                  </div>
                  </td>
                  <td class="text-left px-4">{{$jumlahMahasiswaBlmPKL}} Mahasiswa Belum PKL</td>
                </tr>
                <tr>
                    <td class="text-left font-semibold"></td>
                    <td class="px-4"> </td>
                    <td  class="text-left font-semibold"></td>
                </tr>

                <tr>
                  <td class="text-left font-semibold px-4">Status Skripsi Mahasiswa</td>
                  <td> : </td>
                  <td>
                  <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700" style="width: {{$jumlahMahasiswa * 10}}">
                      <div class="h-5 bg-green-300 rounded-full dark:bg-green-500" style="width: {{$totalPersenSkripsi}}%"></div>
                  </div>
                  </td>
                  <td class="text-left px-4">{{$jumlahMahasiswaSkripsi}} Mahasiswa Sudah Skripsi</td>
                </tr>
                <tr>
                  <td class="text-left font-semibold px-4"></td>
                  <td> : </td>
                  <td>
                  <div class="h-5 bg-gray-300 rounded-full dark:bg-gray-700" style="width: {{$jumlahMahasiswa * 10}}">
                      <div class="h-5 bg-green-500 rounded-full dark:bg-green-500" style="width: {{$totalPersenBlmSkripsi}}%"></div>
                  </div>
                  </td>
                  <td class="text-left px-4">{{$jumlahMahasiswaBlmSkripsi}} Mahasiswa Belum Skripsi</td>
                </tr>
                <tr>
                    <td class="text-left font-semibold"></td>
                    <td class="px-4"> </td>
                    <td  class="text-left font-semibold"></td>
                </tr>
            </table>
        </div>
      </div>
      <div class="flex items-center justify-center rounded bg-gray-50 h-48 dark:bg-gray-800 relative col-span-2 row-span-4 mt-3">
          <table class="flex items-center justify-center">
              <tr class="mt-3">
                  <td><p class="mr-4 font-semibold">Total Mahasiswa Perwalian Aktif : </p></td>
                  <td class="px-1">
                      <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center font-bold text-xl text-white">{{$jumlahMahasiswaAktif}}</div>
                  </td>
                  <td class="px-6"></td>
                  <td class="mr-4 px-1"><p class="mr-4 font-semibold">Total Mahasiswa Perwalian Tidak Aktif : </p></td>
                  <td class="px-1 items-center justify-center">
                      <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center font-bold text-xl text-white">{{$jumlahMahasiswaTidakAktif}}</div>
                  </td>
              </tr>
          </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
