@extends('layouts.main')

@section('content')
<section style="background-image: url('{{ asset('img/login.png') }}');" class="bg-red-50 dark:bg-gray-900 bg-cover bg-center relative">
    <div class="card flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        {{-- <a href="" class="flex items-center mb-6 text-2xl font-semibold text-900 light:text-white">
            <img class="w-8 h-8 mr-2" src="img/logoundip.png" alt="logo">
            Sistem Monitoring Akademik
        </a> --}}
        <div class="w-full bg-white rounded-3xl shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700 p-5">
            <div class="flex items-center justify-center">
                <img class="mt-2 w-20 h-22 flex items-center justify-center" src="img/logoundip.png" alt="logo">
            </div>
            <a href="" class="flex text-center justify-center mb-2 text-2xl font-semibold text-900 light:text-white mt-2">
                Sistem Monitoring Akademik
            </a>
            <a href="" class="flex text-center justify-center text-l font-normal text-900 light:text-white mt-2">
                Informatika Universitas Diponegoro
            </a>
            <div class="flex items-center justify-center relative w-full my-2 mt-8">
                <div class="border-b-2 border-gray-300 w-10/12"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-2">
                    <!-- <a class="text-sm font-thin text-gray-600">Silahkan Masuk</a> -->
                </div>
            </div>
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in to your account
                </h1>
                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">Login gagal!</span>
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="space-y-4 md:space-y-6" action="" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('email') }}" placeholder="Email official Undip" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-6 w-6 text-gray-700 dark:text-gray-400 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eye-toggle">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12s3-6 10-6 10 6 10 6-3 6-10 6-10-6-10-6z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <script>
                        const passwordInput = document.getElementById('password');
                        const eyeToggle = document.getElementById('eye-toggle');

                        eyeToggle.addEventListener('click', () => {
                            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordInput.setAttribute('type', type);
                        });
                    </script>
                    <button name="submit" type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in</button>
                </form>
            </div>
        </div>
    </div>
  </section>
@endsection
