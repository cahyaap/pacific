<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $roles = Role::all();
        $page = "user";
        return view('user.list', compact(['roles', 'page']));
    }

    public function getUserTable()
    {
        $users = User::with(['role'])->get();
        return view('user.table', compact(['users']));
    }

    public function getUserData(Request $request)
    {
        $user = User::find($request->input('id'));
        return response()->json([
            "message" => "success",
            "data" => $user
        ]);
    }

    public function createUser(Request $request)
    {
        $userCreated = User::create([
            'role_id' => $request->input('roleId'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return response()->json([
            "message" => "success",
            "data" => $userCreated
        ]);
    }

    public function emailChecking(Request $request)
    {
        $user = User::where('email', $request->input('email'))->get();
        $userExist = false;
        if (count($user) > 0) {
            $userExist = true;
        }
        return response()->json([
            "userExist" => $userExist,
            "data" => $user
        ]);
    }

    public function editUser(Request $request)
    {
        $user = User::find($request->input('id'));
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role_id = $request->input('roleId');
        $user->save();
        return response()->json([
            "message" => "success",
            "data" => $user
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = User::find($request->input('id'));
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response()->json([
            "message" => "success",
            "data" => $user
        ]);
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->input('id'));
        $user->delete();
        return response()->json([
            "message" => "success",
            "data" => $user
        ]);
    }
}
