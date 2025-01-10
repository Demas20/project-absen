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
                    <tr><th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending">Rendering engine</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Browser</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Platform(s)</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Engine version</th><th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="display: none;">CSS grade</th></tr>
                    </thead>
                    <tbody>
                    <tr class="odd">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Firefox 1.0</td>
                      <td>Win 98+ / OSX.2+</td>
                      <td>1.7</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="even">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Firefox 1.5</td>
                      <td>Win 98+ / OSX.2+</td>
                      <td>1.8</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="odd">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Firefox 2.0</td>
                      <td>Win 98+ / OSX.2+</td>
                      <td>1.8</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="even">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Firefox 3.0</td>
                      <td>Win 2k+ / OSX.3+</td>
                      <td>1.9</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="odd">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Camino 1.0</td>
                      <td>OSX.2+</td>
                      <td>1.8</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="even">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Camino 1.5</td>
                      <td>OSX.3+</td>
                      <td>1.8</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="odd">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Netscape 7.2</td>
                      <td>Win 95+ / Mac OS 8.6-9.2</td>
                      <td>1.7</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="even">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Netscape Browser 8</td>
                      <td>Win 98SE+</td>
                      <td>1.7</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="odd">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Netscape Navigator 9</td>
                      <td>Win 98+ / OSX.2+</td>
                      <td>1.8</td>
                      <td style="display: none;">A</td>
                    </tr><tr class="even">
                      <td class="dtr-control sorting_1" tabindex="0">Gecko</td>
                      <td>Mozilla 1.0</td>
                      <td>Win 95+ / OSX.1+</td>
                      <td>1</td>
                      <td style="display: none;">A</td>
                    </tr></tbody>
                    <tfoot>
                    <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1" style="display: none;">CSS grade</th></tr>
                    </tfoot>
                  </table>
            </div>
            <div id="styleSelector"> </div>
        </div>
    </div>
@endsection
