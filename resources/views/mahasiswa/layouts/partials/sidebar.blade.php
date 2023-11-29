<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
       <ul class="pt-2 mb-3 font-medium">
           <li>
           <div class="flex items-center">
               <img class="w-12 h-12 rounded-full" src="{{ asset('fotoProfil/'.$mahasiswa->foto) }}" alt="Foto Pengguna">
               <div class="ml-2">
                   <a class="text-xs">{{ $mahasiswa->nama }}</a>
                   <p class="text-xs font-thin text-gray-500">{{ $mahasiswa->NIM }}</p>
               </div>
           </div>
           </li>
       </ul>
       <ul class="space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
       <ul class="space-y-2 font-medium">
          <li>
             <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
               <svg class="w-6 h-6 text-gray-500  dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                     <path d="M7 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm2 1H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                 </svg>
                   <span class="flex-1 ml-3 text-left whitespace-nowrap">Biodata</span>
                   <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                   </svg>
             </button>
             <ul id="dropdown-example" class="hidden py-2 space-y-2">
                   <li>
                      <a href="{{ route('mahasiswa.dashboard', ['id_mhs' => $mahasiswa->id_mhs]) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Dashboard</a>
                   </li>
                   <li>
                     <a href="{{ route('mahasiswa.edit', ['id_mhs' => $mahasiswa->id_mhs]) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Update Biodata</a>
                   </li>
             </ul>
          </li>
          <li>
             <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example1">
               <svg svg class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                 <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                 <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2Z"/>
               </svg>
                   <span class="flex-1 ml-3 text-left whitespace-nowrap">Akademik</span>
                   <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                   </svg>
             </button>
             <ul id="dropdown-example1" class="hidden py-2 space-y-2">
                   <li>
                      <a href="{{ route('mahasiswa.irs', ['id_mhs' => $mahasiswa->id_mhs]) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Entry Data IRS</a>
                   </li>
                   <li>
                      <a href="{{ route('mahasiswa.khs', ['id_mhs' => $mahasiswa->id_mhs]) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Entry Data KHS</a>
                   </li>
                   <li>
                      <a href="{{ route('mahasiswa.pkl', ['id_mhs' => $mahasiswa->id_mhs]) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Entry Data PKL</a>
                   </li>
                   <li>
                      <a href="{{ route('mahasiswa.skripsi', ['id_mhs' => $mahasiswa->id_mhs]) }}" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Entry Data Skripsi</a>
                   </li>
             </ul>
          </li>
       </ul>
    </div>
</aside>
