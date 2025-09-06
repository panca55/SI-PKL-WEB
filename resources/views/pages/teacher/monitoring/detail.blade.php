@extends('layouts.teacher.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="card p-4">
        <style>
            .header {
                margin-bottom: 20px;
            }

            .header h1 {
                font-size: 18px;
                font-weight: bold;
                margin: 0;
            }

            .header h2 {
                font-size: 14px;
                margin: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            td,
            th {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }

            .info td {
                border: none;
                padding: 5px;
            }

            .info-table {
                width: 100%;
                margin-bottom: 20px;
            }

            .tujuan-pembelajaran {
                text-align: center;
            }

            .score-description {
                width: 30%;
            }

            .attendance-table,
            .signature-table {
                margin-top: 20px;
            }

            .signature-table td {
                border: none;
                text-align: center;
                padding-top: 40px;
            }

            .note-row td {
                text-align: center;
            }
        </style>

        <table>
            <tr>
                <td>Nama Peserta Didik</td>
                <td>:</td>
                <td>{{ $assessment->internship->student->nama }}</td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td>{{ $assessment->internship->student->nisn }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $assessment->internship->student->mayor->nama }}</td>
            </tr>
            <tr>
                <td>Program Keahlian</td>
                <td>:</td>
                <td>{{ $assessment->internship->student->mayor->department->nama }}</td>
            </tr>
            <tr>
                <td>Konsentrasi Keahlian</td>
                <td>:</td>
                <td>{{ $assessment->internship->student->konsentrasi }}</td>
            </tr>
            <tr>
                <td>Tempat PKL</td>
                <td>:</td>
                <td>{{ $assessment->internship->corporation->nama }}</td>
            </tr>
            <tr>
                <td>Tanggal PKL</td>
                <td>:</td>
                <td>Mulai: {{ Carbon::parse($assessment->internship->tanggal_mulai)->format('d F Y') }} Selesai:
                    {{ Carbon::parse($assessment->internship->tanggal_berakhir)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Nama Instruktur</td>
                <td>:</td>
                <td>{{ $assessment->internship->instructor->nama }}</td>
            </tr>
            <tr>
                <td>Nama Pembimbing</td>
                <td>:</td>
                <td>{{ $assessment->internship->teacher->nama }}</td>
            </tr>
        </table>
    </div>
    <div class="card p-4 mt-2">
        <table class="border">
            <thead>
                <tr>
                    <th>Tujuan Pembelajaran</th>
                    <th>Skor</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1. Menerapkan <i>soft skills</i> yang dibutuhkan dalam dunia kerja (tempat PKL)</td>
                    <td class="score-description">{{ $assessment->softskill }}</td>
                    <td>{{ $assessment->deskripsi_softskill }}</td>
                </tr>
                <tr>
                    <td>2. Menerapkan norma, POS dan K3LH yang ada pada dunia kerja (tempat PKL)</td>
                    <td class="score-description">{{ $assessment->norma }}</td>
                    <td>{{ $assessment->deskripsi_norma }}</td>
                </tr>
                <tr>
                    <td>3. Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada
                        dunia kerja (tempat PKL)</td>
                    <td class="score-description">{{ $assessment->teknis }}</td>
                    <td>{{ $assessment->deskripsi_teknis }}</td>
                </tr>
                <tr>
                    <td>4. Memahami alur bisnis dunia kerja tempat PKL</td>
                    <td class="score-description">{{ $assessment->pemahaman }}</td>
                    <td>{{ $assessment->deskripsi_pemahaman }}</td>
                </tr>
                <tr>
                    <td>5. {{ $assessment->catatan ?? '-' }}</td>
                    <td class="score-description">{{ $assessment->score ?? '-' }}</td>
                    <td>{{ $assessment->deskripsi_catatan ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
