@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-7 py-5 mx-auto">
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header text-center bg-gradient-teal text-white">
                    Edit Category
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

                    {{-- Category Edit Form --}}
                    <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Category Name --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label font-weight-bold">
                                Category Name <i class="text-danger">*</i>
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter category name"
                                       value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Category Image --}}
                        <div class="form-group row mt-3">
                            <label for="image" class="col-md-3 col-form-label font-weight-bold">
                                Category Image
                            </label>
                            <div class="col-md-9">
                                @if($category->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" width="120" class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image"
                                       class="form-control-file @error('image') is-invalid @enderror">
                                @error('image')
                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Leave empty to keep current image.</small>
                            </div>
                        </div>

                        {{-- Form Buttons --}}
                        <div class="form-group row mt-4">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Category
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
