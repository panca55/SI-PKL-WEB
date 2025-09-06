@extends('layouts.corporation.main')

@section('content')
    <div class="card p-4">
        <div class="border border-3 border-warning p-4">
            <p class="text-center fw-bold m-0" style="font-size: 14pt">
                DAFTAR NILAI <br />
                PRAKTIK KERJA LAPANGAN
            </p>
            <table class="mx-auto text-uppercase fw-bold">
                <tr>
                    <td class="m-0 p-0">Nama</td>
                    <td style="width: 20px" class="text-center m-0 p-0">:</td>
                    <td class="m-0 p-0">{{ $internship->student->nama }}</td>
                </tr>
                <tr>
                    <td class="m-0 p-0">Kompetensi Keahlian</td>
                    <td style="width: 20px" class="text-center m-0 p-0">:</td>
                    <td class="m-0 p-0">{{ $internship->student->mayor->department->nama }}</td>
                </tr>
                <tr>
                    <td class="m-0 p-0">sekolah</td>
                    <td style="width: 20px" class="text-center m-0 p-0">:</td>
                    <td class="m-0 p-0">SMK negeri 2 padang</td>
                </tr>
                <tr>
                    <td class="m-0 p-0">Tempat praktek kerja lapangan</td>
                    <td style="width: 20px" class="text-center m-0 p-0">:</td>
                    <td class="m-0 p-0">{{ $internship->corporation->nama }}</td>
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
                    <tr class="bg-warning" style="--bs-bg-opacity: 0.5">
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
                    <tr class="bg-warning" style="--bs-bg-opacity: 0.5">
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
                    <tr class="bg-warning" style="--bs-bg-opacity: 0.5">
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
        </div>
    </div>
@endsection

{{-- <!DOCTYPE html>
<html lang="en">
@php
    use Carbon\Carbon;
@endphp

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sertifikat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Great+Vibes&display=swap" rel="stylesheet" />
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #fafafa;
            font: 12pt;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            height: 210mm;
            width: 297mm;
            padding: 15mm;
            margin: 10mm auto;
            border: 1px #d3d3d3 solid;
            border-radius: 5px;
            background: white;
            /* background-image: url(Putih\ Hijau\ Simpel\ Profesional\ Sertifikat\ Pelatihan.png);
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat; */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .subpage {
            padding: 1cm;
            border: 5px red solid;
            height: 257mm;
            outline: 2cm #ffeaea solid;
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
        }

        .font-1 {
            font-family: "Great Vibes", cursive;
            font-weight: 400;
            font-style: normal;
        }

        .font-2 {
            font-family: "Bebas Neue", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        @page {
            size: landscape;
            margin: 0;
        }

        @media print {

            html,
            body {
                height: 210mm;
                width: 297mm;
            }

            .page:nth-of-type(n+3) {
                display: none;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="page"
        style="
        background-image: url({{ asset('assets/img/surat/backgroundSertifikat.png') }});
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
      ">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-8">
                <img src="{{ asset('storage/public/corporations-logos/' . $internship->corporation->logo) }}"
                    class="" alt="" height="100" />
            </div>
            <div class="col-3 d-flex align-self-top"></div>
        </div>
        <p class="fw-bold text-center mt-4 font-2 m-0" style="font-size: 40pt">
            S e r t i f i k a t
        </p>
        <p class="fw-bold text-center font-1 m-0" style="font-size: 18pt">
            Diberikan Kepada :
        </p>
        <p class="fw-bold text-center text-warning mt-4 font-1 m-0" style="font-size: 35pt">
            {{ $internship->student->nama }}
        </p>
        <p class="mt-4 text-center" style="font-size: 11pt">
            Telah melaksanakan
            <span class="fw-bold">Praktik Kerja Lapangan</span> di
            <span class="fw-bold">{{ $internship->corporation->nama }}</span> <br />
            dari tanggal {{ Carbon::parse($internship->tanggal_mulai)->format('d F Y') }} s.d
            {{ Carbon::parse($internship->tanggal_berakhir)->format('d F Y') }}, kepada yang bersangkutan
            telah diberikan pelatihan sesuai dengan Bidang/Kompetensi seperti <br />
            tertera dibalik sertifikat ini, dan setelah dilakukan pengamatan yang
            bersangkutan dinyatakan <br />
            <span class="fw-bold">Kompeten</span> dalam bidang tersebut.
        </p>
        <br />
        <div class="text-center">
            <p class="text-center mt-3">
                Padang, {{ Carbon::parse($internship->tanggal_berakhir)->format('d F Y') }}
                <br />Pimpinan
            </p>
            <br /><br /><br />
            <p class="fw-bold text-center">
                <u>TARUDIAL SUKMAWATI</u>
            </p>
        </div>
    </div>

    <div class="page">
        <div class="border border-3 border-warning px-4">
            <p class="text-center fw-bold m-0" style="font-size: 14pt">
                DAFTAR NILAI <br />
                PRAKTIK KERJA LAPANGAN
            </p>
            <table class="mx-auto text-uppercase fw-bold">
                <tr>
                    <td class="m-0 p-0">Nama</td>
                    <td style="width: 20px" class="text-center m-0 p-0">:</td>
                    <td class="m-0 p-0">{{ $internship->corporation->nama }}</td>
                </tr>
                <tr>
                    <td class="m-0 p-0">Kompetensi Keahlian</td>
                    <td style="width: 20px" class="text-center m-0 p-0">:</td>
                    <td class="m-0 p-0">{{ $internship->student->mayor->department->nama }}</td>
                </tr>
                <tr>
                    <td class="m-0 p-0">sekolah</td>
                    <td style="width: 20px" class="text-center m-0 p-0">:</td>
                    <td class="m-0 p-0">SMK negeri 2 padang</td>
                </tr>
                <tr>
                    <td class="m-0 p-0">Tempat praktek kerja lapangan</td>
                    <td style="width: 20px" class="text-center m-0 p-0">:</td>
                    <td class="m-0 p-0">{{ $internship->corporation->nama }}</td>
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
                    <tr class="bg-warning" style="--bs-bg-opacity: 0.5">
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
                    <tr class="bg-warning" style="--bs-bg-opacity: 0.5">
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
                    <tr class="bg-warning" style="--bs-bg-opacity: 0.5">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
<div class="text-center my-3">
    <button onclick="window.print();" class="btn btn-primary">Print Sertifikat</button>
</div> --}}
