@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid py-4">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1>Privacy Policies</h1>
                <a href="{{ route('privacy.create') }}" class="btn bg-gradient-teal">+ Add Privacy Policy</a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">

                    @if($policies->isEmpty())
                        <div class="alert alert-info text-center">No privacy policies found.</div>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead class="bg-gradient-teal text-white">
                            <tr>
                                <th width="5%">#</th>
                                <th>Title</th>
                                <th>Subtitles & Descriptions</th>
                                <th width="15%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($policies as $key => $policy)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $policy->title }}</td>
                                    <td>
                                        <ul class="mb-0">
                                            @foreach($policy->content as $item)
                                                <li>
                                                    <strong>{{ $item['subtitle'] ?? '-' }}</strong>: {{ $item['description'] ?? '-' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="{{ route('privacy.edit', $policy->id) }}" class="btn btn-sm btn-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('privacy.destroy', $policy->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this privacy policy?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $policies->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

