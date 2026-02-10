@extends('layouts.app')

@section('content')
    <h3>Register</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="text" name="name" placeholder="Name" class="form-control mb-2 @error('name') is-invalid @enderror"
            value="{{ old('name') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <input type="email" name="email" placeholder="Email"
            class="form-control mb-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <input type="password" name="password" placeholder="Password"
            class="form-control mb-2 @error('password') is-invalid @enderror" required>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <select id="roleSelect" class="form-select mb-2 @error('role') is-invalid @enderror" name="role" required>
            <option value="">Select Role</option>
            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="provider" {{ old('role') == 'provider' ? 'selected' : '' }}>Provider</option>
        </select>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div id="badgeDiv" style="display:none;">
            <select name="provider_badge" class="form-select mb-2 @error('provider_badge') is-invalid @enderror">
                <option value="registered">Registered</option>
                <option value="unregistered">Unregistered</option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <a href="{{ route('login.show') }}">Already have account?</a>

    <script>
        const roleSelect = document.getElementById('roleSelect');
        const badgeDiv = document.getElementById('badgeDiv');

        function toggleBadge() {
            if (roleSelect.value === 'provider') {
                badgeDiv.style.display = 'block';
            } else {
                badgeDiv.style.display = 'none';
            }
        }

        roleSelect.addEventListener('change', toggleBadge);

        // run on page load (for old values)
        toggleBadge();
    </script>
@endsection
