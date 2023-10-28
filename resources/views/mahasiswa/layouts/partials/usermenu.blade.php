<div class="flex items-center">
    <div class="flex items-center ml-3">
      <div>
        <button type="button" class="flex text-smrounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full" src="{{ asset('fotoProfil/'.$mahasiswa->foto) }}" alt="Foto Pengguna">
        </button>
      </div>
      <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
        <div class="px-4 py-3" role="none">
          <p class="text-sm text-gray-900 dark:text-white" role="none">
            {{ $mahasiswa->nama  }}
          </p>
          <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
            {{ $mahasiswa->email  }}
          </p>
        </div>
        <ul class="py-1" role="none">
          <li>
            <a href="{{ route('mahasiswa.dashboard', ['id_mhs' => $mahasiswa->id_mhs]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
          </li>
          <li>
            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
          </li>
        </ul>
      </div>
    </div>
</div>
