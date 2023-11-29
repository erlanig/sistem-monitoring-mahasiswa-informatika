@extends('mahasiswa.layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard Mahasiswa</p>
        </div>
        @if ($skripsiExist)
            <!-- Tampilkan formulir ketika id_mhs sudah ada di tabel IRS -->
            <div class="grid grid-cols-1 gap-2 mb-2">
                <form method="POST" action="{{ route('mahasiswa.createskripsi', $skripsi->id_mhs) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center justify-center">
                        @if($errors->any())
                          <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 w-1/2">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                        @endif
                      </div>
                      <div class="flex items-center justify-center w-full">
                      <div class="mt-3">
                              <label for="small-input" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama Studi</label>
                              <select name="lama_studi" id="lama_studi" class="@error('lama_studi') is-invalid @enderror block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                  @for ($i = 7; $i <= 14; $i++)
                                      <option value="{{ $i }}" {{ $i == $skripsi->smst_aktif ? 'selected' : '' }}>{{ $i }}</option>
                                  @endfor
                              </select>
                              <!-- <script>
                                  document.addEventListener("DOMContentLoaded", function() {
                                      // Dapatkan elemen dropdown
                                      var selectElement = document.querySelector("#smst_aktif");

                                      // Ambil "smst_aktif" dari database
                                      var smstAktif = {{ $skripsi->smst_aktif }};

                                      // Loop melalui semua opsi dalam dropdown
                                      var options = selectElement.getElementsByTagName("option");
                                      for (var i = 0; i < options.length; i++) {
                                          var option = options[i];
                                          var optionValue = parseInt(option.value);

                                          // Nonaktifkan opsi jika nilainya tidak sama dengan "smst_aktif"
                                          if (optionValue !== smstAktif) {
                                              option.disabled = true;
                                          }
                                      }
                                  });
                              </script> -->
                            </div>
                      </div>
                      <div class="flex items-center justify-center w-full mt-2">
                          <div>
                              <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai Skripsi</label>
                              <input type="text" id="small-input" name="nilai_skripsi" class="@error('nilai_skripsi') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$skripsi->nilai_skripsi}}">
                          </div>
                          <div class="ml-4">
                              <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Sidang</label>
                              <input type="date" id="small-input" name="tanggal_sidang" class="@error('tanggal_sidang') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{$skripsi->tanggal_sidang}}">
                          </div>
                      </div>
                      <div class="flex items-center justify-center mt-6">
                      <label for="small-input" class="block justify-center mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Scan Skripsi</label>
                      </div>
                      <div class="flex items-center justify-center w-full mt-2">
                          <div class="flex items-center justify-center w-full">
                              <label for="dropzone-file" class="flex flex-col items-center justify-center w-96 h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                      <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                      </svg>
                                      <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                      <p class="text-xs text-gray-500 dark:text-gray-400">PDF or DOCX (MAX. 10MB)</p>
                                  </div>
                                  <input id="dropzone-file" name="berkas_skripsi" type="file" class="@error('berkas_skripsi') is-invalid @enderror text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-400 dark:border-gray-600 dark:placeholder-gray-400"/>
                              </label>
                          </div>
                      </div>
                      <div class="flex items-center justify-center mt-4">
                          <button type="submit" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                      </div>

                </form>
            </div>
        @else
            <!-- Tampilkan formulir ketika id_mhs belum ada di tabel IRS -->
            <div class="grid grid-cols-1 gap-2 mb-2">
                <form method="POST" action="{{ route('mahasiswa.createskripsi', $mahasiswa->id_mhs) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center justify-center">
                        @if($errors->any())
                          <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 w-1/2">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                        @endif
                      </div>
                      <div class="flex items-center justify-center w-full">
                      <div class="mt-3">
                              <label for="small-input" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama Studi</label>
                              <select name="lama_studi" id="lama_studi" class="@error('lama_studi') is-invalid @enderror block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                  @for ($i = 7; $i <= 14; $i++)
                                      <option value="{{ $i }}">{{ $i }}</option>
                                  @endfor
                              </select>
                            </div>
                      </div>
                      <div class="flex items-center justify-center w-full mt-2">
                          <div>
                              <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai Skripsi</label>
                              <input type="text" id="small-input" name="nilai_skripsi" class="@error('nilai_skripsi') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                          </div>
                          <div class="ml-4">
                              <label for="small-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Sidang</label>
                              <input type="date" id="small-input" name="tanggal_sidang" class="@error('tanggal_sidang') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                          </div>
                      </div>
                      <div class="flex items-center justify-center mt-6">
                      <label for="small-input" class="block justify-center mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Scan Skripsi</label>
                      </div>
                      <div class="flex items-center justify-center w-full mt-2">
                          <div class="flex items-center justify-center w-full">
                              <label for="dropzone-file" class="flex flex-col items-center justify-center w-96 h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                      <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                      </svg>
                                      <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                      <p class="text-xs text-gray-500 dark:text-gray-400">PDF or DOCX (MAX. 10MB)</p>
                                  </div>
                                  <input id="dropzone-file" name="berkas_skripsi" type="file" class="@error('berkas_skripsi') is-invalid @enderror text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-400 dark:border-gray-600 dark:placeholder-gray-400"/>
                              </label>
                          </div>
                      </div>
                      <div class="flex items-center justify-center mt-4">
                          <button type="submit" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                      </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection

