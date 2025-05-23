<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Hebdomadaire - {{ $service->titre }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e3c72;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #1e3c72;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            margin-top: 0;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #1e3c72;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stat-box {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            width: 30%;
            text-align: center;
        }
        .stat-box h3 {
            margin-top: 0;
            color: #1e3c72;
        }
        .stat-box p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport Hebdomadaire</h1>
        <p>{{ $service->titre }} - {{ $debutPeriode->format('d/m/Y') }} au {{ $finPeriode->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <h2>Résumé</h2>
        <div class="stats">
            <div class="stat-box">
                <h3>Visites totales</h3>
                <p>{{ $visitesTotal }}</p>
            </div>
            <div class="stat-box">
                <h3>Moyenne / jour</h3>
                <p>{{ round($visitesTotal / 7, 1) }}</p>
            </div>
            <div class="stat-box">
                <h3>Jour le plus actif</h3>
                @php
                    $jourActif = $visitesParJour->sortByDesc('count')->first();
                @endphp
                <p>{{ $jourActif ? date('d/m', strtotime($jourActif->date)) : 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Visites quotidiennes</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nombre de visites</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visitesParJour as $visite)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($visite->date)) }}</td>
                        <td>{{ $visite->count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Informations du service</h2>
        <table>
            <tr>
                <th>Nom</th>
                <td>{{ $service->titre }}</td>
            </tr>
            <tr>
                <th>Catégorie</th>
                <td>{{ $service->categorie->nom }}</td>
            </tr>
            <tr>
                <th>Ville</th>
                <td>{{ $service->ville->nom }}</td>
            </tr>
            <tr>
                <th>Prestataire</th>
                <td>{{ $prestataire->nom_entreprise }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Ce rapport a été généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>Plateforme Tourisme Maroc © {{ date('Y') }}</p>
    </div>
</body>
</html>