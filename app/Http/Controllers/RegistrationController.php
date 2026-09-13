<?php

namespace App\Http\Controllers;

use App\Models\MemberRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    // Public Form
    public function showForm()
    {
        return view('pages.registration.form');
    }

    public function store(Request $request)
    {
        // Honeypot check for bots
        if ($request->filled('website')) {
            return response()->json(['message' => 'Bot detected'], 422);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:member_registrations|unique:users',
            'phone' => 'required|string|max:20',
            'reason' => 'nullable|string',
        ]);

        MemberRegistration::create($request->all());

        return view('pages.registration.success');
    }

    // Admin Management
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $registrations = MemberRegistration::where('status', 'pending')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.dashboard.registrations.index', compact('registrations'));
    }

    public function approve(MemberRegistration $registration)
    {
        // Create User account
        $password = Str::random(10);
        
        User::create([
            'name' => $registration->name,
            'email' => $registration->email,
            'password' => Hash::make($password),
            'role' => 'anggota',
            'must_change_password' => true,
        ]);

        $registration->update(['status' => 'approved']);

        \App\Services\ActivityLogService::log(
            'approved',
            "Menyetujui pendaftaran {$registration->name}",
            'MemberRegistration',
            $registration->id
        );

        return back()->with('approval_success', [
            'name' => $registration->name,
            'password' => $password
        ]);
    }

    public function reject(MemberRegistration $registration)
    {
        $registration->update(['status' => 'rejected']);

        \App\Services\ActivityLogService::log(
            'rejected',
            "Menolak pendaftaran {$registration->name}",
            'MemberRegistration',
            $registration->id
        );

        return back()->with('success', 'Pendaftaran telah ditolak.');
    }
}
