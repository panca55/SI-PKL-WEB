@extends('layouts.frontend.main')

@section('content')
    <main>
        <div class="container py-4">
            <div class="p-5 mb-4 bg-light rounded-3">
                <div class="container-fluid py-5">
                    <div class="row">
                        <!-- Bagian Teks -->
                        <div class="col-md-6">
                            <h1 class="display-5 fw-bold">Selamat Datang Di SIGAPKL SMKN 2 PADANG</h1>
                            <p class="col-md-10 fs-4">
                                <span class="fw-bold">"Inovasi Teknologi untuk Pendidikan Berkualitas"</span>
                                <br>SMKN 2 Padang terus berinovasi untuk memberikan yang terbaik bagi siswa.<br>
                                Sistem informasi dan Manajemen PKL adalah bukti nyata komitmen kami dalam mengadopsi
                                teknologi terkini untuk meningkatkan kualitas pendidikan.
                            </p>
                        </div>

                        <!-- Bagian Carousel -->
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"
                                style="width: 400px; height: 300px;">
                                <ol class="carousel-indicators">
                                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active">
                                    </li>
                                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('/assets/img/illustrations/LP1.png') }}" class="d-block w-100"
                                            alt="Slide 1">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('/assets/img/illustrations/LP2.png') }}" class="d-block w-100"
                                            alt="Slide 2">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('/assets/img/illustrations/LP3.png') }}" class="d-block w-100"
                                            alt="Slide 3">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card">
                <h5 class="card-header">TIMELINE PRAKTEK KERJA LAPANGAN</h5>
                <div class="card-body">
                    @if ($informations->isEmpty())
                        <p class="text-muted">Tidak ada informasi yang tersedia.</p>
                    @else
                        <ul class="timeline">
                            @foreach ($informations as $infromation)
                                <li class="timeline-item timeline-item-transparent">
                                    <span class="timeline-point-wrapper"><span
                                            class="timeline-point timeline-point-primary"></span></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header border-bottom mb-3">
                                            <h6 class="mb-0">{{ $infromation->name }}</h6>
                                            <span
                                                class="text-muted">{{ \Carbon\Carbon::parse($infromation->tanggal_mulai)->format('jS F') }}</span>
                                            - <span
                                                class="text-muted">{{ \Carbon\Carbon::parse($infromation->tanggal_berakhir)->format('jS F') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between flex-wrap mb-2">
                                            <div>
                                                <span>{!! $infromation->isi !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
