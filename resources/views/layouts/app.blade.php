<!DOCTYPE html>
<html>
<head>
    <title>Quote Marketplace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
     <a class="navbar-brand" href="">Quote Marketplace</a>


      <div class="d-flex">
            @auth
                {{-- Dashboard link based on role --}}
                @if(Auth::user()->role == 'customer')
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-primary btn-sm me-2">Dashboard</a>
                @elseif(Auth::user()->role == 'provider')
                    <a href="{{ route('provider.dashboard') }}" class="btn btn-primary btn-sm me-2">Dashboard</a>
                @endif

                {{-- Logout --}}
                <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">
                   Logout
                </a>

            @else
                {{-- Guest buttons --}}
                <a href="{{ route('login') }}" class="btn btn-light btn-sm me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
            @endauth
        </div>

  </div>
</nav>

<div class="container mt-4">
    {{-- Session Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
