<?php

use App\Models\DiagnosticCenter;
use App\Models\Patient;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('redirects unauthenticated users to login', function () {
    get(route('patient.diagnostic-centers.index'))
        ->assertRedirect(route('login'));
});

it('allows a verified patient to view diagnostic centers', function () {
    $patient = Patient::factory()->create();
    $centers = DiagnosticCenter::factory()->count(3)->create();

    actingAs($patient->user);

    $response = get(route('patient.diagnostic-centers.index'));

    $response->assertOk()
        ->assertViewIs('patient.select-center')
        ->assertViewHas('centers', function ($paginator) use ($centers) {
            return $paginator->total() === $centers->count();
        });

    $response->assertSee($centers->first()->name);
});

it('filters diagnostic centers by specialization', function () {
    $patient = Patient::factory()->create();

    $cardioCenter = DiagnosticCenter::factory()->create([
        'name' => 'Cardio Care Center',
        'specializations' => ['Cardiology', 'General Medicine'],
    ]);

    $dermaCenter = DiagnosticCenter::factory()->create([
        'name' => 'Skin Health Clinic',
        'specializations' => ['Dermatology'],
    ]);

    actingAs($patient->user);

    $response = get(route('patient.diagnostic-centers.index', [
        'specialization' => 'Cardiology',
    ]));

    $response->assertOk()
        ->assertSee($cardioCenter->name)
        ->assertDontSee($dermaCenter->name);
});

it('stores selected diagnostic center in session and redirects to symptom input', function () {
    $patient = Patient::factory()->create();
    $center = DiagnosticCenter::factory()->create();

    actingAs($patient->user);

    post(route('patient.diagnostic-centers.select'), [
        'center_id' => $center->id,
    ])
        ->assertRedirect(route('patient.symptoms.create'))
        ->assertSessionHas('patient.selected_center_id', $center->id)
        ->assertSessionHas('status');
});

it('rejects inactive diagnostic centers during selection', function () {
    $patient = Patient::factory()->create();
    $inactiveCenter = DiagnosticCenter::factory()->inactive()->create();

    actingAs($patient->user);

    post(route('patient.diagnostic-centers.select'), [
        'center_id' => $inactiveCenter->id,
    ])
        ->assertRedirect()
        ->assertSessionHasErrors('center_id');
});

