@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-7 py-5 mx-auto">
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header text-center bg-gradient-teal text-white">
                    Add New Category
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

                    {{-- Category Form --}}
                    <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Category Name --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label font-weight-bold">
                                Category Name <i class="text-danger">*</i>
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter category name"
                                       value="{{ old('name') }}" required>
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
                                <input type="file" name="image" id="image"
                                       class="form-control-file @error('image') is-invalid @enderror">
                                @error('image')
                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Form Buttons --}}
                        <div class="form-group row mt-4">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Category
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
