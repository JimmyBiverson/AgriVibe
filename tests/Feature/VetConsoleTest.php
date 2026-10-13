<?php

namespace Tests\Feature;

use App\Livewire\Vet\VetConsole;
use App\Models\User;
use App\Models\VetAppointment;
use Livewire\Livewire;
use Tests\TestCase;

class VetConsoleTest extends TestCase
{
    protected function vet(): User
    {
        return User::where('account_type', 'veterinarian')->firstOrFail();
    }

    protected function makeAppointment(User $vet, array $overrides = []): VetAppointment
    {
        return VetAppointment::create([
            'farmer_id' => User::where('account_type', 'farmer')->value('id'),
            'vet_id' => $vet->id,
            'service_type' => 'telemedicine',
            'scheduled_at' => now()->addDay(),
            'status' => 'pending',
            'urgency' => 'normal',
            'symptoms_description' => 'Test consult.',
            'fee_ugx' => 0,
            ...$overrides,
        ]);
    }

    public function test_vet_console_requires_veterinarian_role(): void
    {
        $farmer = User::where('account_type', 'farmer')->firstOrFail();

        $this->actingAs($farmer)->get('/vet/console')->assertStatus(403);
    }

    public function test_vet_can_view_console(): void
    {
        $this->actingAs($this->vet())->get('/vet/console')->assertStatus(200);
    }

    public function test_vet_can_confirm_their_own_appointment(): void
    {
        $vet = $this->vet();
        $appointment = $this->makeAppointment($vet);

        $this->actingAs($vet);

        Livewire::test(VetConsole::class)
            ->call('confirm', $appointment->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('vet_appointments', [
            'id' => $appointment->id,
            'status' => 'confirmed',
        ]);

        $appointment->delete();
    }

    public function test_vet_can_complete_a_consultation(): void
    {
        $vet = $this->vet();
        $appointment = $this->makeAppointment($vet, ['status' => 'confirmed']);

        $this->actingAs($vet);

        Livewire::test(VetConsole::class)
            ->call('startComplete', $appointment->id)
            ->set('data.diagnosis', 'East Coast Fever')
            ->set('data.prescription', 'Oxytetracycline 20ml')
            ->set('data.fee_ugx', 50000)
            ->call('complete')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('vet_appointments', [
            'id' => $appointment->id,
            'status' => 'completed',
            'diagnosis' => 'East Coast Fever',
        ]);

        $appointment->delete();
    }

    public function test_vet_cannot_act_on_another_vets_appointment(): void
    {
        $vet = $this->vet();
        $farmer = User::where('account_type', 'farmer')->firstOrFail();

        $foreign = $this->makeAppointment($vet, ['vet_id' => $farmer->id]);

        $this->actingAs($vet);

        Livewire::test(VetConsole::class)
            ->call('confirm', $foreign->id)
            ->assertStatus(404);

        $this->assertDatabaseHas('vet_appointments', [
            'id' => $foreign->id,
            'status' => 'pending',
        ]);

        $foreign->delete();
    }
}
