@extends('masterSiswa')

@section('content')
<div class="container">
    <h3 class="p-2">Detail Tugas</h3>
    <div class="list-group">
        <div class="list-group-item m-2">
            <h5>{{ $tugas->name }}</h5>
            <p>{{ $tugas->description }}</p>
            <p>Deadline: {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y, H:i') }}</p>

            <!-- Download File Tugas -->
            @if($tugas->file)
                <a href="{{ asset('storage/' . $tugas->file) }}" class="btn btn-primary btn-sm mt-2" download>Download Tugas</a>
            @endif

            <!-- Menampilkan Subtugas -->
            @if($tugas->details->isNotEmpty())
                <h6 class="mt-3">Subtugas:</h6>
                <ul class="list-group">
                    @foreach($tugas->details as $detail)
                        <li class="list-group-item">
                            <h6>{{ $detail->name }}</h6>
                            <p>{{ $detail->description }}</p>

                            <!-- Status Subtugas per kelompok -->
                            <!-- Status Subtugas -->
                            <p>Status Subtugas:
                                @if($detail->groupSubtasks->isNotEmpty())
                                    @foreach($detail->groupSubtasks as $subtask)
                                        <span class="{{ $subtask->is_completed ? 'text-success' : 'text-danger' }}">
                                            {{ $subtask->is_completed ? 'Selesai' : 'Belum Selesai' }}
                                        </span><br>
                                    @endforeach
                                @else
                                    <span class="text-danger">Belum Selesai</span>
                                @endif
                            </p>
                            @if($detail->file)
                                <!-- Download Subtugas -->
                                <a href="{{ asset('storage/' . $detail->file) }}" class="btn btn-primary btn-sm mt-2" download>Download Subtugas</a>
                            @endif

                            <!-- Cek jika belum selesai, tampilkan tombol upload -->
                            @if($detail->groupSubtasks->isNotEmpty())
                            <a href="{{ asset('storage/' . $detail->file) }}" class="btn btn-success btn-sm mt-2" download>Download Jawaban</a>
                            @else
                            <button class="btn btn-info btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $detail->id }}">Upload Jawaban</button>

                                <!-- Modal Upload Jawaban -->
                                <div class="modal fade" id="uploadModal{{ $detail->id }}" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('upload.subtask', $detail->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadModalLabel">Upload Jawaban untuk {{ $detail->name }}</h5>
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
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="card m-3">
        <div class="card-header">
            <div class="card m-3">
                <div class="card-header">
                    {{-- Form Diskusi --}}
                    <h4>Tambahkan Komentar</h4>
                    <form action="{{ route('diskusi.store', ['tugasId' => $tugas->id, 'groupId' => $groupId]) }}" method="POST">
                        @csrf
                        <textarea name="comment" class="form-control" rows="4" placeholder="Masukkan Komentar..."></textarea>
                        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
                    </form>
                </div>
            </div>
            <div class="mt-4">
                <h5>Komentar Sebelumnya</h5>
                @if($diskusi->isNotEmpty())
                    @foreach($diskusi as $item)
                        <div class="mb-3 border p-2 rounded">
                            <strong>{{ $item->user->name }}</strong> <!-- Nama pengguna -->
                            <p>{{ $item->comment }}</p>
                            <small class="text-muted">Dikirim pada {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</small>
                        </div>
                    @endforeach
                @else
                    <p>Belum ada komentar.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
