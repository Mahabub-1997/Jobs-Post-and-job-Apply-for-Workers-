@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">Edit Job Post</h1>
                <a href="{{ route('job_posts.index') }}" class="btn bg-gradient-teal btn-sm">Back</a>
            </div>
        </div>

        <section class="content mt-3">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

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

                        {{-- Category Select Form --}}
                        <form action="{{ route('job_posts.edit', $jobPost->id) }}" method="GET">
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category" class="form-control" onchange="this.form.submit()">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ ($categoryId ?? $jobPost->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        {{-- JobPost Edit Form --}}
                        <form action="{{ route('job_posts.update', $jobPost->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label>HomeOwner</label>
                                <select name="user_id" class="form-control" required>
                                    <option value="">Select HomeOwner</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $jobPost->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="category_id" value="{{ $categoryId ?? $jobPost->category_id }}">

                            {{-- Questions --}}
                            <div class="mb-3">
                                <label>Questions</label>
                                @if(isset($questions) && count($questions) > 0)
                                    @foreach($questions as $question)
                                        <input type="text" name="questions_id[]" class="form-control mb-2"
                                               value="{{ implode(', ', $question->questions) }}" readonly>
                                    @endforeach
                                @else
                                    <input type="text" class="form-control" value="No Questions Found" readonly>
                                @endif
                            </div>

                            {{-- Question Options --}}
                            <div class="mb-3">
                                <label>Question Options</label>
                                @if(isset($questionOptions) && count($questionOptions) > 0)
                                    @foreach($questionOptions as $opt)
                                        <input type="text" name="question_options_id[]" class="form-control mb-2"
                                               value="{{ implode(', ', $opt->option_text) }}" readonly>
                                    @endforeach
                                @else
                                    <input type="text" class="form-control" value="No Options Found" readonly>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" value="{{ $jobPost->location }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Message</label>
                                <textarea name="message" class="form-control">{{ $jobPost->message }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control">
                                @if($jobPost->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $jobPost->image) }}" alt="Job Image" width="100" height="100" style="object-fit:cover; border-radius:5px;">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $jobPost->start_date?->format('Y-m-d') }}">
                            </div>

                            <div class="mb-3">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $jobPost->end_date?->format('Y-m-d') }}">
                            </div>

                            <button type="submit" class="btn bg-gradient-teal">Update</button>
                        </form>

                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
