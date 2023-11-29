@extends('mahasiswa.layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Mahasiswa</p>
        </div>

        @if ($irsExists)
            <!-- Tampilkan formulir ketika id_mhs sudah ada di tabel IRS -->
            <div class="grid grid-cols-1 gap-2 mb-2">
                <form method="POST" action="{{ route('mahasiswa.createkhs', $khs->id_mhs) }}" enctype="multipart/form-data">
                    @csrf

                </form>
            </div>
        @else
            <!-- Tampilkan formulir ketika id_mhs belum ada di tabel IRS -->
            <div class="grid grid-cols-1 gap-2 mb-2">
                <form method="POST" action="{{ route('mahasiswa.createkhs', $mahasiswa->id_mhs) }}" enctype="multipart/form-data">
                    @csrf

                </form>
            </div>
        @endif
    </div>
</div>
@endsection
