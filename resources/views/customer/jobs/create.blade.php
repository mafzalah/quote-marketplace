@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <h3>Create Job</h3>

        <form method="POST" action="{{ route('customer.jobs.store') }}">
            @csrf

            {{-- Pickup Postcode --}}
            <div class="mb-3">
                <input type="text"
                       name="pickup"
                       placeholder="Pickup Postcode"
                       class="form-control @error('pickup') is-invalid @enderror"
                       value="{{ old('pickup') }}">
                @error('pickup')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dropoff Postcode --}}
            <div class="mb-3">
                <input type="text"
                       name="dropoff"
                       placeholder="Dropoff Postcode"
                       class="form-control @error('dropoff') is-invalid @enderror"
                       value="{{ old('dropoff') }}">
                @error('dropoff')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Vehicle Type --}}
            <div class="mb-3">
                <input type="text"
                       name="vehicle_type"
                       placeholder="Vehicle Type"
                       class="form-control @error('vehicle_type') is-invalid @enderror"
                       value="{{ old('vehicle_type') }}">
                @error('vehicle_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Notes --}}
            <div class="mb-3">
                <textarea name="notes"
                          placeholder="Notes (optional)"
                          class="form-control @error('notes') is-invalid @enderror"
                          rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Job</button>

        </form>

    </div>
</div>
@endsection
