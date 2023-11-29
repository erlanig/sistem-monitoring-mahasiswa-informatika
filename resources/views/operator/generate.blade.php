@extends('operator.layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg light:border-gray-700 mt-14">
       <div class="grid grid-cols-1 gap-4 mb-4">

         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 light:bg-gray-800">
           <p class="text-3xl font-bold text-gray-900 light:text-white">Generate Akun</p>
        </div>

        <div class="container flowbite mx-auto bg-white shadow-lg rounded-lg">
            <div class="card mt-3 mb-3">
                <form action="{{ route('operator.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <input type="file" name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-2">
                    <button class="btn btn-primary mt-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Import User Data</button>
                </form>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table border="1" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class=" text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-center">
                            <tr>
                                <th class="border px-4 py-2">ID</th>
                                <th class="border px-4 py-2">NAMA</th>
                                <th class="border px-4 py-2">EMAIL</th>
                            </tr>
                        </thead>
                        @foreach ($users as $user)
                        <tbody>
                            <tr class="text-s bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                <td class="border px-4 py-2">{{ $user->id }}</td>
                                <td class="border px-4 py-2">{{ $user->nama }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
