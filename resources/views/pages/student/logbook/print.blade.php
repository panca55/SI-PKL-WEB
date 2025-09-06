<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> {{ config('app.name') }} </title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 0;
            background-color: white;
            position: relative;
        }

        .borderhr {
            border: none;
            border-top: 5px solid black;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .center {
            display: flex;
            justify-content: center
        }

        .table-bordered {
            border: 1px solid black;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .fw-bold {
            font-weight: bold;
        }

        .mt-3 {
            margin-top: 15px;
        }

        .mt-5 {
            margin-top: 40px;
        }

        .w-100 {
            width: 100%;
        }

        .ms-5 {
            margin-left: 20px
        }

        .py-3 {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="page">
        <p class="fw-bold text-center text-uppercase" style="font-size: 14pt;">catatan kegiatan pkl</p>
        <table class="text-capitalize" style="width: 50%">
            <tr>
                <td>nama peserta didik</td>
                <td>:</td>
                <td>{{ $logbook->internship->student->nama }}</td>
            </tr>
            <tr>
                <td>dunia kerja tempat PKL</td>
                <td>:</td>
                <td>{{ $logbook->internship->corporation->nama }}</td>
            </tr>
            <tr>
                <td>nama Instruktur</td>
                <td>:</td>
                <td>{{ $logbook->internship->instructor->nama }}</td>
            </tr>
            <tr>
                <td>nama guru mapel PKL</td>
                <td>:</td>
                <td>{{ $logbook->internship->teacher->nama }}</td>
            </tr>
        </table>
        <table class="w-100">
            <tr>
                <td class="py-3" style="width: 30px;">A.</td>
                <td>Nama Pekerjaan</td>
            </tr>
            <tr>
                <td></td>
                <td style="border: 1px solid black; padding: 5px;">
                    {{ $logbook->judul }}
                </td>
            </tr>
            <tr>
                <td class="py-3">B.</td>
                <td>Uraian</td>
            </tr>
            <tr>
                <td></td>
                <td style="border: 1px solid black; padding: 5px;">
                    {!! $logbook->isi !!}
                </td>
            </tr>
            <tr>
                <td class="py-3">C.</td>
                <td>Foto Pelakasanaan Kegiatan/Hasil</td>
            </tr>
            <tr>
                <td></td>
                <td style="border: 1px solid black; padding: 5px;">
                    <img src="{{ public_path('storage/public/foto-kegiatan/' . $logbook->foto_kegiatan) }}"
                        style="max-height: 150px; max-width: 100%;" alt="" />
                </td>
            </tr>
            <tr>
                <td class="py-3">D.</td>
                <td>Catatan Instruktur</td>
            </tr>
            <tr>
                <td></td>
                <td style="border: 1px solid black; padding: 5px;">
                    {{ $noteInstruktur->catatan ?? 'Belum diisi' }}
                </td>
            </tr>
        </table>
        <table class="mt-5">
            <tr>
                <td style="width: 70%;"></td>
                <td style="width: 30%; text-align: center;">
                    <p class="text-capitalize">Instruktur</p>
                    <br /><br /><br /><br />
                    <p class="fw-bold">{{ $logbook->internship->instructor->nama }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
