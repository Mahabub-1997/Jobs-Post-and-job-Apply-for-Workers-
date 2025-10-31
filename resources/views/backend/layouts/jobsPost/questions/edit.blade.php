@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-7 py-5 mx-auto">
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header text-center bg-gradient-teal text-white">
                    Edit Questions
                </div>

                <div class="card-body">

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

                    <form method="POST" action="{{ route('questions.update', $question->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Category Selection --}}
                        <div class="form-group row mb-3">
                            <label for="category_id" class="col-md-3 col-form-label font-weight-bold">Category <i class="text-danger">*</i></label>
                            <div class="col-md-9">
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $question->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Questions Inputs --}}
                        <div id="questionsWrapper">
                            @foreach($question->questions as $q)
                                <div class="form-group row mb-2">
                                    <label class="col-md-3 col-form-label font-weight-bold">Question</label>
                                    <div class="col-md-9">
                                        <input type="text" name="questions[]" class="form-control" value="{{ $q }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Add More Button --}}
                        <div class="form-group row mb-3">
                            <div class="col-md-9 offset-md-3">
                                <button type="button" id="addQuestion" class="btn btn-sm btn-secondary mb-2">Add Another Question</button>
                            </div>
                        </div>

                        {{-- Form Buttons --}}
                        <div class="form-group row">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Questions
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
