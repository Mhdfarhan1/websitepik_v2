<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function pembinaIndex(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $users = User::where('role', 'pembina')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.dashboard.users.pembina', compact('users'));
    }

    public function ketuaIndex(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $users = User::where('role', 'ketua')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.dashboard.users.ketua', compact('users'));
    }

    public function anggotaIndex(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $users = User::where('role', 'anggota')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.dashboard.users.anggota', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:pembina,ketua,anggota',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        \App\Services\ActivityLogService::log(
            'created',
            "Menambahkan user {$user->name} dengan role {$user->role}",
            'User',
            $user->id
        );

        return back()->with('success', 'Akun ' . ucfirst($request->role) . ' berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        \App\Services\ActivityLogService::log(
            'updated',
            "Memperbarui data user {$user->name}",
            'User',
            $user->id
        );

        return back()->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Also delete from MemberRegistration if exists (Case-insensitive & Trimmed)
        $email = trim(strtolower($user->email));
        \App\Models\MemberRegistration::whereRaw('LOWER(TRIM(email)) = ?', [$email])->delete();

        $name = $user->name;
        $user->delete();

        \App\Services\ActivityLogService::log(
            'deleted',
            "Menghapus user {$name}",
            'User',
            $user->id
        );

        return back()->with('success', 'Akun dan data pendaftaran terkait berhasil dihapus.');
    }

    public function showChangePassword()
    {
        return view('pages.dashboard.password.index');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Password berhasil diperbarui! Selamat datang di dashboard.');
    }
}
