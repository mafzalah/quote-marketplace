@extends('layouts.app')

@section('content')
<h3>Provider Dashboard</h3>

<div class="card p-3">
  <a href="{{ route('provider.jobs.open') }}" class="btn btn-warning mb-2">View Open Jobs</a>
  <a href="{{ route('provider.quotes.my') }}" class="btn btn-secondary">My Quotes</a>
</div>

@endsection
