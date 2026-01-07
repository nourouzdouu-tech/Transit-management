<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Clients</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #003d80;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead th {
            background: #e6f2ff;
            color: #003d80;
            border: 1px solid #003d80;
            padding: 10px;
            text-align: center;
        }

        tbody td {
            border: 1px solid #003d80;
            padding: 8px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #d9eaff;
        }
    </style>
</head>
<body>
    <h2>Liste des Clients</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Ville</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->ville }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
