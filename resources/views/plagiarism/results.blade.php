@extends('master')

@section('content')
<div class="container">
    <h3 class="mb-4">Hasil Perbandingan Plagiarisme</h3>
    <h1>Plagiarism Check Results</h1>

    @if(count($similarityResults) > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>Group</th>
                    <th>Similarity Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($similarityResults as $result)
                    <tr>
                        <td>{{ $result['group'] }}</td>
                        <td>{{ $result['similarity'] }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No plagiarism detected or no other submissions to compare.</p>
    @endif
</div>
@endsection
