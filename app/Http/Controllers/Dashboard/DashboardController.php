<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkProgram;
use App\Models\Gallery;
use App\Models\News;
use App\Models\PeerEducation;
use App\Models\Report;
use App\Models\MemberRegistration;
use App\Models\Achievement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        // Dynamic statistics from database
        $totalAnggota = User::count();
        $totalProker = class_exists(WorkProgram::class) ? WorkProgram::count() : 0;
        $totalGaleri = class_exists(Gallery::class) ? Gallery::count() : 0;
        $totalKegiatan = (class_exists(PeerEducation::class) ? PeerEducation::count() : 0) + (class_exists(News::class) ? News::count() : 0);
        $totalPrestasi = class_exists(Achievement::class) ? Achievement::count() : 0;

        // Role distribution counts
        $coreUsersCount = User::whereIn('role', ['super_admin', 'pembina', 'ketua'])->count();
        $memberUsersCount = User::where('role', 'anggota')->count();

        // Content counts for chart
        $newsCount = class_exists(News::class) ? News::count() : 0;
        $reportCount = class_exists(Report::class) ? Report::count() : 0;

        // Recent Users list
        $recentUsers = User::latest()->take(5)->get();
        $latestProkers = class_exists(WorkProgram::class) ? WorkProgram::latest()->take(4)->get() : collect();

        // Pending Registrations
        $pendingRegistrationsCount = class_exists(MemberRegistration::class) ? MemberRegistration::count() : 0;

        $data = compact(
            'totalAnggota',
            'totalProker',
            'totalGaleri',
            'totalKegiatan',
            'totalPrestasi',
            'coreUsersCount',
            'memberUsersCount',
            'newsCount',
            'reportCount',
            'recentUsers',
            'latestProkers',
            'pendingRegistrationsCount'
        );

        if ($role === 'super_admin') {
            return view('pages.dashboard.index', $data);
        }

        if (view()->exists("pages.dashboard.{$role}.index")) {
            return view("pages.dashboard.{$role}.index", $data);
        }

        return view('pages.dashboard.index', $data);
    }
}
