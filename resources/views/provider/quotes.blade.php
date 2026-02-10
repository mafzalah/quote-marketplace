@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">

        <h3>My Quotes</h3>

        @if($quotes->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Job ID</th>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Vehicle</th>
                    <th>Price</th>
                    <th>Message</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotes as $quote)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $quote->job->id }}</td>
                    <td>{{ $quote->job->pickup }}</td>
                    <td>{{ $quote->job->dropoff }}</td>
                    <td>{{ $quote->job->vehicle_type }}</td>
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
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>You have not submitted any quotes yet.</p>
        @endif

    </div>
</div>
@endsection
