@extends('layouts.frontend.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <main>
        <style>
            .logo-container {
                max-width: 200px;
                max-height: 200px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .logo-container img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }

            .feedback-container {
                max-height: 300px;
                overflow-y: auto;
            }

            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
            }

            .social-media-list li {
                display: inline-block;
                margin-right: 10px;
            }

            .social-media-list .btn {
                transition: all 0.3s ease;
            }

            .social-media-list .btn:hover {
                transform: translateY(-2px);
            }
        </style>
        <div class="container py-5">
            <div class="card mb-4 shadow">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center justify-content-center p-4">
                        <div class="logo-container">
                            <img src="{{ asset('storage/public/corporations-logos/' . $corporation->logo) }}"
                                class="img-fluid rounded" alt="{{ $corporation->nama }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title">{{ $corporation->nama }}</h1>
                            <p class="card-text">{!! Str::limit($corporation->deskripsi, 200) !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Informasi Perusahaan</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-map-marker-alt me-2"></i> <strong>Alamat:</strong>
                                    {{ $corporation->alamat }}</li>
                                <li class="mb-3"><i class="fas fa-users me-2"></i> <strong>Quota:</strong>
                                    {{ $corporation->quota }} orang</li>
                                <li class="mb-3"><i class="far fa-clock me-2"></i> <strong>Jam Kerja:</strong>
                                    {{ $corporation->mulai_hari_kerja }} - {{ $corporation->akhir_hari_kerja }}
                                    ({{ Carbon::parse($corporation->jam_mulai)->format('H:i') }} -
                                    {{ Carbon::parse($corporation->jam_berakhir)->format('H:i') }})
                                </li>
                                <li class="mb-3"><i class="fas fa-phone me-2"></i> <strong>Telepon:</strong>
                                    <a href="tel:{{ $corporation->hp }}">{{ $corporation->hp }}</a>
                                </li>
                            </ul>

                            @if ($corporation->email_perusahaan || $corporation->website || $corporation->instagram || $corporation->tiktok)
                                <h6 class="mt-4 mb-3">Sosial Media & Kontak:</h6>
                                <ul class="list-unstyled social-media-list">
                                    @if ($corporation->email_perusahaan)
                                        <li class="mb-2">
                                            <a href="mailto:{{ $corporation->email_perusahaan }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="bx bx-envelope me-2"></i>Email
                                            </a>
                                        </li>
                                    @endif
                                    @if ($corporation->website)
                                        <li class="mb-2">
                                            <a href="https://{{ $corporation->website }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm"><i class='bx bx-world'></i>
                                                Website</a>
                                        </li>
                                    @endif
                                    @if ($corporation->instagram)
                                        <li class="mb-2">
                                            <a href="https://instagram.com/{{ $corporation->instagram }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm"><i class='bx bxl-instagram'></i>
                                                Instagram</a>
                                        </li>
                                    @endif
                                    @if ($corporation->tiktok)
                                        <li class="mb-2">
                                            <a href="https://tiktok.com/{{ $corporation->tiktok }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm"><i class='bx bxl-tiktok'></i>
                                                TikTok</a>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Feedback Siswa</h5>
                            @if ($feedbacks->isEmpty())
                                <p class="card-text">Belum ada feedback dari siswa.</p>
                            @else
                                <div class="feedback-container">
                                    @foreach ($feedbacks as $feedback)
                                        <div class="feedback-item mb-3 pb-3 border-bottom">
                                            <h6 class="mb-1">{{ $feedback->student_name }}</h6>
                                            <p class="mb-1">{{ $feedback->content }}</p>
                                            <small class="text-muted">{{ $feedback->created_at->format('d M Y') }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4 shadow">
                <div class="card-body">
                    <h5 class="card-title mb-4">Tentang Perusahaan</h5>
                    <p>{!! $corporation->deskripsi !!}</p>
                </div>
            </div>
        </div>
    </main>

@endsection
