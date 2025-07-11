<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $facture->numero }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .facture-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 15px;
        }
        th {
            background-color: #35b8e0;
            color: white;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .total-row {
            font-weight: bold;
        }
       
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 12px;
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        .commande-header {
            padding: 8px;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
@component('components.facture-pdf-header', ['societePrincipale' => $societePrincipale, 'facture' => $facture, 'preview' => $preview ?? false])
@endcomponent

<div class="client-info">
    <strong>CLIENT :</strong><br>
    @if($facture->client)
        @if($facture->client->type === 'individu')
            {{ $facture->client->individu->civilite ?? '' }} {{ $facture->client->individu->nom }} {{ $facture->client->individu->prenom }}<br>
            @if($facture->client->individu->adresse)
                {{ $facture->client->individu->adresse }}<br>
            @endif
            @if($facture->client->individu->code_postal && $facture->client->individu->ville)
                {{ $facture->client->individu->code_postal }} {{ $facture->client->individu->ville }}
            @endif
        @else
            {{ $facture->client->entite->forme_juridique ?? '' }} {{ $facture->client->entite->raison_sociale }}<br>
            @if($facture->client->entite->adresse)
                {{ $facture->client->entite->adresse }}<br>
            @endif
            @if($facture->client->entite->code_postal && $facture->client->entite->ville)
                {{ $facture->client->entite->code_postal }} {{ $facture->client->entite->ville }}
            @endif
        @endif
    @endif
</div>

<div class="facture-details">
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Montant HT</th>
                <th>TVA</th>
                <th>Montant TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
            <tr>
                <td width="50%">
                    <div class="commande-header">
                        Commande N°{{ $commande->numero_commande }} - {{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}
                    </div>
                </td>
                <td>{{ number_format($commande->montant_ht, 2, ',', ' ') }} €</td>
                <td>{{ number_format($commande->montant_tva, 2, ',', ' ') }} €</td>
                <td>{{ number_format($commande->montant_ttc, 2, ',', ' ') }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="totals">
    <table>
        <tr>
            <td class="produits">Total HT :</td>
            <td class="produits">{{ number_format($facture->montant_ht, 2, ',', ' ') }} €</td>
        </tr>
        <tr>
            <td class="produits">Total TVA :</td>
            <td class="produits">{{ number_format($facture->montant_tva, 2, ',', ' ') }} €</td>
        </tr>
        <tr class="total-row">
            <td class="produits">Total TTC :</td>
            <td class="produits">{{ number_format($facture->montant_ttc, 2, ',', ' ') }} €</td>
        </tr>
    </table>
</div>

@component('components.facture-pdf-footer', ['societePrincipale' => $societePrincipale])
@endcomponent
</body>
</html> 