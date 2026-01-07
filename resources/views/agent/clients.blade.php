@extends('layouts.app')

@section('title', 'Liste des Clients')

@section('content')
<div class="container py-4">
    <h2>Clients</h2>

    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('agent.clients') }}" class="mb-3 d-flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Recherche par nom, email ou numéro dossier">
        
        <div class="form-check align-self-center">
            <input class="form-check-input" type="checkbox" name="with_active_dossiers" value="1" id="activeDossiers" {{ request('with_active_dossiers') == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="activeDossiers">Clients avec dossiers actifs</label>
        </div>

        <button type="submit" class="btn btn-primary">Filtrer</button>
        <a href="{{ route('agent.clients') }}" class="btn btn-secondary">Réinitialiser</a>
    </form>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Bouton création client --}}
    <a href="{{ route('agent.client.create') }}" class="btn btn-success mb-3">Ajouter un client</a>

    @if($clients->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Dossiers actifs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->prenom }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->telephone }}</td>
                    <td>{{ $client->dossiers->where('status', '!=', 'Terminé')->count() }}</td>
                    <td>
                        <a href="{{ route('agent.client.edit', $client->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('agent.client.destroy', $client->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Supprimer ce client ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $clients->withQueryString()->links() }}
    @else
        <p>Aucun client trouvé.</p>
    @endif
</div>
@endsection
