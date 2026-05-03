@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-4">

        <div class="card shadow-sm">
            <div class="card-header text-center">Register</div>

            <div class="card-body">

                <!-- 🔹 Register Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

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
                    <button class="btn btn-success w-100">Register</button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
// ✅ SweetAlert messages
@if(session('success'))
    Swal.fire('Success', '{{ session('success') }}', 'success');
@endif

@if(session('error'))
    Swal.fire('Error', '{{ session('error') }}', 'error');
@endif
</script>
@endpush