<?php

namespace Tests\Feature;

use App\Livewire\Farm\AnimalManager;
use App\Livewire\Farm\FinanceManager;
use App\Livewire\Farm\HealthManager;
use App\Livewire\Farm\TaskManager;
use App\Livewire\Farm\VetRequestManager;
use App\Models\Animal;
use App\Models\Farm;
use App\Models\FarmTask;
use App\Models\HealthEvent;
use App\Models\User;
use App\Models\VetAppointment;
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

        foreach (['/farm/animals', '/farm/batches', '/farm/production', '/farm/finances', '/farm/tasks', '/farm/health', '/farm/vet'] as $path) {
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

    public function test_farmer_can_log_a_health_event_with_withdrawal(): void
    {
        $farmer = $this->farmer();
        $farm = $farmer->ownedFarms()->first() ?? $farmer->farms()->first();

        $this->actingAs($farmer);

        $administered = now()->format('Y-m-d');

        Livewire::test(HealthManager::class, ['farmId' => $farm->id])
            ->set('data.event_type', 'vaccination')
            ->set('data.title', 'Test Newcastle vaccine')
            ->set('data.administered_date', $administered)
            ->set('data.withdrawal_period_days', 3)
            ->set('data.status', 'completed')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('health_events', [
            'farm_id' => $farm->id,
            'title' => 'Test Newcastle vaccine',
            'safe_consumption_date' => now()->addDays(3)->format('Y-m-d'),
        ]);

        HealthEvent::where('title', 'Test Newcastle vaccine')->delete();
    }

    public function test_farmer_can_request_a_veterinarian(): void
    {
        $farmer = $this->farmer();
        $farm = $farmer->ownedFarms()->first() ?? $farmer->farms()->first();

        $vet = User::where('account_type', 'veterinarian')->first();

        if (! $vet) {
            $this->markTestSkipped('No veterinarian account exists to test requests.');
        }

        $this->actingAs($farmer);

        Livewire::test(VetRequestManager::class, ['farmId' => $farm->id])
            ->set('data.vet_id', $vet->id)
            ->set('data.service_type', 'telemedicine')
            ->set('data.scheduled_at', now()->addDay()->format('Y-m-d\TH:i'))
            ->set('data.urgency', 'normal')
            ->set('data.symptoms_description', 'Test: cow with fever for two days.')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('vet_appointments', [
            'farmer_id' => $farmer->id,
            'farm_id' => $farm->id,
            'service_type' => 'telemedicine',
        ]);

        VetAppointment::where('farmer_id', $farmer->id)
            ->where('farm_id', $farm->id)
            ->where('symptoms_description', 'Test: cow with fever for two days.')
            ->delete();
    }
}
