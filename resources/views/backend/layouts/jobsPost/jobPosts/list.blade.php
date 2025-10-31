@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        {{-- Page Header --}}
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">Job Posts</h1>
                <a href="{{ route('job_posts.create') }}" class="btn bg-gradient-teal btn-sm">
                    <i class="fas fa-plus-circle"></i> Add Job Post
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

                <div class="card shadow-sm">
                    <div class="card-body">

                        @if($jobPosts->isEmpty())
                            <div class="alert alert-info text-center">
                                No job posts found. <a href="{{ route('job_posts.create') }}">Add new job post</a>
                            </div>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead class="bg-gradient-teal text-white">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>HomeOwner</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Image</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Questions & Options</th>
                                    <th width="15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($jobPosts as $key => $post)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>{{ $post->category->name }}</td>
                                        <td>{{ $post->location }}</td>

                                        {{-- Image --}}
                                        <td>
                                            @if($post->image)
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="Job Image" width="80" height="80" style="object-fit:cover; border-radius:5px;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>

                                        <td>{{ $post->start_date?->format('Y-m-d') }}</td>
                                        <td>{{ $post->end_date?->format('Y-m-d') }}</td>

                                        {{-- Questions & Options --}}
                                        <td>
                                            <strong>Questions:</strong>
                                            <ul class="mb-1">
                                                @if(!empty($post->questions_id))
                                                    @foreach($post->questions_id as $question)
                                                        <li>{{ $question }}</li>
                                                    @endforeach
                                                @else
                                                    <li>No Questions Found</li>
                                                @endif
                                            </ul>

                                            <strong>Options:</strong>
                                            <ul class="mb-0">
                                                @if(!empty($post->question_options_id))
                                                    @foreach($post->question_options_id as $option)
                                                        <li>{{ $option }}</li>
                                                    @endforeach
                                                @else
                                                    <li>No Options Found</li>
                                                @endif
                                            </ul>
                                        </td>

                                        {{-- Actions --}}
                                        <td style="display: flex; gap: 5px;">
                                            <a href="{{ route('job_posts.edit', $post->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('job_posts.destroy', $post->id) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this job post?');" style="margin:0;">
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
                                {{ $jobPosts->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
