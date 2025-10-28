@extends('layouts.app')

@section('content')
<div class="row justify-content-center min-vh-100 align-items-center">
    {{-- Adjusted column size slightly larger for the four fields --}}
    <div class="col-md-7 col-lg-5 col-xl-4">
        {{-- Card: Increased padding, rounded corners, subtle shadow --}}
        <div class="card shadow-lg border-0 rounded-4 p-3">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-5">
                    {{-- Icon for Registration --}}
                    <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                    <h3 class="font-weight-bold mb-2 custom-heading">Create Your Account</h3>
                    <p class="text-muted mb-0">Join us to get started!</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label custom-label">
                            <i class="fas fa-user me-2"></i> Full Name
                        </label>
                        <input type="text" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name" />
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label custom-label">
                            <i class="fas fa-envelope me-2"></i> Email Address
                        </label>
                        <input type="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label custom-label">
                            <i class="fas fa-lock me-2"></i> Password
                        </label>
                        <input type="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password" placeholder="Minimum 8 characters" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label custom-label">
                            <i class="fas fa-lock-open me-2"></i> Confirm Password
                        </label>
                        <input type="password" id="password_confirmation" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                               name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter your password" />
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg custom-btn-primary">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold">Log in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Reusing the same minimal custom CSS for consistent styling (copied from the Login example) --}}
<style>
    .custom-heading {
        color: #1c3d58 !important;
        font-weight: 700 !important;
    }
    .text-primary {
        color: #007BFF !important;
    }
    .btn-primary, .custom-btn-primary {
        background-color: #007BFF;
        border-color: #007BFF;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .custom-btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: translateY(-1px);
    }
    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }
    .custom-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #495057 !important;
    }
</style>
@endsection
