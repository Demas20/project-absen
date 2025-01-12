@extends('master')
@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Data tugas</h5>
                    <p class="m-b-0">Selamat Data Di halaman Data tugas</p>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="fa fa-user"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Data tugas</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="card">
        <div class="card-header">
            <a href="{{route('kelas.tambah')}}" class="btn btn-success">TAMBAH KELAS</a>
            <a href="{{route('jurusan.tambah')}}" class="btn btn-info">TAMBAH JURUSAN</a>
            <a href="{{route('tugas.tambah')}}" class="btn btn-warning">TAMBAH TUGAS</a>
            <a href="{{route('mapel.tambah')}}" class="btn btn-danger">TAMBAH MAPEL</a>
        </div>
    </div>
    <div class="main-body">
        <div class="page-wrapper">
            <table id="siswa" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                <thead>
                <tr>
                    <th>Nama Tugas</th>
                    <th>Deskripsi</th>
                    <th>Deadline</th>
                    <th>Mata Pelajaran</th>
                    <th>File</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($tugas as $task)
                    <tr>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->deadline }}</td>
                        <td>{{ $task->mapel->name }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $task->file) }}" target="_blank">Download File</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nama Tugas</th>
                        <th>Deskripsi</th>
                        <th>Deadline</th>
                        <th>Mata Pelajaran</th>
                        <th>File</th>
                    </tr>
                </tfoot>
              </table>
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>

@endsection
@section('script')

@endsection
