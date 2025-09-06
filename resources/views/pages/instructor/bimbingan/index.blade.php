@extends('layouts.corporation.main')

@section('content')
    <div class="card p-4">
        <h5 class="card-header">Siswa Bimbingan</h5>
        <div class="table-responsive text-nowrap">
            <table id="example" class="table table-striped">
                <thead>
                    <tr class="bg-primary">
                        <th class="text-white">No</th>
                        <th class="text-white">Nama Siswa</th>
                        <th class="text-white">Jurusan</th>
                        <th class="text-white">Nama Guru Pembimbing</th>
                        <th class="text-white">Keterangan Absen Harian</th>
                        <th class="text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($internships as $internship)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $internship->student->nama }}</td>
                            <td>{{ $internship->student->mayor->department->nama }}</td>
                            <td>{{ $internship->teacher->nama }}</td>
                            <td>
                                @if ($internship->absents->isEmpty())
                                    <span class="badge bg-label-danger me-1">Belum Mengisi Absen</span>
                                @else
                                    <span
                                        class="badge bg-label-success me-1">{{ $internship->absents->last()->keterangan }}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-success"
                                    href="{{ route('instructor/bimbingan.show', $internship->id) }}"><i
                                        class="bx bx-show me-1"></i> Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
