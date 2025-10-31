@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-7 py-5 mx-auto">
            <div class="card card-primary card-outline">
                <div class="card-header text-center bg-gradient-teal text-white">
                    Add New Question Options
                </div>

                <div class="card-body">

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}</div>
                    @endif

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('question-options.store') }}" method="POST">
                        @csrf

                        {{-- Select Category --}}
                        <div class="form-group row">
                            <label for="question_id" class="col-md-3 col-form-label font-weight-bold">Category <i class="text-danger">*</i></label>
                            <div class="col-md-9">
                                <select name="question_id" id="question_id" class="form-control @error('question_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($questions as $question)
                                        <option value="{{ $question['id'] }}" {{ old('question_id') == $question['id'] ? 'selected' : '' }}>
                                            [{{ $question['category_name'] }}] {{ $question['question_text'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('question_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Option Texts --}}
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label font-weight-bold">Options <i class="text-danger">*</i></label>
                            <div class="col-md-9">
                                <div id="option-wrapper">
                                    <input type="text" name="option_text[]" class="form-control mb-2" placeholder="Enter option" required>
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="addOption()">+ Add More Option</button>
                            </div>
                        </div>

                        {{-- Form Buttons --}}
                        <div class="form-group row mt-4">
                            <div class="col-md-9 offset-md-3 d-flex justify-content-between">
                                <a href="{{ route('question-options.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Options
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- JS to add more option fields --}}
    <script>
        function addOption() {
            const wrapper = document.getElementById('option-wrapper');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'option_text[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter option';
            input.required = true;
            wrapper.appendChild(input);
        }
    </script>
@endsection
