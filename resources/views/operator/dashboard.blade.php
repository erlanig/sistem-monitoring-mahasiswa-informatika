@extends('operator.layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
   <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg light:border-gray-700 mt-14">
      <div class="grid grid-cols-1 gap-4 mb-4">

        <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 light:bg-gray-800">
          <p class="text-3xl font-bold text-gray-900 light:text-white">Dashboard Operator</p>
       </div>

       <div class="flex flex-col items-center justify-center h-screen rounded bg-gray-50 light:bg-gray-800">
          <img class="mx-auto rounded-full w-60 h-60" src="{{ asset('fotoProfil/'.$operator->foto) }}" alt="user photo">
          <br>
          <div style="font-size: 3.5em; font-weight: semibold;">{{ $operator->nama }}</div>
            <p style="font-size: 2.0em; font-weight: semibold;">{{$operator->NIP}}</p>
            <p style="font-size: 1.5em;">{{ $operator->email }}</p>
            <p style="font-size: 1.5em;">{{$operator->fakultas}}</p>
            <p style="font-size: 1.5em;">{{$operator->prodi}}</p>
       </div>
   </div>
</div>
@endsection


