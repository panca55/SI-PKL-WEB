<!DOCTYPE html>
<html lang="en">

@php
    use Carbon\Carbon;
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lampiran {{ $assessment->nama }} - Daftar Nilai Peserta Didik PKL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

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
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>LAMPIRAN {{ $assessment->nama }}</h1>
            <h2>DAFTAR NILAI PESERTA DIDIK MATA PELAJARAN PKL</h2>
            <h2>SMK Negeri 2 Padang</h2>
            <h2>Tahun Ajaran {{ $assessment->internship->tahun_ajaran }}</h2>
        </div>

        <table class="info-table">
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

        <table>
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
                    <td>5. Catatan</td>
                    <td class="score-description"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <!-- Continuing from the new section -->


        <table class="attendance-table">
            <thead>
                <tr>
                    <th>Kehadiran</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sakit</td>
                    <td>: ………………. Hari</td>
                </tr>
                <tr>
                    <td>Ijin</td>
                    <td>: ………………. Hari</td>
                </tr>
                <tr>
                    <td>Tanpa Keterangan</td>
                    <td>: ………………. Hari</td>
                </tr>
            </tbody>
        </table>

        <table class="signature-table" style="width: 100%;">
            <tr>
                <td>Guru Mapel PKL</td>
                <td></td>
                <td>..................................., 20......</td>
            </tr>
            <tr>
                <td>....................................</td>
                <td></td>
                <td>Instruktur Dunia Kerja</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>....................................</td>
            </tr>
        </table>
    </div>
</body>

</html>
