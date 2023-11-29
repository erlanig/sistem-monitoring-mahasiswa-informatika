@extends('dosen.layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Detail Mahasiswa</p>
        </div>
        <!-- Semester selection and submit button -->
        <div class="space-y-4">
            <div>
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Mahasiswa</label>
                <input type="text" id="nama" name="nama" class="w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-s" value="{{ $mahasiswa->nama }}">
            </div>
            <div>
                <label for="NIM" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                <input type="text" id="NIM" name="NIM" class="w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-s" value="{{ $mahasiswa->NIM }}">
            </div>
            <div>
                <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                <select id="semester" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Pilih Semester</option>
                    @for ($i = 1; $i <= 14; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                <button type="button" class="mt-3 py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover-text-white dark:hover-bg-gray-700" onclick="showPopup()">Pilih</button>
            </div>
        </div>
    </div>
</div>

<!-- Pop-up -->
<div id="popup">
    <div id="popup-content">
        <button onclick="closePopup()" style="position: absolute; top: 10px; right: 10px;">Tutup</button>
        <div id="popup-tab">
            <button onclick="showTab('irs')">IRS</button>
            <button onclick="showTab('khs')">KHS</button>
            <button onclick="showTab('pkl')">PKL</button>
            <button onclick="showTab('skripsi')">Skripsi</button>
        </div>
        <div id="popup-irs-content" class="popup-tab-content">
            @if($irs)
                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="irs" role="tabpanel" aria-label="disabled">
                    <div class="form-group">
                        <label for="semester" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Semester</label>
                        <input type="text" id="semester" name="semester" class="w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-s" value="{{ $irs->semester }}" disabled>
                    </div>
                    <div>
                        <label for="tahun_ajaran" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah SKS/label>
                        <input type="text" id="jumlah_sks" name="jumlah_sks" class="w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-s" value="{{ $irs->jumlah_sks }}" disabled>
                    </div>
                </div>
            @else
                <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="irs" role="tabpanel" aria-label="disabled">
                    <p class="mb-3 text-grat-500 dartk:text-gray-400">Belum ada progress IRS</p>
                </div>
            @endif
        </div>
        <div id="popup-khs-content" class="popup-tab-content">
            <!-- Konten tab KHS di sini -->
            <p>Ini adalah konten KHS</p>
        </div>
        <div id="popup-pkl-content" class="popup-tab-content">
            <!-- Konten tab PKL di sini -->
            <p>Ini adalah konten PKL</p>
        </div>
        <div id="popup-skripsi-content" class="popup-tab-content">
            <!-- Konten tab Skripsi di sini -->
            <p>Ini adalah konten Skripsi</p>
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    /* CSS untuk pop-up */
    #popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    #popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* CSS untuk tab */
    #popup-tab {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }

    #popup-tab button {
        padding: 8px 16px;
        border: none;
        background: none;
        cursor: pointer;
        font-weight: bold;
    }

    #popup-tab button:hover {
        background: #f0f0f0;
    }

    /* Tambahkan CSS untuk tab-content sesuai dengan kebutuhan Anda */
    .popup-tab-content {
        display: none;
    }

    .popup-tab-content.show {
        display: block;
    }
</style>

<!-- JavaScript -->
<script>
    function showPopup() {
        var popup = document.getElementById('popup');
        // Tampilkan pop-up
        popup.style.display = 'block';
        showTab('irs'); // Tampilkan tab IRS secara default
    }

    function closePopup() {
        var popup = document.getElementById('popup');
        // Sembunyikan pop-up
        popup.style.display = 'none';
    }

    function showTab(tabName) {
        var tabContents = document.querySelectorAll('.popup-tab-content');
        tabContents.forEach(function (content) {
            content.style.display = 'none';
        });
        document.getElementById(`popup-${tabName}-content`).style.display = 'block';
    }
</script>
@endsection