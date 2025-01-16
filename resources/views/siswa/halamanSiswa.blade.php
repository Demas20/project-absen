@extends('masterSiswa')
@section('content')
<div class="container">
    <h3 class="p-2">Daftar Tugas</h3>
    <div class="list-group">
        @csrf
        @foreach($tugas as $item)
        @php
            // Cek apakah deadline telah lewat
            $deadline = \Carbon\Carbon::parse($item->deadline);
            $isPastDeadline = \Carbon\Carbon::now()->greaterThan($deadline);
        @endphp

        <a href="{{ !$isPastDeadline ? route('detail.tugas', $item->id) : '#' }}" class="{{ $isPastDeadline ? 'disabled' : '' }}" id="task-{{ $item->id }}">
            <div class="list-group-item m-2">
                <h5>{{ $item->name }}</h5>
                <p>{{ $item->description }}</p>
                <p>Deadline: {{ $deadline->format('d M Y, H:i') }}</p>
                <p>Kelas: {{ $siswaDetails->kelas_name }}</p>

                <!-- Countdown Timer -->
                <p id="countdown-{{ $item->id }}" class="text-success">
                    @if ($isPastDeadline)
                        Waktu Habis
                    @else
                        Waktu Tersisa: <span class="countdown-timer" data-deadline="{{ \Carbon\Carbon::parse($item->deadline)->toISOString() }}"></span>
                    @endif
                </p>

                <!-- Tampilkan Nilai Berdasarkan Subtugas -->
                <h5>Nilai Berdasarkan Subtugas:</h5>
                @if (count($item->groupNilai) > 0)
                <ul>
                    @foreach ($item->groupNilai as $group)
                        <li>
                            <strong>{{ $group['detailName'] }}:</strong>
                            <span class="text-success">
                                {{ number_format($group['rataRataNilai'], 2) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
                @else
                <p class="text-warning">Belum ada nilai untuk group Anda.</p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Loop untuk semua tugas dan set countdown timer
        @foreach($tugas as $item)
            @php
                // Cek apakah deadline belum lewat
                $deadline = \Carbon\Carbon::parse($item->deadline);
                $isPastDeadline = \Carbon\Carbon::now()->greaterThan($deadline);
            @endphp

            @if (!$isPastDeadline)  // Hanya jalankan countdown jika deadline belum lewat
                var deadline = new Date("{{ \Carbon\Carbon::parse($item->deadline)->toISOString() }}").getTime();
                var countdownElement = document.getElementById("countdown-{{ $item->id }}").getElementsByClassName("countdown-timer")[0];
                var taskLink = document.getElementById("task-{{ $item->id }}");

                var countdownInterval = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = deadline - now;

                    if (distance <= 0) {
                        clearInterval(countdownInterval);
                        countdownElement.innerHTML = "Waktu Habis";
                        taskLink.classList.add('disabled');  // Disable link setelah deadline
                    } else {
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        countdownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                    }
                }, 1000);
            @else
                // Jika deadline telah lewat, tampilkan "Waktu Habis" dan disable link
                document.getElementById("countdown-{{ $item->id }}").innerText = "Waktu Habis";
                document.getElementById("task-{{ $item->id }}").classList.add('disabled');
            @endif
        @endforeach
    });
</script>
@endsection
