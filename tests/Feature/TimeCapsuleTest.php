<?php

namespace Tests\Feature;

use App\Models\TimeCapsule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeCapsuleTest extends TestCase
{
    public function test_public_kotak_waktu_page_is_accessible_and_renders_correctly(): void
    {
        $response = $this->get('/profil/kotak-waktu');

        $response->assertStatus(200);
        $response->assertSee('Kotak Waktu PIK-R');
        $response->assertSee('Tidak semua cerita harus dibaca hari ini');
        $response->assertSee('TIME CAPSULE 2026');
        $response->assertSee('Generasi PIK-R REQUEST 2025–2026');
        $response->assertSee('TERKUNCI');
    }

    public function test_jejak_nakhoda_is_not_broken(): void
    {
        $response = $this->get('/profil/jejak-ketua');

        $response->assertStatus(200);
        $response->assertSee('Jejak Nakhoda');
    }

    public function test_dashboard_time_capsules_requires_auth_and_works_for_admin(): void
    {
        // Unauthenticated redirects to login
        $unauth = $this->get('/dashboard/time-capsules');
        $unauth->assertRedirect('/login');

        // Authenticated admin can view
        $admin = User::first() ?? User::factory()->create(['role' => 'super_admin']);
        $authResponse = $this->actingAs($admin)->get('/dashboard/time-capsules');
        $authResponse->assertStatus(200);
        $authResponse->assertSee('Kotak Waktu PIK-R');
    }
}
