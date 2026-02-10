@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <h3>Open Jobs</h3>

        @if($jobs->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Vehicle</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->id }}</td>
                    <td>{{ $job->pickup }}</td>
                    <td>{{ $job->dropoff }}</td>
                    <td>{{ $job->vehicle_type }}</td>
                    <td>{{ $job->notes }}</td>
                    <td>
                        @php
                            // Check if provider already applied
                            $applied = $job->quotes->contains(function($quote) {
                                return auth()->check() && $quote->provider_id == auth()->id();
                            });
                        @endphp

                        @if($applied)
                            <button class="btn btn-secondary btn-sm" disabled>Applied</button>
                        @else
                            <a href="{{ route('provider.jobs.apply', $job->id) }}"
                               class="btn btn-primary btn-sm">
                               Apply
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>No open jobs available.</p>
        @endif

    </div>
</div>
@endsection
