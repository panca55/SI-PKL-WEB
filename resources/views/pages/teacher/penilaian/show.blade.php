@extends('layouts.teacher.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #fafafa;
            font-size: 12pt;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 10mm auto;
            border: 1px solid #d3d3d3;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100%;
            height: auto;
        }

        .title {
            text-align: center;
            font-size: 18pt;
            margin-top: 20px;
        }

        .info-table {
            margin: 20px auto;
            width: 80%;
            text-transform: capitalize;
        }

        .info-table td {
            padding: 5px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: start;
        }

        .main-table th {
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
            padding-right: 50px;
        }

        .signature {
            margin-top: 80px;
            font-weight: bold;
        }

        @media print {
            .page {
                page-break-after: always;
            }
        }
    </style>

    <body>
        <div class="page">
            <div class="header">
                <img src="{{ asset('/assets/img/surat/kopsurat.png') }}" alt="Kop Surat" />
            </div>

            <p class="title">
                REKAP NILAI PKL TAHUN AJARAN {{ $evaluation->internship->tahun_ajaran }}
            </p>

            <table class="info-table">
                <tr>
                    <td>Nama Siswa</td>
                    <td>:</td>
                    <td>{{ $evaluation->internship->student->nama }}</td>
                </tr>
                <tr>
                    <td>Kompetensi Keahlian</td>
                    <td>:</td>
                    <td>{{ $evaluation->internship->student->mayor->department->nama }}</td>
                </tr>
                <tr>
                    <td>Nama DUDIKA</td>
                    <td>:</td>
                    <td>{{ $evaluation->internship->corporation->nama }}</td>
                </tr>
                <tr>
                    <td>Nama Pembimbing</td>
                    <td>:</td>
                    <td>{{ $evaluation->internship->teacher->nama }}</td>
                </tr>
            </table>

            <table class="main-table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Aspek Penilaian</th>
                        <th class="text-center">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Rata - Rata Nilai Monitoring PKL</td>
                        <td class="text-center">{{ $evaluation->monitoring }}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Rata - Rata Nilai Sertifikat PKL</td>
                        <td class="text-center">{{ $evaluation->sertifikat }}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Laporan PKL</td>
                        <td class="text-center">{{ $evaluation->logbook }}</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Presentasi</td>
                        <td class="text-center">{{ $evaluation->presentasi }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-center">Nilai Akhir</th>
                        <th class="text-center">{{ number_format($evaluation->nilai_akhir, 1) }}</th>
                    </tr>
                </tfoot>
            </table>
            <div class="row mt-5">
                <div class="col-7"></div>
                <div class="col-5">
                    <p class="text-capitalize">
                        Padang, 31 Maret 2024
                        <br />pembimbing,
                    </p>
                    <br /><br /><br /><br />
                    <p class="fw-bold">{{ $evaluation->internship->teacher->nama }}</p>
                </div>
            </div>
        </div>
    </body>
@endsection
