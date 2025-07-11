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
        td.produits {
            padding: 8px 2px;
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
 
     


    </style>
</head>
<body>
    @component('components.facture-pdf-header', ['societePrincipale' => $societePrincipale, 'facture' => $facture, 'preview' => $preview ?? false])
    @endcomponent


    <div class="client-info">
        <strong>
            @if($facture->type === 'client')
                CLIENT :
            @elseif($facture->type === 'fournisseur')
                FOURNISSEUR :
            @else
                DESTINATAIRE :
            @endif
        </strong><br>
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
        @elseif($facture->fournisseur)
            @if($facture->fournisseur->type === 'individu')
                {{ $facture->fournisseur->individu->civilite ?? '' }} {{ $facture->fournisseur->individu->nom }} {{ $facture->fournisseur->individu->prenom }}<br>
                @if($facture->fournisseur->individu->adresse)
                    {{ $facture->fournisseur->individu->adresse }}<br>
                @endif
                @if($facture->fournisseur->individu->code_postal && $facture->fournisseur->individu->ville)
                    {{ $facture->fournisseur->individu->code_postal }} {{ $facture->fournisseur->individu->ville }}
                @endif
            @else
                {{ $facture->fournisseur->entite->forme_juridique ?? '' }} {{ $facture->fournisseur->entite->raison_sociale }}<br>
                @if($facture->fournisseur->entite->adresse)
                    {{ $facture->fournisseur->entite->adresse }}<br>
                @endif
                @if($facture->fournisseur->entite->code_postal && $facture->fournisseur->entite->ville)
                    {{ $facture->fournisseur->entite->code_postal }} {{ $facture->fournisseur->entite->ville }}
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
                <tr>
                    <td class="produits" width="50%">{!! $facture->description ?: 'Prestation de services' !!}</td>
                    <td class="produits">{{ number_format($facture->montant_ht, 2, ',', ' ') }} €</td>
                    <td class="produits">{{ number_format($facture->montant_tva, 2, ',', ' ') }} €</td>
                    <td class="produits">{{ number_format($facture->montant_ttc, 2, ',', ' ') }} €</td>
                </tr>
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
   
<!-- PIED DE PAGE -->
@component('components.facture-pdf-footer', ['societePrincipale' => $societePrincipale])
@endcomponent
</body>
</html> 