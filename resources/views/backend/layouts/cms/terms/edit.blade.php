@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-8 py-5 mx-auto">
            <div class="card card-primary card-outline">
                <div class="card-header text-center">
                    Edit Term & Condition
                </div>
                <div class="card-body">

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('terms.update', $term->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="form-group">
                            <label>Title <i class="text-danger">*</i></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $term->title) }}" required>
                        </div>

                        {{-- Sub-title + Description --}}
                        <div class="form-group">
                            <label>Sub Title & Description</label>
                            <div id="sub-items">
                                @php
                                    $subtitles = old('sub_title', array_column($term->content ?? [], 'subtitle'));
                                    $descriptions = old('description', array_column($term->content ?? [], 'description'));
                                @endphp

                                @if($subtitles)
                                    @foreach($subtitles as $i => $st)
                                        <div class="sub-item mb-2">
                                            <input type="text" name="sub_title[]" class="form-control mb-1" value="{{ $st }}" placeholder="Sub Title" required>
                                            <textarea name="description[]" class="form-control" placeholder="Description">{{ $descriptions[$i] ?? '' }}</textarea>
                                            <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeItem(this)">Remove</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="sub-item mb-2">
                                        <input type="text" name="sub_title[]" class="form-control mb-1" placeholder="Sub Title" required>
                                        <textarea name="description[]" class="form-control" placeholder="Description"></textarea>
                                        <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeItem(this)">Remove</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addItem()">+ Add More</button>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Update Term</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addItem() {
            const container = document.getElementById('sub-items');
            const div = document.createElement('div');
            div.classList.add('sub-item', 'mb-2');
            div.innerHTML = `
            <input type="text" name="sub_title[]" class="form-control mb-1" placeholder="Sub Title" required>
            <textarea name="description[]" class="form-control" placeholder="Description"></textarea>
            <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeItem(this)">Remove</button>
        `;
            container.appendChild(div);
        }

        function removeItem(button) {
            button.parentElement.remove();
        }
    </script>
@endsection

