@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        {{-- Page Header --}}
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">Job Applications</h1>
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

                        @if($applications->isEmpty())
                            <div class="alert alert-info text-center">
                                No job applications found.
                            </div>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead class="bg-gradient-teal text-white">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Applicant</th>
                                    <th>Category</th>
                                    <th>Subscription</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($applications as $key => $app)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $app->user->name ?? '-' }}</td>
                                        <td>{{ $app->category->name ?? '-' }}</td>
                                        <td>{{ $app->subscription->name ?? '-' }}</td>
{{--                                        <td>{{ $app->subscription->id ?? '-' }}</td>--}}
                                        <td>{{ $app->company_name }}</td>
                                        <td>{{ $app->location }}</td>
                                        <td>{{ $app->phone }}</td>
                                        <td>{{ $app->email }}</td>
                                        <td>
                                            @if(auth()->user()->hasRole('admin'))
                                                <form action="{{ route('job-apply.status', $app->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $app->status === 'active' ? 'btn-success' : 'btn-secondary' }}">
                                                        {{ ucfirst($app->status) }}
                                                    </button>
                                                </form>
                                            @else
                                                @if($app->status === 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($app->payment_status == 'success')
                                                <span class="badge badge-success">Success</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{-- Pagination --}}
                            <div class="mt-3">
                                {{ $applications->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
