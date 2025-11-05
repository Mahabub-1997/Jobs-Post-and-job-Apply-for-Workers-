
@php use Illuminate\Support\Facades\Auth; @endphp
@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        {{-- Page Header --}}
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">Job Posts</h1>
            </div>
        </div>

        {{-- Main Content --}}
        <section class="content mt-3">
            <div class="container-fluid">

                {{-- Success / Error Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body">

                        @if($jobPosts->isEmpty())
                            <div class="alert alert-info text-center">No job posts found.</div>
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
                                    <th width="10%">Apply</th>
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
                                                <img src="{{ asset('storage/' . $post->image) }}" width="80" height="80" style="object-fit:cover; border-radius:5px;">
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
                                                @forelse($post->questions_id ?? [] as $question)
                                                    <li>{{ $question }}</li>
                                                @empty
                                                    <li>No Questions Found</li>
                                                @endforelse
                                            </ul>

                                            <strong>Options:</strong>
                                            <ul class="mb-0">
                                                @forelse($post->question_options_id ?? [] as $option)
                                                    <li>{{ $option }}</li>
                                                @empty
                                                    <li>No Options Found</li>
                                                @endforelse
                                            </ul>
                                        </td>

                                        {{-- Apply Button --}}
                                        <td>
                                            @php
                                                $isTradeperson = Auth::user()->role === 'tradeperson';
                                                $applied = $isTradeperson ? $post->applicants->contains(Auth::id()) : false;
                                            @endphp

                                            <form action="{{ route('job_posts.enroll', ['id' => $post->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-success btn-sm"
                                                        @if($applied || Auth::user()->role === 'admin') disabled @endif>
                                                    {{ $applied ? 'Applied' : 'Apply' }}
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
