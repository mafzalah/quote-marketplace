@extends('layouts.app')

@section('content')
<h3>Customer Dashboard</h3>

<div class="card p-3">
  <a href="{{ route('customer.jobs.create') }}" class="btn btn-primary mb-2">Create Job</a>
  <a href="{{ route('customer.jobs.index') }}" class="btn btn-info">My Jobs</a>
</div>

@endsection
