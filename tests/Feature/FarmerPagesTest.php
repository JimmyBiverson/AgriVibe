<?php

namespace Tests\Feature;

use App\Livewire\Farm\AnimalManager;
use App\Livewire\Farm\FinanceManager;
use App\Livewire\Farm\TaskManager;
use App\Models\Animal;
use App\Models\Farm;
use App\Models\FarmTask;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class FarmerPagesTest extends TestCase
{
    protected function farmer(): User
    {
        return User::where('email', 'farmer@agrivibe.test')->firstOrFail();
    }

    public function test_farm_pages_load_for_authenticated_farmer(): void
    {
        $farmer = $this->farmer();

        foreach (['/farm/animals', '/farm/batches', '/farm/production', '/farm/finances', '/farm/tasks'] as $path) {
            $this->actingAs($farmer)->get($path)->assertStatus(200);
        }
    }

    public function test_farm_pages_require_authentication(): void
    {
        $this->get('/farm/animals')->assertRedirect('/login');
    }

    public function test_farmer_can_register_an_animal(): void
    {
        $farmer = $this->farmer();
        $farm = $farmer->ownedFarms()->first() ?? $farmer->farms()->first();

        $this->actingAs($farmer);

        Livewire::test(AnimalManager::class, ['farmId' => $farm->id])
            ->set('data.tag_number', 'TEST-'.uniqid())
            ->set('data.gender', 'female')
            ->set('data.health_status', 'healthy')
            ->set('data.reproductive_status', 'open')
            ->set('data.estimated_value', 250000)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('animals', [
            'farm_id' => $farm->id,
            'gender' => 'female',
        ]);
    }

    public function test_farmer_cannot_touch_another_farms_animal(): void
    {
        $farmer = $this->farmer();
        $farm = $farmer->ownedFarms()->first() ?? $farmer->farms()->first();

        $otherFarm = Farm::where('id', '!=', $farm->id)->first();

        if (! $otherFarm) {
            $this->markTestSkipped('No other farm exists to test isolation.');
        }

        $foreignAnimal = Animal::where('farm_id', $otherFarm->id)->first();

        if (! $foreignAnimal) {
            $this->markTestSkipped('No animal on another farm to test isolation.');
        }

        $this->actingAs($farmer);

        Livewire::test(AnimalManager::class, ['farmId' => $farm->id])
            ->call('delete', $foreignAnimal->id)
            ->assertStatus(404);

        $this->assertDatabaseHas('animals', ['id' => $foreignAnimal->id, 'deleted_at' => null]);
    }

    public function test_farmer_can_log_a_transaction(): void
    {
        $farmer = $this->farmer();
        $farm = $farmer->ownedFarms()->first() ?? $farmer->farms()->first();

        $this->actingAs($farmer);

        Livewire::test(FinanceManager::class, ['farmId' => $farm->id])
            ->set('data.type', 'income')
            ->set('data.category', 'sales')
            ->set('data.transaction_date', now()->format('Y-m-d'))
            ->set('data.amount', 150000)
            ->set('data.currency', 'UGX')
            ->set('data.description', 'Test milk sale')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('farm_finances', [
            'farm_id' => $farm->id,
            'amount' => 150000,
        ]);
    }

    public function test_farmer_can_create_a_task(): void
    {
        $farmer = $this->farmer();
        $farm = $farmer->ownedFarms()->first() ?? $farmer->farms()->first();

        $this->actingAs($farmer);

        Livewire::test(TaskManager::class, ['farmId' => $farm->id])
            ->set('data.title', 'Test vaccination round')
            ->set('data.category', 'health')
            ->set('data.due_date', now()->addDays(2)->format('Y-m-d'))
            ->set('data.priority', 'high')
            ->set('data.status', 'pending')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('farm_tasks', [
            'farm_id' => $farm->id,
            'title' => 'Test vaccination round',
        ]);

        FarmTask::where('title', 'Test vaccination round')->delete();
    }
}
