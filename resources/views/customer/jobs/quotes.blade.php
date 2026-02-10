@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <h3>Quotes for Job #{{ $job->id }}</h3>
        <p>
            <strong>Pickup:</strong> {{ $job->pickup }} |
            <strong>Dropoff:</strong> {{ $job->dropoff }} |
            <strong>Vehicle:</strong> {{ $job->vehicle_type }}
        </p>

        @if($job->quotes->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Provider</th>
                    <th>Email</th>
                    <th>Price</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($job->quotes as $quote)
                <tr>
                    {{-- Provider name + badge in same column --}}
                    <td>
                        {{ $quote->provider->name }}
                        <span class="badge {{ $quote->provider->provider_badge == 'registered' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $quote->provider->provider_badge }}
                        </span>
                    </td>
                    <td>{{ $quote->provider->email }}</td>

                    <td>${{ number_format($quote->price, 2) }}</td>
                    <td>{{ $quote->message }}</td>
                    <td>
                        @if($quote->status == 'PENDING')
                            <span class="badge bg-warning text-dark">{{ $quote->status }}</span>
                        @elseif($quote->status == 'ACCEPTED')
                            <span class="badge bg-success">{{ $quote->status }}</span>
                        @elseif($quote->status == 'REJECTED')
                            <span class="badge bg-danger">{{ $quote->status }}</span>
                        @endif
                    </td>
                    <td>
                        @if($job->status == 'OPEN' && $quote->status == 'PENDING')
                        <form action="{{ route('customer.quotes.accept', $quote->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>No quotes submitted for this job yet.</p>
        @endif

        <a href="{{ route('customer.jobs.index') }}" class="btn btn-secondary mt-3">Back to My Jobs</a>

    </div>
</div>
@endsection
