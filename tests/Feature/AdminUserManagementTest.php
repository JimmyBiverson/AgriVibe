<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    public function test_homepage_renders_with_3d_assets_and_clean_copy(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('images/3d/dairy-cow.png');
        $response->assertSee('images/3d/poultry-hen.png');
        $response->assertSee('images/3d/fish-pond.png');
        $response->assertSee('Nakato Precision Farm Hub');
        $response->assertSee('Instant Farm Enterprise Profitability & Feed Forecaster');
        // Ensure no unnatural "3D" in main titles
        $response->assertDontSee("Uganda's Next-Gen 3D Smart Agribusiness Ecosystem");
        $response->assertDontSee('Complete 3D Visibility');
        $response->assertDontSee('Search 3D Base');
        $response->assertDontSee('Instant 3D Farm Profitability');
    }

    public function test_admin_can_access_users_management_page(): void
    {
        $this->withoutExceptionHandling();
        $admin = User::where('email', 'admin@agrivibe.test')->first();

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('All Users');
        $response->assertSee('Farmers');
        $response->assertSee('Veterinarians');
        $response->assertSee('Buyers');
        $response->assertSee('Suppliers');
        $response->assertSee('Trainers');
        $response->assertSee('Administrators');
    }
}
