<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Colis</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { text-align: center; color: #003d80; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #003d80; padding: 8px; text-align: center; word-wrap: break-word; }

        th { background: #e6f2ff; }

        /* Largeur adaptée */
        th:nth-child(4), td:nth-child(4) { width: 120px; } /* Colonne Statut */
        th:nth-child(3), td:nth-child(3) { width: 250px; } /* Description */
        
        .badge {
            display: inline-block;
            min-width: 70px;
            padding: 6px 12px;
            border-radius: 8px;
            color: #fff;
            font-size: 13px;
            font-weight: bold;
            text-align: center;
        }
        .en-cours { background: orange; }
        .termine { background: green; }
        .bloque { background: red; }
        .autre { background: gray; }
    </style>
</head>
<body>
    <h2>Liste des Colis</h2>
    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Client</th>
                <th>Description</th>
                <th>Statut</th>
                <th>Date Création</th>
                <th>Date d'échéance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dossiers as $dossier)
                <tr>
                    <td>{{ $dossier->numero }}</td>
                    <td>{{ $dossier->client->name ?? 'N/A' }}</td>
                    <td>{{ $dossier->description }}</td>
                    <td>
                        @php
                            $statusClass = match($dossier->status) {
                                'En cours' => 'en-cours',
                                'Terminé' => 'termine',
                                'Bloqué' => 'bloque',
                                default => 'autre',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $dossier->status }}</span>
                    </td>
                    <td>{{ $dossier->created_at->format('d/m/Y') }}</td>
                    <td>{{ $dossier->date_echeance->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
