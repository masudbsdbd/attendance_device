@extends('layouts.MainLayout')

@section('section')
    <h1 class="text-2xl font-bold ml-3 mb-3">Attendance Log </h1>
    <div class="w-full flex justify-end items-center px-10">
        <button class="cursor-pointer rounded-md bg-green-600 px-5 py-3 text-sm font-semibold text-white hover:text-green-900 hover:bg-green-200 ml-auto mb-3 mr-3" id="refresh-page">
            <i class="fa-solid fa-arrows-rotate"></i>
            Refresh
        </button>
        <form action="{{ route("clear-attendance-log", $current_device_id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="cursor-pointer rounded-md bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:text-red-900 hover:bg-red-200 ml-auto mb-3 mr-3">
                <i class="fa-solid fa-broom"></i>
                Clear Attendance Log
            </button>
        </form>
    </div>
    @include("components.attendance_table")
@endsection

@section('script')
    <script>
        document.getElementById('refresh-page').addEventListener('click', function () {
            window.location.reload();
        });
    </script>
@endsection