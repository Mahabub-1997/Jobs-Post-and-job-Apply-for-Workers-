@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        {{-- Page Header --}}
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">
                    {{ Auth::user()->hasRole('admin') ? 'All Job Applications' : 'My Job Applications' }}
                </h1>
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

                        @if($appliedJobs->isEmpty())
                            <div class="alert alert-info text-center">No job applications found.</div>
                        @else
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="bg-gradient-teal text-white">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Applicant Email</th>
                                    <th>Job Title</th>
                                    <th>Applied Date</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($appliedJobs as $key => $apply)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $apply->user->email ?? 'N/A' }}</td>
                                        <td>{{ $apply->jobPost->category->name ?? 'N/A' }}</td>
                                        <td>{{ $apply->created_at->format('d M, Y') }}</td>

                                        {{-- Status with admin control --}}
                                        <td>
                                            @if(Auth::user()->hasRole('admin'))
                                                <form action="{{ route('admin.job_applications.update_status', $apply->id) }}" method="POST">
                                                    @csrf
                                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                                        <option value="Applied" {{ $apply->status === 'Applied' ? 'selected' : '' }}>Applied</option>
                                                        <option value="Approved" {{ $apply->status === 'Approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="Rejected" {{ $apply->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                </form>
                                            @else
                                                @php
                                                    $badgeClass = match($apply->status) {
                                                        'Applied' => 'bg-primary',
                                                        'Approved' => 'bg-success',
                                                        'Rejected' => 'bg-danger',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $apply->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $appliedJobs->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection
