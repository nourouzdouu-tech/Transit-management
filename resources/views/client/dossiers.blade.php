@extends('layouts.app')

@section('title', 'Mes Dossiers')

@section('content')
<div class="container py-4">
    <h2>Mes Dossiers</h2>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Date création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dossiers as $dossier)
                <tr>
                    <td>{{ $dossier->numero }}</td>
                    <td>{{ Str::limit($dossier->description, 50) }}</td>
                    <td>
                        <span class="badge 
                            @if($dossier->status == 'En attente') bg-secondary
                            @elseif($dossier->status == 'En cours') bg-warning
                            @elseif($dossier->status == 'Terminé') bg-success
                            @elseif($dossier->status == 'Bloqué') bg-danger
                            @endif">
                            {{ $dossier->status }}
                        </span>
                    </td>
                    <td>{{ $dossier->date_creation->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('client.dossier', $dossier->id) }}" class="btn btn-primary btn-sm">Voir</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucun dossier trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
