<!DOCTYPE html>
@php
    use Carbon\Carbon;
@endphp
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Nilai Akhir</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #fafafa;
            font-family: "Times New Roman", serif;
            font-size: 12pt;
        }

        .page {
            margin: 10mm auto;
            background-color: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .nilai {
            text-align: center
        }

        .header img {
            max-width: 100%;
            height: auto;
        }

        .title {
            text-align: center;
            font-size: 18pt;
            margin-top: 20px;
            font-weight: bold;
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
    </style>
</head>

<body>
    <div class="page">
        <div class="header">
            <img src="{{ public_path('assets/img/surat/kopsurat.png') }}" alt="Kop Surat" />
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
                    <th class="nilai">No</th>
                    <th class="nilai">Aspek Penilaian</th>
                    <th class="nilai">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Rata - Rata Nilai Monitoring PKL</td>
                    <td class="nilai">{{ $evaluation->monitoring }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Rata - Rata Nilai Sertifikat PKL</td>
                    <td class="nilai">{{ $evaluation->sertifikat }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Laporan PKL</td>
                    <td class="nilai">{{ $evaluation->logbook }}</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Presentasi</td>
                    <td class="nilai">{{ $evaluation->presentasi }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="nilai">Nilai Akhir</th>
                    <th class="nilai">{{ $evaluation->nilai_akhir }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>Padang, {{ Carbon::parse($evaluation->created_at)->format('d F Y') }}</p>
            <p>Pembimbing,</p>
            <p class="signature">{{ $evaluation->internship->teacher->nama }}</p>
        </div>
    </div>
</body>

</html>
