<!-- resources/views/pdf/selected_assessments.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selected Assessments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <h1>Penilaian Monitoring</h1>

    @foreach ($assessments as $assessment)
        <h3>{{ $assessment->nama }} - {{ $assessment->internship->student->nama }}</h3>
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
                    <td>{{ $assessment->softskill }}</td>
                    <td>{{ $assessment->deskripsi_softskill }}</td>
                </tr>
                <tr>
                    <td>2. Menerapkan norma, POS dan K3LH yang ada pada dunia kerja (tempat PKL)</td>
                    <td>{{ $assessment->norma }}</td>
                    <td>{{ $assessment->deskripsi_norma }}</td>
                </tr>
                <tr>
                    <td>3. Menerapkan kompetensi teknis yang sudah dipelajari di sekolah dan/atau baru dipelajari pada
                        dunia kerja (tempat PKL)</td>
                    <td>{{ $assessment->teknis }}</td>
                    <td>{{ $assessment->deskripsi_teknis }}</td>
                </tr>
                <tr>
                    <td>4. Memahami alur bisnis dunia kerja tempat PKL</td>
                    <td>{{ $assessment->pemahaman }}</td>
                    <td>{{ $assessment->deskripsi_pemahaman }}</td>
                </tr>
                <tr>
                    <td>5. Catatan</td>
                    <td></td>
                    <td>{{ $assessment->catatan ?? '' }}</td>
                </tr>
            </tbody>
        </table>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
