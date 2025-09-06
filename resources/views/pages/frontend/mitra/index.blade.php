@extends('layouts.frontend.main')

@section('content')
    <main>
        <div class="container py-4">
            <div class="card p-4">
                @if ($corporations->isEmpty())
                    <div class="card-body text-center">
                        <h5 class="card-title">Belum ada perusahaan yang tersedia</h5>
                        <p class="card-text">Silakan cek kembali nanti.</p>
                    </div>
                @else
                    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                        @foreach ($corporations as $corporation)
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-img-container">
                                        @if (empty($corporation->logo))
                                            <img class="card-img-top" src="../assets/img/elements/2.jpg"
                                                alt="Card image cap" />
                                        @else
                                            <img class="card-img-top"
                                                src="{{ asset('storage/public/corporations-logos/' . $corporation->logo) }}"
                                                alt="Card image cap" />
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><a
                                                href="{{ route('mitra.detail', $corporation->slug) }}">{{ $corporation->nama }}</a>
                                        </h5>
                                        <p class="card-text">
                                            {!! Str::limit($corporation->deskripsi, 200) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        {{ $corporations->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </main>
    <style>
        .card-img-container {
            height: 300px;
            /* Sesuaikan tinggi sesuai kebutuhan */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
@endsection
