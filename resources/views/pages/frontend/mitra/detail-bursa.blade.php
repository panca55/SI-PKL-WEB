@extends('layouts.frontend.main')

@section('content')
    <main>
        <div class="container py-4">
            <div class="card p-4">
                <div class="row">
                    <div class="col-md-4">
                        <img class="img-fluid"
                            src="{{ asset('storage/public/corporations-logos/' . $job->corporation->logo) }}"
                            alt="{{ $job->judul }}" />
                    </div>
                    <div class="col-md-8">
                        <h2>{{ $job->judul }}</h2>
                        <p class="text-muted">Diposting oleh: {{ $job->corporation->nama }}</p>
                        <p><strong>Lokasi:</strong> {{ $job->lokasi }}</p>
                        <p><strong>Jenis Pekerjaan:</strong> {{ $job->jenis_pekerjaan }}</p>
                        <p><strong>Rentang Gaji:</strong> {{ $job->rentang_gaji }}</p>
                        <p><strong>Batas Pengiriman:</strong>
                            {{ \Carbon\Carbon::parse($job->batas_pengiriman)->format('d M Y') }}</p>
                        <p><strong>Contact Email:</strong> <a
                                href="mailto:{{ $job->contact_email }}">{{ $job->contact_email }}</a></p>
                        <h4>Deskripsi Pekerjaan</h4>
                        <p>{{ $job->deskripsi }}</p>
                        <h4>Persyaratan</h4>
                        <p>{{ $job->persyaratan }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
