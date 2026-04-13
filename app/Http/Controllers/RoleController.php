<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\ZktecoDevices;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // List
    public function index($device_id)
    {
        $roles = Role::with('device')->where('device_id', $device_id)->get();
        $devices = ZktecoDevices::all();

        // dd($devices);

        return view('roles.roleManagement', compact('roles', 'devices'));
    }

    // Store
    public function store(Request $request)
    {
        Role::create($request->all());
        return back()->with('success', 'Role added successfully!');
    }

    // Update
    public function update(Request $request, $id)
    {
        Role::findOrFail($id)->update($request->all());
        return back()->with('success', 'Role updated!');
    }

    // Delete
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return back()->with('success', 'Role deleted!');
    }
}
