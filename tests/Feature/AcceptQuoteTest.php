<?php

use App\Models\CustomerJob;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('accepting one quote rejects others automatically', function () {
    // Create users
    $customer = User::factory()->create(['role' => 'customer']);
    $provider1 = User::factory()->create(['role' => 'provider']);
    $provider2 = User::factory()->create(['role' => 'provider']);

    // Create job
    $job = CustomerJob::create([
        'customer_id' => $customer->id,
        'pickup' => '123',
        'dropoff' => '456',
        'vehicle_type' => 'Car',
        'notes' => null,
        'status' => 'OPEN'
    ]);

    // Create quotes
    $quote1 = Quote::create([
        'job_id' => $job->id,
        'provider_id' => $provider1->id,
        'price' => 100,
        'message' => 'Quote 1',
        'status' => 'PENDING'
    ]);

    $quote2 = Quote::create([
        'job_id' => $job->id,
        'provider_id' => $provider2->id,
        'price' => 120,
        'message' => 'Quote 2',
        'status' => 'PENDING'
    ]);

    // Act as customer and accept quote1
    $this->actingAs($customer)
         ->post(route('customer.quotes.accept', $quote1->id));

    // Assert database changes
    $this->assertDatabaseHas('quotes', [
        'id' => $quote1->id,
        'status' => 'ACCEPTED'
    ]);
    $this->assertDatabaseHas('quotes', [
        'id' => $quote2->id,
        'status' => 'REJECTED'
    ]);

    $this->assertDatabaseHas('customer_jobs', [
        'id' => $job->id,
        'status' => 'ACCEPTED'
    ]);
});
