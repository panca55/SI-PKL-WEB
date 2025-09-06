<!DOCTYPE html>
<html lang="en">
@php
    use Carbon\Carbon;
@endphp
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sertifikat</title>
    <style>
        @page {
            size: 297mm 210mm;
            margin: 0;
        }

        body {
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 15mm;
            background-color: #ffffff;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .page {
            position: block;
            height: 180mm;
            width: 267mm;
            page-break-after: always;
        }

        .borderhr {
            color: black;
            background-color: black;
            border-color: black;
            height: 5px;
            opacity: 100;
        }

        table {
            font-size: 9pt;
            width: 100%;
            border-collapse: collapse;
        }

        .font-1 {
            font-family: "Great Vibes", cursive;
        }

        .font-2 {
            font-family: "Times New Roman", serif;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-warning {
            color: #ffc107;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .m-0 {
            margin: 0;
        }

        .ms {
            margin-left: 4rem
        }


        .border {
            border: 1px solid #000;
        }

        .border-3 {
            border-width: 3px;
        }

        .border-warning {
            border-color: #ffc107;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .bg-warning {
            background-color: #ffc107;
        }

        .w-100 {
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #000;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- First page content -->
        <div
            style="background-image: url('{{ public_path('assets/img/surat/backgroundSertifikat.png') }}'); background-size: contain; background-position: center; background-repeat: no-repeat; height: 100%; width: 100%; position: absolute; top: 0; left: 0; z-index: -1;">
        </div>
        <div style="position: relative; z-index: 1;">
            <div style="width: 100%; height: 100px;">
                <img src="{{ public_path('storage/public/public/corporations-logos/' . $internship->corporation->logo) }}"
                    style="height: 100px; float: left;" alt="" />
            </div>
            <p class="fw-bold mt-4 font-2 text-center" style="font-size: 40pt">S e r t i f i k a t</p>
            <p class="fw-bold text-center font-1 m-0" style="font-size: 18pt">Diberikan Kepada :</p>
            <p class="fw-bold text-center text-warning mt-4 font-1 m-0" style="font-size: 35pt">
                {{ $internship->student->nama }}</p>
            <p class="mt-4 text-center" style="font-size: 11pt">
                Telah melaksanakan <span class="fw-bold">Praktik Kerja Lapangan</span> di
                <span class="fw-bold">{{ $internship->corporation->nama }}</span> <br />
                dari tanggal {{ Carbon::parse($internship->tanggal_mulai)->format('d F Y') }} s.d
                {{ Carbon::parse($internship->tanggal_berakhir)->format('d F Y') }}, kepada yang bersangkutan
                telah diberikan pelatihan sesuai dengan Bidang/Kompetensi seperti <br />
                tertera dibalik sertifikat ini, dan setelah dilakukan pengamatan yang
                bersangkutan dinyatakan <br />
                <span class="fw-bold">Kompeten</span> dalam bidang tersebut.
            </p>
            <div class="text-center" style="margin-top: 50px;">
                <p class="text-center">
                    Padang, {{ Carbon::parse($internship->tanggal_berakhir)->format('d F Y') }}
                    <br />Pimpinan
                </p>
                <br /><br /><br />
                <p class="fw-bold text-center">
                    <u>{{ $internship->certificate->nama_pimpinan }}</u>
                </p>
            </div>
        </div>
    </div>

    <div class="page">
        <!-- Second page content -->
        <div class="border border-3 border-warning px-4">
            <p class="text-center fw-bold m-0" style="font-size: 14pt">
                DAFTAR NILAI <br />
                PRAKTIK KERJA LAPANGAN
            </p>
            <table class="w-100 text-uppercase fw-bold" style="width: 50%; margin-left:auto;margin-right:auto">
                <tr>
                    <td class="ms p-0">Nama</td>
                    <td class="text-center ">:</td>
                    <td class="">{{ $internship->corporation->nama }}</td>
                </tr>
                <tr>
                    <td class="ms p-0">Kompetensi Keahlian</td>
                    <td class="text-center ">:</td>
                    <td class="">{{ $internship->student->mayor->department->nama }}</td>
                </tr>
                <tr>
                    <td class="ms p-0">Sekolah</td>
                    <td class="text-center ">:</td>
                    <td class="">SMK negeri 2 padang</td>
                </tr>
                <tr>
                    <td class="ms p-0">Tempat praktek kerja lapangan</td>
                    <td class="text-center">:</td>
                    <td class="">{{ $internship->corporation->nama }}</td>
                </tr>
            </table>
            <table class="table-bordered w-100 mt-2">
                <thead class="text-center bg-warning">
                    <tr>
                        <th>NO</th>
                        <th>KOMPETENSI PENILAIAN</th>
                        <th>NILAI</th>
                        <th>PREDIKET</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-warning" style="background-color: rgba(255, 193, 7, 0.5);">
                        <th></th>
                        <th>A. UMUM</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($certificate->where('category', 'UMUM') as $certificates)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $certificates->nama }}</td>
                            <td class="text-center">{{ $certificates->score }}</td>
                            <td class="text-center">{{ $certificates->predikat }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-warning" style="background-color: rgba(255, 193, 7, 0.5);">
                        <th></th>
                        <th>B. KOMPETENSI UTAMA</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($certificate->where('category', 'KOMPETENSI UTAMA') as $certificates)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $certificates->nama }}</td>
                            <td class="text-center">{{ $certificates->score }}</td>
                            <td class="text-center">{{ $certificates->predikat }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-warning" style="background-color: rgba(255, 193, 7, 0.5);">
                        <th></th>
                        <th>C. KOMPETENSI PENUNJANG</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($certificate->where('category', 'KOMPETENSI PENUNJANG') as $certificates)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $certificates->nama }}</td>
                            <td class="text-center">{{ $certificates->score }}</td>
                            <td class="text-center">{{ $certificates->predikat }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br />
            <div class="text-end" style="font-size: 9pt">
                <p class="">
                    Padang, {{ Carbon::parse($internship->tanggal_berakhir)->format('d F Y') }}
                    <br />Instruktur,
                </p>
                <br /><br /><br />
                <p class="fw-bold">
                    <u>{{ $internship->instructor->nama }}</u>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
