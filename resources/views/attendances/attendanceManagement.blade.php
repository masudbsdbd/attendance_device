@extends('layouts.MainLayout')

@section('section')
    <h1 class="text-2xl font-bold ml-3 mb-3">Attendance Log</h1>
    <div class="w-full flex justify-center items-center px-10">
        
    </div>
    @include("components.attendance_table")
@endsection