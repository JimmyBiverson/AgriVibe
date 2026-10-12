<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_farmer_dashboard_renders_with_new_sections(): void
    {
        $farmer = User::where('email', 'farmer@agrivibe.test')->first();

        $response = $this->actingAs($farmer)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Quick Actions');
        $response->assertSee('Alerts &amp; Reminders', false);
        $response->assertSee('Recent Activity');
        $response->assertSee('Switch Farm');
    }

    public function test_dashboard_supports_farm_and_role_query_switching(): void
    {
        $farmer = User::where('email', 'farmer@agrivibe.test')->first();
        $farm = $farmer->ownedFarms()->first() ?? $farmer->farms()->first();

        if (! $farm) {
            $this->markTestSkipped('No farm available for the demo farmer.');
        }

        $response = $this->actingAs($farmer)->get('/dashboard?role=buyer&farm='.$farm->id);

        $response->assertStatus(200);
    }
}
