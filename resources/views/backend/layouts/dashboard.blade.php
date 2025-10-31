@extends('backend.partials.master')

@section('content')
    <div class="content-wrapper">

        {{-- ================= Page Header ================= --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    {{-- Page Title --}}
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>

                    {{-- Breadcrumb (currently empty) --}}
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right"></ol>
                    </div>

                </div>
            </div>
        </div>
        {{-- /.content-header --}}

        {{-- ================= Main Content ================= --}}
        <section class="content">
            <div class="container-fluid">

                {{-- ================= Header Info Box ================= --}}
                <div class="row">
                    <div class="col-12">
                        <div class="info-box mb-3 d-flex justify-content-between align-items-center bg-primary text-white">
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 2rem;">My TradeMate</span>
                                <span class="info-box-number" style="font-size: .7rem;">
                                Create your free business profile and receive job leads near you today!
                            </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= Info Boxes ================= --}}
                <div class="row">
                    {{-- Total Users --}}
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3 d-flex justify-content-between align-items-center">
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">Total Users</span>
                                <span class="info-box-number text-primary" style="font-size: 2rem;">
                                {{ $totalUsers ?? 0 }}
                            </span>
                            </div>
                            <span class="info-box-icon bg-white elevation-1 text-dark">
                            <i class="fas fa-users" style="font-size: 2rem;"></i>
                        </span>
                        </div>
                    </div>

                    {{-- Total Blogs --}}
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3 d-flex justify-content-between align-items-center">
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">Total Blogs</span>
                                <span class="info-box-number text-primary" style="font-size: 2rem;">69</span>
                            </div>
                            <span class="info-box-icon bg-white elevation-1 text-dark">
                            <i class="fas fa-newspaper" style="font-size: 2rem;"></i>
                        </span>
                        </div>
                    </div>

                    {{-- Total Listing Plan --}}
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box mb-3 d-flex justify-content-between align-items-center">
                            <div class="info-box-content">
                                <span class="info-box-text fw-bold" style="font-size: 1.5rem;">Total Listing Plan</span>
                                <span class="info-box-number text-primary" style="font-size: 2rem;">69</span>
                            </div>
                            <span class="info-box-icon bg-white elevation-1 text-dark">
                            <i class="fas fa-clipboard-list" style="font-size: 2rem;"></i>
                        </span>
                        </div>
                    </div>
                </div>
                {{-- /.row --}}

                {{-- ================= User Welcome Card ================= --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            {{-- Card Header --}}
                            <div class="card-header">
                                <h5 class="card-title">{{ Auth()->user()->name }} - Dashboard</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                            <i class="fas fa-wrench"></i>
                                        </button>
                                    </div>

                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- /.card-header --}}

                            {{-- Card Body --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        Welcome to {{ Auth()->user()->name }} - Dashboard
                                    </div>
                                </div>
                            </div>
                            {{-- /.card-body --}}

                        </div>
                        {{-- /.card --}}
                    </div>
                </div>
                {{-- /.row --}}

            </div>
            {{-- /.container-fluid --}}
        </section>
        {{-- /.content --}}

    </div>
    {{-- /.content-wrapper --}}
@endsection
