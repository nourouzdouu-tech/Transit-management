@extends('layouts.app')

@section('title', 'Détails Client')

@section('content')
<div class="container py-4">
    <h2>Détails de {{ $client->name }} {{ $client->prenom }}</h2>

    <p><strong>Email :</strong> {{ $client->email }}</p>
    <p><strong>Téléphone :</strong> {{ $client->telephone }}</p>

    <h4>Dossiers actifs</h4>
    @if($client->dossiers->where('status', '!=', 'Terminé')->count())
        <ul class="list-group mb-3">
            @foreach($client->dossiers->where('status', '!=', 'Terminé') as $dossier)
                <li class="list-group-item">
                    #{{ $dossier->numero }} - {{ $dossier->description }} 
                    <span class="badge bg-info">{{ $dossier->status }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p>Aucun dossier actif.</p>
    @endif

    <a href="{{ route('agent.clients') }}" class="btn btn-secondary">Retour à la liste</a>
</div>
@endsection
