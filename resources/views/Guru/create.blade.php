@extends('master')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Data Guru</h5>
                    <p class="m-b-0">Form Tambah Guru</p>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tambah Guru</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">

        <div class="card">
            <div class="card-header">
                <h5>Form Tambah Guru</h5>
            </div>
            <div class="card-block">
                <form class="form-material">
                    <div class="form-group form-default">
                        <input type="text" name="NIP" class="form-control" required="">
                        <span class="form-bar"></span>
                        <label class="float-label">NIP</label>
                    </div>
                    <div class="form-group form-primary">
                        <input type="text" name="name" class="form-control" required="">
                        <span class="form-bar"></span>
                        <label class="float-label">Nama</label>
                    </div>
                    <div class="form-group form-danger">
                        <input type="text" name="footer-email" class="form-control" required="">
                        <span class="form-bar"></span>
                        <label class="float-label">Username</label>
                    </div>
                    {{-- <div class="form-group form-warning">
                        <input type="text" name="footer-email" class="form-control" required="">
                        <span class="form-bar"></span>
                        <label class="float-label">form-warning</label>
                    </div>
                    <div class="form-group form-info">
                        <input type="text" name="footer-email" class="form-control" required="">
                        <span class="form-bar"></span>
                        <label class="float-label">form-info</label>
                    </div> --}}

                    <button class="btn btn-success">TAMBAH</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
