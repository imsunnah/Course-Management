@extends('layouts.app')

@section('content')
<div class="row justify-content-center min-vh-100 align-items-center">
    <div class="col-md-6 col-lg-5 col-xl-4">
        {{-- Card: Increased padding, rounded corners, subtle shadow --}}
        <div class="card shadow-lg border-0 rounded-4 p-3">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-5">
                    <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>
                    <h3 class="font-weight-bold mb-2 custom-heading">Welcome Back</h3>
                    <p class="text-muted mb-0">Please login to access your dashboard.</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label custom-label">
                            <i class="fas fa-envelope me-2"></i> Email Address
                        </label>
                        <input type="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label custom-label">
                            <i class="fas fa-lock me-2"></i> Password
                        </label>
                        <input type="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password" placeholder="Enter your password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label text-secondary small">
                                Keep me logged in
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-primary small fw-semibold">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg custom-btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i> Log in
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-semibold">Sign Up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Minimal Custom CSS to apply specific look,
    matching the professional style implied by the original styles.
    */
    .custom-heading {
        color: #1c3d58 !important; /* Darker heading color */
        font-weight: 700 !important;
    }
    .text-primary {
        color: #007BFF !important; /* Standard Bootstrap Blue for links/accents */
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
        transform: translateY(-1px); /* Subtle lift on hover */
    }
    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem; /* Smoother radius */
    }
    .custom-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #495057 !important; /* Clearer label color */
    }
</style>
@endsection
