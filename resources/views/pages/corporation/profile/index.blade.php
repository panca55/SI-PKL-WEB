@extends('layouts.corporation.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card shadow-lg">
        <div class="card-header text-center bg-primary">
            <h2 class="text-white">{{ $profile->nama }}</h2>
        </div>
        <div class="card-body mt-2">
            <div class="row mb-4">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/public/corporations-logos/' . $profile->logo) }}" class="img-fluid"
                        alt="{{ $profile->nama }}" style="max-height: 150px;">
                </div>
                <div class="col-md-8">
                    <h4 class="text-uppercase">{{ $profile->nama }}</h4>
                    <p><i class='bx bx-map'></i> {{ $profile->alamat }}</p>
                    <p><i class='bx bx-envelope'></i> {{ $profile->email_perusahaan ?? 'Belum ditambahkan' }}</p>
                    <p><i class='bx bx-phone'></i> {{ $profile->hp }}</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <h5><i class='bx bx-calendar'></i> Hari Kerja</h5>
                    <p><strong>{{ $profile->mulai_hari_kerja }} -
                            {{ $profile->akhir_hari_kerja }}</strong></p>
                    <h5><i class='bx bx-time-five'></i> Jam Kerja</h5>
                    <p><strong>{{ Carbon::parse($profile->jam_mulai)->format('H:i') }} -
                            {{ Carbon::parse($profile->jam_berakhir)->format('H:i') }}</strong></p>
                </div>
                <div class="col-md-6 text-center">
                    <h5><i class='bx bx-group'></i> Kuota Siswa</h5>
                    <div class="display-4 text-primary">{{ $profile->quota }}</div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h5><i class='bx bx-info-circle'></i> Deskripsi Perusahaan</h5>
                    <p>{!! $profile->deskripsi !!}</p>
                </div>
            </div>

            <hr>

            <div class="row text-center">
                <div class="col">
                    @if ($profile->website)
                        <a href="https://{{ $profile->website }}" target="_blank" class="btn btn-outline-primary btn-sm"><i
                                class='bx bx-world'></i> Website</a>
                    @endif
                    @if ($profile->instagram)
                        <a href="https://instagram.com/{{ $profile->instagram }}" target="_blank"
                            class="btn btn-outline-primary btn-sm"><i class='bx bxl-instagram'></i>
                            Instagram</a>
                    @endif
                    @if ($profile->tiktok)
                        <a href="https://tiktok.com/{{ $profile->tiktok }}" target="_blank"
                            class="btn btn-outline-primary btn-sm"><i class='bx bxl-tiktok'></i> TikTok</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col text-center mb-4">
            <a href="{{ route('corporation/profile.edit', $profile) }}" class="btn btn-primary">
                Edit Data Pribadi
            </a>
            <small class="text-muted d-block mt-2">
                <i class='bx bx-time'></i> Last updated: {{ $profile->updated_at->format('d M Y, H:i') }}
            </small>
        </div>

    </div>
@endsection
