@extends('layouts.student.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card p-4">
        <h4 class="fw-bold py-3 mb-4">Detail Kehadiran <i class='display-5 bx bxs-user-check'></i></h4>

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="filter" class="form-label">Filter berdasarkan:</label>
                        <select id="filter" class="form-select">
                            <option value="all">Semua</option>
                            <option value="week">Per-Minggu</option>
                            <option value="month">Per-Bulan</option>
                        </select>
                    </div>
                    <div class="col-md-3" id="weekFilter" style="display: none;">
                        <label for="week" class="form-label">Pilih Minggu:</label>
                        <select id="week" class="form-select">
                            @foreach ($weeks as $week)
                                <option value="{{ $week['start'] }}|{{ $week['end'] }}">{{ $week['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3" id="monthFilter" style="display: none;">
                        <label for="month" class="form-label">Pilih Bulan:</label>
                        <select id="month" class="form-select">
                            @foreach ($months as $month)
                                <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="attendanceTable" class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Tanggal</th>
                                <th>Status Kehadiran</th>
                                <th>Jam Absensi</th>
                                <th>Foto/Berkas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td>{{ Carbon::parse($attendance->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        @if ($attendance->keterangan == 'HADIR')
                                            <span class="badge bg-label-success me-1">{{ $attendance->keterangan }}</span>
                                        @elseif(in_array($attendance->keterangan, ['IZIN', 'SAKIT']))
                                            <span class="badge bg-label-warning me-1">{{ $attendance->keterangan }}</span>
                                        @else
                                            <span class="badge bg-label-danger me-1">{{ $attendance->keterangan }}</span>
                                        @endif
                                    <td>{{ Carbon::parse($attendance->created_at)->format('H:i') }}</td>
                                    <td>
                                        @if ($attendance->photo)
                                            {{-- Menampilkan foto kehadiran --}}
                                            <a href="{{ asset('storage/Absents-Siswa/' . $attendance->photo) }}"
                                                target="_blank" class="btn btn-sm btn-primary">
                                                <i class="bx bx-image"></i> Lihat Foto
                                            </a>
                                        @elseif ($attendance->deskripsi)
                                            {{-- Menampilkan file izin/sakit --}}
                                            <a href="{{ asset('storage/' . $attendance->deskripsi) }}" target="_blank"
                                                class="btn btn-sm btn-success">
                                                <i class="bx bx-file"></i> Lihat Berkas
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#attendanceTable').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "pageLength": 25
            });

            $('#filter').change(function() {
                var filter = $(this).val();
                if (filter === 'week') {
                    $('#weekFilter').show();
                    $('#monthFilter').hide();
                } else if (filter === 'month') {
                    $('#monthFilter').show();
                    $('#weekFilter').hide();
                } else {
                    $('#weekFilter').hide();
                    $('#monthFilter').hide();
                    table.search('').columns().search('').draw();
                }
            });

            $('#week').change(function() {
                var dates = $(this).val().split('|');
                var startDate = dates[0];
                var endDate = dates[1];
                table.columns(0).search(startDate + ' to ' + endDate, true, false).draw();
            });

            $('#month').change(function() {
                var month = $(this).val();
                table.columns(0).search(month).draw();
            });
        });
    </script>
@endsection
