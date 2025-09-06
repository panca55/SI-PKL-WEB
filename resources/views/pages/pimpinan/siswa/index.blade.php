@extends('layouts.teacher.main')

@section('content')
    <div class="card p-4">
        <h1 class="text-danger">Selamat Datang {{ auth()->user()->name }}</h1>
    </div>
@endsection
