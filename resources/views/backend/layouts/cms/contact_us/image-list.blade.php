@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid py-3">

            {{-- ================= Upload Form ================= --}}
            <div class="card mb-4 ">
                <div class="card-header bg-gradient-teal">
                    <h3 >Upload Contact Image</h3>
                </div>
                <div class="card-body">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

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

                    {{-- Upload Form --}}
                    <form action="{{ route('web-contact-images.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" class="btn bg-gradient-teal w-100">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            {{-- ================= Contact Images List ================= --}}
            <div class="card">
                <div class="card-header">
                    <h3>All Contact Images</h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        @forelse($contactImages as $image)
                            <div class="col-md-3 mb-4">
                                <div class="card">
                                    <img src="{{ asset('storage/'.$image->image) }}" class="card-img-top" alt="Contact Image">

                                    <div class="card-body text-center">
                                        {{-- Delete Button --}}
                                        <form action="{{ route('web-contact-images.destroy', $image->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this image?')">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">No contact images found.</p>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {{ $contactImages->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
