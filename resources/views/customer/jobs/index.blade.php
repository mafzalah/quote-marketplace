@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <h3>My Jobs</h3>



        <a href="{{ route('customer.jobs.create') }}" class="btn btn-primary mb-3">Create New Job</a>

        @if($jobs->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Vehicle Type</th>
                    <th>Status</th>
                    <th>Quotes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->id }}</td>
                    <td>{{ $job->pickup }}</td>
                    <td>{{ $job->dropoff }}</td>
                    <td>{{ $job->vehicle_type }}</td>
                    <td>
                        @if($job->status == 'OPEN')
                            <span class="badge bg-warning text-dark">{{ $job->status }}</span>
                        @elseif($job->status == 'ACCEPTED')
                            <span class="badge bg-success">{{ $job->status }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $job->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('customer.jobs.quotes', $job->id) }}" class="btn btn-info btn-sm">
                            View Quotes ({{ $job->quotes->count() }})
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>No jobs created yet.</p>
        @endif

    </div>
</div>
@endsection
