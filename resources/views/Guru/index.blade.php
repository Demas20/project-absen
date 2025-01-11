@extends('master')
@section('content')
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Data Guru</h5>
                        <p class="m-b-0">Selamat Data Di halaman data guru</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-user"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Data Guru</a>
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
                <a href="{{route('guru.tambah')}}" class="btn btn-success">TAMBAH GURU</a>
            </div>
        </div>
        <div class="main-body">
            <div class="page-wrapper">
                <table id="guru" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                    <thead>
                    <tr>
                        <th>
                            NIP
                        </th>
                        <th>
                            Nama
                        </th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($teacher as $item)
                        <tr>
                            <td>{{$item->NIP}}</td>
                            <td>{{$item->name}}</td>
                            <td style="color: red">{{$item->status_login}}</td>
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
                                NIP
                            </th>
                            <th>
                                Nama
                            </th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </tfoot>
                  </table>
            </div>
            <div id="styleSelector"> </div>
        </div>
    </div>
@endsection
