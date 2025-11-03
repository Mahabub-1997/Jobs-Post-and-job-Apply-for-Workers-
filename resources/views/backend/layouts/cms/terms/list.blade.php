@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        {{-- Page Header --}}
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">Terms & Conditions</h1>
                <a href="{{ route('terms.create') }}" class="btn bg-gradient-teal">Add New Term</a>
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

                        @if($terms->isEmpty())
                            <div class="alert alert-info text-center">
                                No terms found.
                            </div>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead class="bg-gradient-teal text-white">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Title</th>
                                    <th>Subtitles & Descriptions</th>
                                    <th>Created At</th>
                                    <th width="15%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($terms as $key => $term)
                                    <tr>
                                        <td>{{ $terms->firstItem() + $key }}</td>
                                        <td>{{ $term->title }}</td>
                                        <td>
                                            @foreach($term->content as $item)
                                                <strong>{{ $item['subtitle'] ?? '' }}</strong>: {{ $item['description'] ?? '' }} <br>
                                            @endforeach
                                        </td>
                                        <td>{{ $term->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('terms.edit', $term->id) }}" class="btn btn-sm btn-info" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('terms.destroy', $term->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this term?')" title="Delete">
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
                                {{ $terms->links('pagination::bootstrap-5') }}
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
