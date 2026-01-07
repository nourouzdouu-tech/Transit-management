@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dossiers en Retard</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Client</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dossiers as $dossier)
                <tr>
                    <td>{{ $dossier->title }}</td>
                    <td>{{ $dossier->client->name }}</td>
                    <td>{{ $dossier->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
