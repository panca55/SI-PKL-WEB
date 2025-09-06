@extends('layouts.corporation.main')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <div class="card p-4">
        <!-- Job Title and Image -->
        <div class="text-center my-5">
            <h1 class="display-4">{{ $job->judul }}</h1>
            @if ($job->foto)
                <img src="{{ asset('storage/public/foto-bursa-kerja/' . $job->foto) }}" alt="{{ $job->judul }}"
                    class="img-fluid mt-3" width="200" height="200">
            @endif
        </div>

        <!-- Job Details with Icons -->
        <div class="row text-center mt-4">
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-lg border-0">
                    <div class="card-body">
                        <i class="bi bi-briefcase-fill" style="font-size: 2rem; color: #007bff;"></i>
                        <h5 class="card-title mt-3">Jenis Pekerjaan</h5>
                        <p class="card-text">{{ $job->jenis_pekerjaan }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-lg border-0">
                    <div class="card-body">
                        <i class="bi bi-geo-alt-fill" style="font-size: 2rem; color: #28a745;"></i>
                        <h5 class="card-title mt-3">Lokasi</h5>
                        <p class="card-text">{{ $job->lokasi }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-lg border-0">
                    <div class="card-body">
                        <i class="bi bi-cash-stack" style="font-size: 2rem; color: #ffc107;"></i>
                        <h5 class="card-title mt-3">Rentang Gaji</h5>
                        <p class="card-text">Rp. {{ number_format($job->rentang_gaji) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description and Requirements Simplified -->
        <div class="mt-5">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="mb-4">Deskripsi Pekerjaan</h4>
                <p>{!! $job->deskripsi !!}</p>
            </div>

            <div class="card border-0 shadow-sm p-4 mt-4">
                <h4 class="mb-4">Persyaratan</h4>
                <p>{!! $job->persyaratan !!}</p>
            </div>
        </div>

        <!-- Application Deadline and Contact -->
        <div class="mt-5 text-center">
            <h5 class="text-muted">Batas Pengiriman: {{ Carbon::parse($job->batas_pengiriman)->format('d M, Y') }}</h5>
        </div>

        <div class="text-center mt-3">
            <p class="lead">Hubungi: <a href="mailto:{{ $job->contact_email }}"
                    class="text-danger">{{ $job->contact_email }}</a></p>
        </div>
    </div>
@endsection
