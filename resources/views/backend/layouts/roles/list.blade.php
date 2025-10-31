@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-10 py-5 mx-auto">

            {{-- ================= Page Header ================= --}}
            <div class="content-header d-flex justify-content-between align-items-center mb-3">
                <h1 class="m-0">Roles</h1>
                <a href="{{ route('roles.create') }}" class="btn bg-gradient-teal btn-sm">
                    <i class="fas fa-plus-circle"></i> Add New Role
                </a>
            </div>
            {{-- /.content-header --}}

            {{-- ================= Main Card ================= --}}
            <div class="card card-primary card-outline">
                <div class="card-body">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Roles Table --}}
                    @if($roles->isEmpty())
                        <div class="alert alert-info text-center">
                            No roles found. <a href="{{ route('roles.create') }}">Add a new role</a>
                        </div>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead class="bg-gradient-teal text-white">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th width="20%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $key => $role)
                                <tr>
                                    <td>{{  $key + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->permissions->pluck('name')->join(', ') }}</td>
                                    <td style="display: flex; align-items: center; gap: 10px;">
                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');" style="margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $roles->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
            {{-- /.card --}}

        </div>
    </div>
@endsection
