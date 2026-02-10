@extends('layouts.app')

@section('content')
<h3>Login</h3>

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="/login">
@csrf
<input class="form-control mb-2" name="email" placeholder="Email">
<input class="form-control mb-2" type="password" name="password" placeholder="Password">
<button class="btn btn-success">Login</button>
</form>
@endsection
