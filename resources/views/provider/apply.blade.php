@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card p-3">
            <h3>Apply for Job #{{ $job->id }}</h3>

            <p>
                <strong>Pickup:</strong> {{ $job->pickup }} <br>
                <strong>Dropoff:</strong> {{ $job->dropoff }} <br>
                <strong>Vehicle:</strong> {{ $job->vehicle_type }}
            </p>

            <form method="POST" action="{{ route('provider.quotes.store') }}">
                @csrf
                <input type="hidden" name="job_id" value="{{ $job->id }}">

                @guest
                {{-- Guest provider fields --}}
                <input type="text" name="name" class="form-control mb-2" placeholder="Your Name" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <input type="email" name="email" class="form-control mb-2" placeholder="Your Email" value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                @endguest

                {{-- Price --}}
                <input type="number" step="0.01" name="price" class="form-control mb-2" placeholder="Price" value="{{ old('price') }}" required>
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- Message --}}
                <textarea name="message" class="form-control mb-2" placeholder="Message" required>{{ old('message') }}</textarea>
                @error('message')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <button type="submit" class="btn btn-success">Submit Quote</button>
                <a href="{{ route('provider.jobs.open') }}" class="btn btn-secondary mt-2">Back</a>
            </form>
        </div>

    </div>
</div>
@endsection
