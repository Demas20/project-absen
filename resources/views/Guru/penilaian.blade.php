@extends('master')

@section('content')
<div class="container">
    <h3 class="mb-4">Penilaian Tugas</h3>
    @foreach ($tugas as $task)
        <div class="card mb-4">
            <div class="card-header">
                <h5>{{ $task->name }}</h5>
                <p>{{ $task->description }}</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kelompok</th>
                            <th>Subtugas</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($task->details as $detail)
                            @foreach ($detail->groupSubtasks as $subtask)
                                <tr>
                                    <td>{{ $subtask->group->name }}</td>
                                    <td>{{ $detail->name }}</td>
                                    <td>
                                        @if ($subtask->is_completed)
                                            <span class="text-success">Selesai</span>
                                        @else
                                            <span class="text-danger">Belum Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subtask->file)
                                            <a href="{{ asset('storage/' . $subtask->file) }}" target="_blank">Download</a>
                                        @else
                                            <span class="text-muted">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('penilaian.update', $subtask->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="nilai" value="{{ $subtask->nilai }}" class="form-control" style="width: 80px;">
                                            <button type="submit" class="btn btn-sm btn-primary mt-2">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
