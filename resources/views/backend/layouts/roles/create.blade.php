{{--@extends('backend.partials.master')--}}

{{--@section('content')--}}
{{--    <div class="content-wrapper">--}}

{{--        --}}{{-- ================= Page Header ================= --}}
{{--        <div class="content-header">--}}
{{--            <div class="container-fluid">--}}
{{--                <div class="row mb-2">--}}

{{--                    --}}{{-- Page Title --}}
{{--                    <div class="col-sm-6">--}}
{{--                        <h1>Create Role</h1>--}}
{{--                    </div>--}}

{{--                    --}}{{-- Breadcrumbs --}}
{{--                    <div class="col-sm-6">--}}
{{--                        <ol class="breadcrumb float-sm-right">--}}
{{--                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>--}}
{{--                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>--}}
{{--                            <li class="breadcrumb-item active">Create</li>--}}
{{--                        </ol>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        --}}{{-- /.content-header --}}

{{--        --}}{{-- ================= Main Content ================= --}}
{{--        <section class="content">--}}
{{--            <div class="container-fluid">--}}
{{--                <div class="row justify-content-center">--}}
{{--                    <div class="col-md-8">--}}

{{--                        --}}{{-- Card --}}
{{--                        <div class="card shadow-sm">--}}

{{--                            --}}{{-- Card Header --}}
{{--                            <div class="card-header bg-primary text-white">--}}
{{--                                <h3 class="card-title">Add New Role</h3>--}}
{{--                            </div>--}}

{{--                            --}}{{-- Card Body --}}
{{--                            <div class="card-body">--}}

{{--                                --}}{{-- Create Role Form --}}
{{--                                <form action="{{ route('roles.store') }}" method="POST">--}}
{{--                                    @csrf--}}

{{--                                    --}}{{-- Role Name --}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="font-weight-bold">Role Name</label>--}}
{{--                                        <input type="text" name="name" class="form-control" placeholder="Enter role name" required>--}}
{{--                                    </div>--}}

{{--                                    --}}{{-- Assign Permissions --}}
{{--                                    <div class="form-group mt-3">--}}
{{--                                        <label class="font-weight-bold">Assign Permissions</label>--}}
{{--                                        <div class="row">--}}
{{--                                            @foreach($permissions as $permission)--}}
{{--                                                <div class="col-md-4">--}}
{{--                                                    <div class="form-check">--}}
{{--                                                        <input type="checkbox"--}}
{{--                                                               name="permissions[]"--}}
{{--                                                               value="{{ $permission->name }}"--}}
{{--                                                               class="form-check-input"--}}
{{--                                                               id="perm{{ $permission->id }}">--}}
{{--                                                        <label class="form-check-label" for="perm{{ $permission->id }}">--}}
{{--                                                            {{ $permission->name }}--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    --}}{{-- Form Buttons --}}
{{--                                    <div class="d-flex justify-content-between mt-4">--}}
{{--                                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">--}}
{{--                                            <i class="fas fa-arrow-left"></i> Back--}}
{{--                                        </a>--}}
{{--                                        <button type="submit" class="btn btn-primary">--}}
{{--                                            <i class="fas fa-save"></i> Create Role--}}
{{--                                        </button>--}}
{{--                                    </div>--}}

{{--                                </form>--}}

{{--                            </div> --}}{{-- /.card-body --}}
{{--                        </div> --}}{{-- /.card --}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--        --}}{{-- /.content --}}

{{--    </div>--}}
{{--@endsection--}}


@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-8 py-5 mx-auto">
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header text-center bg-gradient-teal text-white">
                    Add New Role
                </div>

                <div class="card-body">

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Create Role Form --}}
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        {{-- Role Name --}}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label font-weight-bold">Role Name <i class="text-danger">*</i></label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" placeholder="Enter role name" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        {{-- Assign Permissions --}}
                        <div class="form-group row mt-3">
                            <label class="col-md-3 col-form-label font-weight-bold">Assign Permissions</label>
                            <div class="col-md-9">
                                <div class="row">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" id="perm{{ $permission->id }}">
                                                <label class="form-check-label" for="perm{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Form Buttons --}}
                        <div class="form-group row mt-4">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Role
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
