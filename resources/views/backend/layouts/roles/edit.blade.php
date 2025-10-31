@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-8 py-5 mx-auto">
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header text-center bg-gradient-teal text-white">
                    Update Role
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

                    {{-- Edit Role Form --}}
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Role Name --}}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label font-weight-bold">Role Name <i class="text-danger">*</i></label>
                            <div class="col-md-9">
                                <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
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
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" id="perm{{ $permission->id }}"
                                                    {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
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
                                    <i class="fas fa-save"></i> Update Role
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
