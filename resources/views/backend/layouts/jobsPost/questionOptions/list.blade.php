@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h1 class="m-0">Question Options</h1>
                <a href="{{ route('question-options.create') }}" class="btn bg-gradient-teal btn-sm">
                    <i class="fas fa-plus-circle"></i> Add New Option
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

                {{-- Error Messages --}}
                @if($errors->any())
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
                        @if($options->isEmpty())
                            <div class="alert alert-info text-center">
                                No question options found. <a href="{{ route('question-options.create') }}">Add a new option</a>
                            </div>
                        @else
                            <table class="table table-bordered table-striped">
                                <thead class="bg-gradient-teal text-white">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Category</th>
                                    <th>Options</th>
                                    <th width="20%">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($options as $key => $option)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
{{--                                        <td>{{ $option->question->question_text }}</td>--}}
                                        <td>{{ $option->question->category->name }}</td>
                                        <td>
                                            <ul class="mb-0">
                                                @foreach($option->option_text as $opt)
                                                    <li>{{ $opt }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td style="display:flex; gap:10px;">
                                            <a href="{{ route('question-options.edit', $option->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('question-options.destroy', $option->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="margin:0;">
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
                                {{ $options->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
