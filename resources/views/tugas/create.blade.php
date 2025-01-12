@extends('master')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Data Tugas</h5>
                    <p class="m-b-0">Form Tambah Tugas</p>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tambah Tugas</a>
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
                <h5>Form Tambah Tugas</h5>
            </div>
            <div class="card-block">
                <form class="form-material" action="{{route('tugas.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Pemberitahuan Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Pemberitahuan Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="form-group form-primary">
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        <span class="form-bar"></span>
                        <label class="float-label">Nama Tugas</label>
                        <small id="name-feedback" class="text-danger"></small>
                    </div>
                    <div class="form-group form-primary">
                        <textarea name="description" class="form-control" id="" placeholder="Deskripsi" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group form-warning">
                        <label class="form-text">Deadline</label>
                        <input type="datetime-local" name="deadline" class="form-control" required>
                    </div>
                    <div class="form-group form-info">
                        <label class="form-text">File Word / Excel</label>
                        <input type="file" id="file" name="file" accept=".doc,.docx,.xls,.xlsx" required>
                    </div>
                    <div class="form-group form-success">
                        <label for="mapel_id">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control" id="mapel_id">
                            @foreach ($mapel as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success">TAMBAH</button>
                </form>

            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('name').addEventListener('input', function () {
        const name = this.value; // Ambil nilai input nama
        const feedback = document.getElementById('name-feedback'); // Target feedback untuk nama

        if (name.trim() !== '') {
            fetch("{{ route('check.username') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.field === 'name' && data.status === 'error') {
                    feedback.textContent = data.message; // Tampilkan pesan error
                    feedback.style.color = 'red';
                } else {
                    feedback.textContent = 'Nama tersedia.';
                    feedback.style.color = 'green';
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            feedback.textContent = ''; // Kosongkan feedback jika input kosong
        }
    });

    document.getElementById('username').addEventListener('input', function () {
        const username = this.value; // Ambil nilai input username
        const feedback = document.getElementById('username-feedback'); // Target feedback untuk username

        if (username.trim() !== '') {
            fetch("{{ route('check.username') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ username: username })
            })
            .then(response => response.json())
            .then(data => {
                if (data.field === 'username' && data.status === 'error') {
                    feedback.textContent = data.message; // Tampilkan pesan error
                    feedback.style.color = 'red';
                } else {
                    feedback.textContent = 'Username tersedia.';
                    feedback.style.color = 'green';
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            feedback.textContent = ''; // Kosongkan feedback jika input kosong
        }
    });
</script>

@endsection
@section('script')
    
@endsection