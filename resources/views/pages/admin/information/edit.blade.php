@extends('layouts.admin.main')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Data Siswa</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin/information.update', $information) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="nama">Judul Informasi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder=""
                            value="{{ $information->nama }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="editor">Isi Informasi</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="isi" name="isi" placeholder="">{{ $information->isi }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_mulai">Tanggal Mulai</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder=""
                            value="{{ $information->tanggal_mulai }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tanggal_berakhir">Tanggal Berakhir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir"
                            placeholder="" value="{{ $information->tanggal_berakhir }}" />
                    </div>
                </div>


                <div class="row justify-content-end">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-sm btn-success mt-3">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#isi'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
