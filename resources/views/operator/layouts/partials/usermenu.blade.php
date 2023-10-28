<div class="flex items-center ml-3">
    <div>
      <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 light:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
        <span class="sr-only">Open user menu</span>
        <img class="w-8 h-8 rounded-full" src="{{ asset('fotoProfil/'.$operator->foto) }}" alt="user photo">
      </button>
    </div>
    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow light:bg-gray-700 light:divide-gray-600" id="dropdown-user">
      <div class="px-4 py-3" role="none">
        <p class="text-sm text-gray-900 light:text-white" role="none">
          {{ $operator->nama }}
        </p>
        <p class="text-sm font-medium text-gray-900 truncate light:text-gray-300" role="none">
          {{ $operator->email }}
        </p>
      </div>
      <ul class="py-1" role="none">
        <li>
          <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 light:text-gray-300 light:hover:bg-gray-600 light:hover:text-white" role="menuitem">Sign out</a>
        </li>
      </ul>
    </div>
  </div>
