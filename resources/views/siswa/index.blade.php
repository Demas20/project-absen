@extends('master')
@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Data Siswa</h5>
                    <p class="m-b-0">Selamat Data Di halaman data Siswa</p>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="fa fa-user"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Data Siswa</a>
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
                <a href="{{route('siswa.tambah')}}" class="btn btn-success">TAMBAH SISWA</a>
            </div>
        </div>
        <div class="main-body">
            <div class="page-wrapper">
                <table id="siswa" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                    <thead>
                    <tr>
                        <th>
                            NISN
                        </th>
                        <th>
                            Nama
                        </th>
                        <th>Kelas</th>
                        <th>Kelompok</th>
                        <th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($student as $item)
                        <tr>
                            <th>
                                {{$item->NISN}}
                            </th>
                            <th>
                                {{$item->name}}
                            </th>
                            <th>{{$item->class ? $item->class->name : 'Tidak ada kelas'}} - {{$item->class->jurusan->name }}</th>
                            <th>{{$item->group ? $item->group->name : 'Tidak ada grup'}}</th>
                            <td>
                                <a href="" class="btn btn-success"><i class="ti-pencil"></i><b></b></a>
                                <a href="" class="btn btn-danger"><i class="ti-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>
                                NISN
                            </th>
                            <th>
                                Nama
                            </th>
                            <th>Kelas</th>
                            <th>Kelompok</th>
                            <th>Option</th>
                        </tr>
                    </tfoot>
                  </table>
            </div>
            <div id="styleSelector"> </div>
        </div>
    </div>
@endsection
