@extends('layouts.student.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card p-4">
        <h5 class="card-header p-0 mb-4">
            Jurnal
        </h5>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table">
                <thead>
                    <tr class="text-nowrap bg-primary">
                        <th class="text-white">No</th>
                        <th class="text-white">Tanggal</th>
                        <th class="text-white">Kategori Kegiatan</th>
                        <th class="text-white">Judul Kegiatan</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logbooks as $logbook)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ Carbon::Parse($logbook->tanggal)->format('d M Y') }}</td>
                            <td>{{ $logbook->category }}</td>
                            <td>{{ $logbook->judul }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('student/logbook.show', $logbook) }}">
                                    <i class="bx bx-show-alt me-1"></i>
                                    Lihat
                                </a>
                                <a class="btn btn-danger" href="{{ route('student/logbook.print', $logbook->id) }}">
                                    <i class="bx bx-print-alt me-1"></i>
                                    Print
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
