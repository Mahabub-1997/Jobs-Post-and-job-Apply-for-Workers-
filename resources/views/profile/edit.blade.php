@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        {{-- ================= Page Header ================= --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    {{-- Page Title --}}
                    <div class="col-sm-6">
                        <h1 class="m-0">Profile Edit</h1>
                    </div>

                    {{-- Breadcrumb (optional) --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back</a>
                            </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        {{-- /.content-header --}}

        {{-- ================= Main Content ================= --}}
        <section class="content">
            <div class="container-fluid">

                {{-- ================= Profile Card ================= --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">

                            {{-- Card Header --}}
                            <div class="card-header">
                                <h3 class="card-title">Edit Profile</h3>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body">
                                {{-- ================= Profile Information ================= --}}
                                <div class="mb-5">
                                    <h5 class="mb-3 text-lg font-weight-bold">Profile Information</h5>

                                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        {{-- Name --}}
                                        <div class="form-group mt-3">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Email --}}
                                        <div class="form-group mt-3">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- Phone Number --}}
                                        <div class="form-group mt-3">
                                            <label for="phone">Phone Number</label>
                                            <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- Profile Image --}}
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image</label>
                                            <input type="file" name="profile_image" class="form-control" id="profile_image">
                                            @if($user->profile_image)
                                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="img-thumbnail mt-2" width="120">
                                            @endif
                                            @error('profile_image')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Save Profile</button>
                                            @if (session('status') === 'profile-updated')
                                                <span class="text-success ml-2">Saved.</span>
                                            @endif
                                        </div>
                                    </form>

                                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                        @csrf
                                    </form>
                                </div>
                                {{-- /.Profile Information --}}

                                <hr>

                                {{-- ================= Update Password ================= --}}
                                <div class="mb-5">
                                    <h5 class="mb-3 text-lg font-weight-bold">Update Password</h5>

                                    <form method="post" action="{{ route('password.update') }}">
                                        @csrf
                                        @method('put')

                                        <div class="form-group">
                                            <label for="current_password">Current Password</label>
                                            <input type="password" name="current_password" class="form-control" id="current_password" required>
                                            @error('current_password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="password">New Password</label>
                                            <input type="password" name="password" class="form-control" id="password" required>
                                            @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="password_confirmation">Confirm New Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                                            @error('password_confirmation')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Update Password</button>
                                            @if (session('status') === 'password-updated')
                                                <span class="text-success ml-2">Saved.</span>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                                {{-- /.Update Password --}}

                                <hr>

                                {{-- ================= Delete Account ================= --}}
                                <div class="mb-3">
                                    <h5 class="mb-3 text-lg font-weight-bold text-danger">Delete Account</h5>

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal">
                                        Delete Account
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="{{ route('profile.destroy') }}">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-danger" id="deleteAccountModalLabel">Confirm Delete Account</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Enter your password to confirm permanent deletion:</p>
                                                        <div class="form-group">
                                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                                            @error('password')
                                                            <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete Account</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- /.Delete Account --}}

                            </div>
                            {{-- /.card-body --}}

                        </div>
                        {{-- /.card --}}
                    </div>
                </div>
                {{-- /.row --}}

            </div>
            {{-- /.container-fluid --}}
        </section>
        {{-- /.content --}}

    </div>
    {{-- /.content-wrapper --}}
@endsection
