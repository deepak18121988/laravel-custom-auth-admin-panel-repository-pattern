@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-4">

        <div class="card shadow-sm">
            <div class="card-header text-center">Login</div>

            <div class="card-body">

                <!-- 🔹 Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}">

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror">

                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button class="btn btn-primary w-100">Login</button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
// ✅ Show SweetAlert messages
@if(session('success'))
    Swal.fire('Success', '{{ session('success') }}', 'success');
@endif

@if(session('error'))
    Swal.fire('Error', '{{ session('error') }}', 'error');
@endif
</script>
@endpush