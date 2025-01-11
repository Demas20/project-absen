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
                <table id="example2" class="table table-bordered table-hover dataTable dtr-inline collapsed" aria-describedby="example2_info">
                    <thead>
                    <tr>
                        <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending">
                            NIP
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                            Nama
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                            Status
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                            Option
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="display: none;">
                            CSS grade
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($teacher as $item)
                        <tr class="">
                            <td class="dtr-control sorting_1" tabindex="0">{{$item->NIP}}</td>
                            <td>{{$item->name}}</td>
                            <td style="color: red">{{$item->status_login}}<td>
                            <td>1.7</td>
                            <td style="display: none;">A</td>
                          </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending">
                                NIP
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                Nama
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                Status
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                Option
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="display: none;">
                                CSS grade
                            </th>
                        </tr>
                    </tfoot>
                  </table>
            </div>
            <div id="styleSelector"> </div>
        </div>
    </div>
@endsection
