@extends('layouts.admin.main')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <form id="print-form" action="{{ route('admin/print-selected', $internships->id) }}" method="POST">
        @csrf
        <div class="card p-4">
            <h4>Penilaian Monitoring</h4>
            <div class="d-flex justify-content-end">
                <button type="button" id="print-selected" class="btn btn-danger mb-4"><i class="bx bx-printer me-1"></i>
                    Print Selected</button>
            </div>
            <div class="text-nowrap">
                <table class="table text-center text-nowrap table-border-top-0">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white">
                                <input type="checkbox" id="select-all" />
                                Centang Semua
                            </th>
                            <th class="text-white">No</th>
                            <th class="text-white">Judul Penilaian</th>
                            <th class="text-white">Tanggal Penilaian</th>
                            <th class="text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($internships->assessment as $assessment)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_assessments[]" value="{{ $assessment->id }}" />
                                </td>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $assessment->nama }}</td>
                                <td>{{ Carbon::parse($assessment->created_at)->format('d F Y') }}</td>
                                <td>
                                    <a class="btn btn-success"
                                        href="{{ route('admin/evaluation.detail', $assessment->id) }}"><i
                                            class="bx bx-show-alt me-1"></i> Lihat Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>


    <div class="card p-4 mt-2">
        <h5>Nilai Akhir</h5>
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin/printNilaiakhir', $internships->id) }}" class="btn btn-danger mb-4"><i
                    class="bx bx-printer me-1"></i>
                Print Nilai</a>
        </div>
        @if ($internships->evaluation)
            <table class="table table-bordered">
                <thead class="bg-secondary">
                    <tr>
                        <th scope="col" class="text-white">Komponen</th>
                        <th scope="col" class="text-white">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Penilaian Monitoring</td>
                        <td>{{ $internships->evaluation->monitoring }}</td>
                    </tr>
                    <tr>
                        <td>Rata Rata Nilai Sertifikat</td>
                        <td>{{ $internships->evaluation->sertifikat }}</td>
                    </tr>
                    <tr>
                        <td>Jurnal Harian</td>
                        <td>{{ $internships->evaluation->logbook }}</td>
                    </tr>
                    <tr>
                        <td>Presentasi</td>
                        <td>{{ $internships->evaluation->presentasi }}</td>
                    </tr>
                    <tr class="table-success">
                        <td><strong>Nilai Akhir</strong></td>
                        <td><strong>{{ $internships->evaluation->nilai_akhir }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <h6 class="text-center text-danger">Siswa belum diberi Penilaian</h6>
        @endif
    </div>

    <div class="card p-4 mt-2">
        <h5>Sertifikat Siswa</h5>
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin/printSertifikat', $internships->id) }}" class="btn btn-danger mb-4"><i
                    class="bx bx-printer me-1"></i>
                Print Sertifikat</a>
        </div>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('input[name="selected_assessments[]"]');
            const printButton = document.getElementById('print-selected');
            const printForm = document.getElementById('print-form');

            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
            });

            printButton.addEventListener('click', function() {
                const selectedCheckboxes = document.querySelectorAll(
                    'input[name="selected_assessments[]"]:checked');
                if (selectedCheckboxes.length > 0) {
                    printForm.submit();
                } else {
                    alert('Pilih penilaian untuk di print.');
                }
            });
        });
    </script>
@endsection
