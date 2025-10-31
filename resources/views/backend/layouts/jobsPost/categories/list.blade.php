@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        {{-- Page Header --}}
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">Categories</h1>
                <a href="{{ route('categories.create') }}" class="btn bg-gradient-teal btn-sm">
                    <i class="fas fa-plus-circle"></i> Add New Category
                </a>
            </div>
        </div>

        {{-- Main Content --}}
        <section class="content mt-3">
            <div class="container-fluid">

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body">
                        @if($categories->isEmpty())
                            <div class="alert alert-info text-center">
                                No categories found. <a href="{{ route('categories.create') }}">Add a new category</a>
                            </div>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead class="bg-gradient-teal text-white">
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Name</th>
                                    <th width="20%">Image</th>
                                    <th width="20%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @if($category->image)
                                                <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" width="80">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td style="display: flex; align-items: center; gap: 10px;">
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" style="margin:0;">
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
                                {{ $categories->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
