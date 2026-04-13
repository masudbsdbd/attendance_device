@extends('layouts.MainLayout')

@section('section')
    <h1 class="text-2xl font-bold ml-3 mb-3">User List</h1>
    <div class="w-full flex justify-center items-center px-10">
        <button command="show-modal" commandfor="dialog" class="cursor-pointer rounded-md bg-cyan-600 px-5 py-3 text-sm font-semibold text-white hover:text-gray-900 hover:bg-cyan-200 ml-auto mb-3 mr-3">Add User</button>
    </div>
    @include("components.add_modal")
    @include("components.user_table")
@endsection