<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profilePath = null;
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('profiles', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'profile' => $profilePath,
            'email_verified_at'=>now(),
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        if (Gate::denies('edit-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        return view('user.edit', compact('user'));
    }

    public function update(Request $request,User $user)
    {
        if (Gate::denies('edit-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255', Rule::unique('users')->ignore($user->id),
            'phone' => 'required|string|min:10',
            'role' => 'required|string|in:user,barber',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Simpan data role lama
        $oldRole = $user->role;

        // Update user data
        $user->update($request->all());

        // Tambahkan logika untuk mengupdate tabel barber
        if ($oldRole !== 'barber' && $user->role === 'barber') {
            // Jika role berubah menjadi barber, tambahkan ke tabel barber
            Barber::create(['user_id' => $user->id]);
        } elseif ($oldRole === 'barber' && $user->role !== 'barber') {
            // Jika role berubah dari barber ke role lain, hapus dari tabel barber
            Barber::where('user_id', $user->id)->delete();
        }
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function updatePicture(Request $request)
    {

        $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // Delete old profile picture if exists
        if ($user->profile) {
            Storage::disk('public')->delete($user->profile);
        }

        // Store new profile picture
        $profilePath = $request->file('profile')->store('profiles', 'public');
        $user->profile = $profilePath;
        $user->save();

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }


    public function destroy(User $user)
    {
        if (Gate::denies('delete-user')) {
            abort(403, 'Anda tidak memiliki cukup hak akses');
        }
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}

