@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-7 py-5 mx-auto">
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header text-center bg-gradient-teal text-white">
                    Add Questions
                </div>

                <div class="card-body">

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
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

                    {{-- Form --}}
                    <form method="POST" action="{{ route('questions.store') }}">
                        @csrf

                        {{-- Select Category --}}
                        <div class="form-group row mb-3">
                            <label for="category_id" class="col-md-3 col-form-label font-weight-bold">Category <i class="text-danger">*</i></label>
                            <div class="col-md-9">
                                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Questions Inputs --}}
                        <div id="questionsWrapper">
                            <div class="form-group row mb-2">
                                <label class="col-md-3 col-form-label font-weight-bold">Question <i class="text-danger">*</i></label>
                                <div class="col-md-9">
                                    <input type="text" name="questions[]" class="form-control" placeholder="Enter question" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-9 offset-md-3">
                                <button type="button" id="addQuestion" class="btn btn-sm btn-secondary mb-2">Add Another Question</button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="form-group row">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Questions
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- JS for adding dynamic inputs --}}
    <script>
        document.getElementById('addQuestion').addEventListener('click', function() {
            let wrapper = document.getElementById('questionsWrapper');
            let div = document.createElement('div');
            div.className = 'form-group row mb-2';
            div.innerHTML = `
            <label class="col-md-3 col-form-label font-weight-bold">Question</label>
            <div class="col-md-9">
                <input type="text" name="questions[]" class="form-control" placeholder="Enter question" required>
            </div>
        `;
            wrapper.appendChild(div);
        });
    </script>
@endsection
