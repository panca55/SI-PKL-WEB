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
            position: block;
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
    <div class="page"
        style="background-image: url({{ asset('assets/img/surat/backJurnal.png') }}); background-size: 210mm 297mm; background-position: center; background-repeat: no-repeat;">
        <div style="height: 510px;"></div>
        <table class="ms-5 mt-5 text-uppercase fw-bold">
            <tr>
                <td style="width: 220px; padding-top: 20px;">nama dudika</td>
                <td style="width: 20px; padding-top: 20px;">:</td>
                <td style="padding-top: 20px;">{{ $logbook->internship->corporation->nama }}</td>
            </tr>
            <tr>
                <td style="padding-top: 20px;">alamat</td>
                <td style="padding-top: 20px;">:</td>
                <td style="padding-top: 20px;">{{ $logbook->internship->corporation->alamat }}</td>
            </tr>
            <tr>
                <td style="padding-top: 20px;">nama siswa</td>
                <td style="padding-top: 20px;">:</td>
                <td style="padding-top: 20px;">{{ $logbook->internship->student->nama }}</td>
            </tr>
            <tr>
                <td style="padding-top: 20px;">program keahlian</td>
                <td style="padding-top: 20px;">:</td>
                <td style="padding-top: 20px;">{{ $logbook->internship->student->mayor->department->nama }}</td>
            </tr>
            <tr>
                <td style="padding-top: 20px;">Kelas</td>
                <td style="padding-top: 20px;">:</td>
                <td style="padding-top: 20px;">{{ $logbook->internship->student->mayor->nama }}</td>
            </tr>
            <tr>
                <td style="padding-top: 20px;">konsentrasi keahlian</td>
                <td style="padding-top: 20px;">:</td>
                <td style="padding-top: 20px;">{{ $logbook->internship->student->konsentrasi }}</td>
            </tr>
        </table>
        <div style="height: 230px;"></div>
    </div>
</body>

</html>
