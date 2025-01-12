@extends('masterSiswa')
@section('content')
<div class="container mt-4">
    <h3>Daftar Tugas</h3>
    <div class="list-group">
        @foreach($tugas as $item)
        <div class="list-group-item">
            <h5>{{ $item->name }}</h5>
            <p>{{ $item->description }}</p>
            <p>Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y, H:i') }}</p>
            <p>Kelas: {{ $item->kelas_name }} | Kelompok: {{ $item->kelompok_name }}</p>

            <!-- Download Tugas -->
            <a href="{{ asset('storage/'.$item->file) }}" class="btn btn-primary btn-sm" download>Download Tugas</a>

            <!-- Upload Jawaban -->
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $item->id }}">Upload Jawaban</button>

            <!-- Modal Upload -->
            <div class="modal fade" id="uploadModal{{ $item->id }}" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('upload.jawaban', $item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Upload Jawaban</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="file" class="form-label">Pilih File</label>
                                    <input type="file" class="form-control" name="file" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection