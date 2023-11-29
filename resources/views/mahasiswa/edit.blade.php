@extends('mahasiswa.layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Update Data Mahasiswa</p>
        </div>
        <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa->id_mhs) }}" enctype="multipart/form-data" class="p-3">
            @csrf
            @method('PUT')
            <div class="form-group justify-center">
                <img class="mx-auto w-48 h-48 rounded-full border border-gray-800 border-" src="{{ asset('fotoProfil/'.$mahasiswa->foto) }}" alt="Foto Pengguna">
                <label class="flex items-center justify-center mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                <input type="file" name="foto" id="foto" class="form-control block mx-auto my-auto w-28 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help">
                <p class="flex items-center justify-center mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>

            </div>
            <div class="mt-3">
                <label for="nim" class="text-medium text-sm  text-gray-500 dark:text-gray-400">NIM</label>
                <input type="text" name="nim" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $mahasiswa->NIM }}" required readonly>
            </div>
            <div class="mt-3">
                <label for="email" class="text-medium text-sm  text-gray-500 dark:text-gray-400">Email</label>
                <input type="email" name="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $mahasiswa->email }}" required>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 mt-3">
                <div>
                    <label for="password" class="text-medium text-sm text-gray-500 dark:text-gray-400">Password Baru</label>
                    <input type="password" name="password" placeholder="••••••••" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="">
                </div>
                <div>
                    <label for="password_confirmation" class="text-medium text-sm text-gray-500 dark:text-gray-400">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="">
                </div>
            </div>
            <div class="mt-3">
                <label for="nama" class="text-medium text-sm  text-gray-500 dark:text-gray-400">Nama</label>
                <input type="text" name="nama" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $mahasiswa->nama }}" required>
            </div>
            <div class="mt-3">
                <label for="nohp" class="text-medium text-sm  text-gray-500 dark:text-gray-400">Nomor Handphone</label>
                <input type="text" name="no_HP" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $mahasiswa->no_HP }}" >
            </div>
            <div class="mt-3">
                <label for="alamat" class="text-medium text-sm  text-gray-500 dark:text-gray-400">Alamat</label>
                <input type="text" name="alamat" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $mahasiswa->alamat }}" >
            </div>
            <div class="mt-3">
                <label for="jalur" class="text-medium text-sm  text-gray-500 dark:text-gray-400">Jalur Masuk</label>
                <input type="text" name="jalur_masuk" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $mahasiswa->jalur_masuk }}" required readonly>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 mt-3">
                <div>
                    <label for="status" class="text-medium text-sm  text-gray-500 dark:text-gray-400">Status</label>
                    <input type="text" name="status" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $mahasiswa->status }}" required readonly>
                </div>
                <div>
                    <label for="angkatan" class="text-medium text-sm  text-gray-500 dark:text-gray-400">Angkatan</label>
                    <input type="text" name="angkatan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" value="{{ $mahasiswa->angkatan }}" required readonly>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 mt-3">
                <div class="relative z-0 w-full mb-6 group">
                    <label class="text-medium text-sm text-gray-500 dark:text-gray-400">Kota</label>
                    <select name="kota" id="kota" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <option value="">-- Pilih Kota/Kabupaten --</option>
                        @foreach ($kota as $k)
                            <option value="{{ $k->kode_kota_kab }}" {{ $k->kode_kota_kab == $mahasiswa->kode_kota_kab ? 'selected' : '' }}>
                                {{ $k->namakota }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label class="text-medium text-sm text-gray-500 dark:text-gray-400">Provinsi</label>
                    <select name="provinsi" id="provinsi" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" disabled>
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach ($kota as $k)
                            <option value="{{ $k->kode_kota_kab }}" {{ $k->kode_kota_kab == $mahasiswa->kode_kota_kab ? 'selected' : '' }}>
                                {{ $k->namaprov }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </form>
   </div>
</div>
@endsection
