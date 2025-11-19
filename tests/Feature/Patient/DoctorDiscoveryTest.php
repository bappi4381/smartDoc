<?php

namespace Tests\Feature\Patient;

use App\Models\DiagnosticCenter;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorDiscoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_without_selected_center_is_redirected(): void
    {
        $patient = Patient::factory()->create();

        $this->actingAs($patient->user)
            ->get(route('patient.doctors.index'))
            ->assertRedirect(route('patient.diagnostic-centers.index'));
    }

    public function test_patient_can_view_doctor_listing_with_ai_recommendations(): void
    {
        $patient = Patient::factory()->create();
        $center = DiagnosticCenter::factory()->create(['name' => 'City Health Hub']);

        Doctor::factory()
            ->for($center, 'diagnosticCenter')
            ->create([
                'specialization' => 'Cardiology',
                'experience_years' => 12,
                'rating' => 4.8,
                'consultation_fee' => 1200,
            ]);

        Doctor::factory()
            ->for($center, 'diagnosticCenter')
            ->create([
                'specialization' => 'Dermatology',
                'experience_years' => 6,
                'rating' => 4.2,
                'consultation_fee' => 900,
            ]);

        $response = $this->actingAs($patient->user)
            ->withSession([
                'patient.selected_center_id' => $center->id,
                'patient.selected_center_name' => $center->name,
                'patient.ai_recommendations' => [
                    'specializations' => ['Cardiology'],
                    'primary_prediction' => 'Cardiac risk',
                    'generated_at' => now()->toIso8601String(),
                ],
            ])
            ->get(route('patient.doctors.index', [
                'min_rating' => 4,
            ]));

        $response->assertOk();
        $response->assertSee('Cardiology', false);
        $response->assertSee('AI recommended', false);
    }
}


