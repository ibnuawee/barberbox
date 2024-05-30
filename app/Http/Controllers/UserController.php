<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    public function index(Request $request){
        if(Gate::denies('index-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $users = User::paginate(5);
        $users = DB::table('users')
            ->when($request->input('search'), function($query,$search){
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            })->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        if (Gate::denies('create-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }

        return view('user.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('create-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:10',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,barber,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'email_verified_at'=>now(),
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        if (Gate::denies('edit-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $users = User::findOrFail($id);
        return view('user.edit', compact('users'));
    }

    public function update(Request $request, User $id)
    {
        if (Gate::denies('edit-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:10',
            'role' => 'required|string|in:user,barber',
        ]);

        $users = User::findOrFail($id);
        $users->update($request->all());
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        if (Gate::denies('delete-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}

