<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminResourcesTest extends TestCase
{
    public static function resourcePathProvider(): array
    {
        return [
            'farms' => ['/admin/farms'],
            'animals' => ['/admin/animals'],
            'animal batches' => ['/admin/animal-batches'],
            'farm enterprises' => ['/admin/farm-enterprises'],
            'production records' => ['/admin/production-records'],
            'farm tasks' => ['/admin/farm-tasks'],
            'farm members' => ['/admin/farm-members'],
            'vet appointments' => ['/admin/vet-appointments'],
            'health events' => ['/admin/health-events'],
            'vaccination schedules' => ['/admin/vaccination-schedules'],
            'farm finances' => ['/admin/farm-finances'],
            'marketplace items' => ['/admin/marketplace-items'],
            'marketplace orders' => ['/admin/marketplace-orders'],
            'species' => ['/admin/species'],
            'breeds' => ['/admin/breeds'],
            'diseases' => ['/admin/diseases'],
            'symptoms' => ['/admin/symptoms'],
            'vaccines' => ['/admin/vaccines'],
            'medicines' => ['/admin/medicines'],
            'enterprise types' => ['/admin/enterprise-types'],
            'articles' => ['/admin/articles'],
            'categories' => ['/admin/categories'],
            'faqs' => ['/admin/faqs'],
            'downloads' => ['/admin/downloads'],
            'tags' => ['/admin/tags'],
            'users' => ['/admin/users'],
            'sms logs' => ['/admin/sms-logs'],
            'settings' => ['/admin/settings'],
        ];
    }

    /**
     * @dataProvider resourcePathProvider
     */
    #[DataProvider('resourcePathProvider')]
    public function test_admin_resource_index_loads(string $path): void
    {
        $admin = User::where('email', 'admin@agrivibe.test')->first();

        $response = $this->actingAs($admin)->get($path);

        $response->assertStatus(200);
    }

    public function test_admin_dashboard_loads_with_navigation_groups(): void
    {
        $admin = User::where('email', 'admin@agrivibe.test')->first();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Farm Operations');
        $response->assertSee('Master Data');
        $response->assertSee('Knowledge Hub');
        $response->assertSee('Marketplace');
    }
}
