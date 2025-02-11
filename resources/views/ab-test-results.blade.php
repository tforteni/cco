@extends('layouts.app2')

@section('content')
<h2>A/B Test Results</h2>
<table class="table">
    <thead>
        <tr>
            <th>Variation</th>
            <th>Action</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
        <tr>
            <td>{{ $result->variation }}</td>
            <td>{{ ucfirst($result->action) }}</td>
            <td>{{ $result->count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
