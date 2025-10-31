@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">
        <div class="col-md-8 py-5 mx-auto">

            {{-- ================= CONTACT MESSAGE DETAILS CARD ================= --}}
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header">
                    <h3 class="card-title">Contact Message Details</h3>
                </div>

                {{-- Card Body --}}
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $contact->first_name }} {{ $contact->last_name }}</p>
                    <p><strong>Email:</strong> {{ $contact->email }}</p>
                    <p><strong>Phone:</strong> {{ $contact->phone ?? '-' }}</p>

                    <p><strong>Message:</strong></p>
                    <p>{{ $contact->message }}</p>

                    <hr>

                    <p><strong>Submitted on:</strong> {{ $contact->created_at->format('d M Y, h:i A') }}</p>
                </div>

                {{-- Card Footer --}}
                <div class="card-footer text-end">
                    <a href="{{ route('contact.index') }}" class="btn btn-secondary">
                        Back
                    </a>
                </div>

            </div>

        </div>
    </div>
@endsection
