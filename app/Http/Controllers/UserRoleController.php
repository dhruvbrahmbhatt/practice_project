<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.users.roles', compact('users', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $user->syncRoles($request->roles);
        return back()->with('success', 'Roles updated for user.');
    }
}
