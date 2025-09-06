@extends('layouts.admin.main')

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

        <h3 class="fw-bold">{{ $assessment->nama }} - {{ $assessment->internship->student->nama }}</h3>
        <table class="border">
            <thead class="bg-secondary">
                <tr>
                    <th class="text-white">Tujuan Pembelajaran</th>
                    <th class="text-white">Skor</th>
                    <th class="text-white">Deskripsi</th>
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
    </div>
@endsection
