@extends('layouts.frontend.main')

@section('content')
    <main>
        <div class="container py-4">
            <div class="card p-4">
                @if ($jobs->isEmpty())
                    <div class="card-body text-center">
                        <h5 class="card-title">Belum ada Lowongan yang tersedia</h5>
                        <p class="card-text">Silakan cek kembali nanti.</p>
                    </div>
                @else
                    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                        @foreach ($jobs as $job)
                            <div class="col">
                                <div class="card h-100">
                                    <img class="card-img-top"
                                        src="{{ asset('storage/public/corporations-logos/' . $job->corporation->logo) }}"
                                        alt="{{ $job->judul }}" width="150" height="150" />
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $job->judul }}</h5>
                                        <p class="card-text">
                                            {!! Str::limit($job->deskripsi, 100) !!}
                                        </p>
                                        <p class="card-text"><strong>Lokasi:</strong> {{ $job->lokasi }}</p>
                                        <p class="card-text"><strong>Jenis Pekerjaan:</strong> {{ $job->jenis_pekerjaan }}
                                        </p>
                                        <p class="card-text"><strong>Rentang Gaji:</strong> {{ $job->rentang_gaji }}</p>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="{{ route('bursa.detail', $job->slug) }}" class="btn btn-primary">Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        {{ $jobs->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
