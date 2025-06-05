<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Commande {{ $commande->numero_commande }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .company-info {
            float: left;
            width: 50%;
            font-size: 14px;
        }
        .document-info {
            float: right;
            width: 50%;
            text-align: right;
            font-size: 14px;
        }
        .client-info {
            clear: both;
            margin-bottom: 30px;
            padding-top: 20px;
        }
        .commande-details {
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
        .reduction {
            color: #dc3545;
        }
        .net-a-payer {
            font-size: 18px;
            font-weight: bold;
            color: #35b8e0;
            margin-top: 20px;
            text-align: left;
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
    </style>
</head>
<body>
    <div class="header">
        <img class="logo" width="200px" src="https://www.stylandgrip.com/wp-content/uploads/2021/08/SG_LOGO_CARTOUCHE_SEUL-1-2048x200.png">
        <div class="company-info">
            <strong>Sarl VENZINI</strong><br>
            115 Avenue de la roquette, ZA de berret<br>
            30200 BAGNOLS-SUR-CEZE<br>
            Tél : 06 80 42 85 48<br>
            Email : contact@venzini.fr<br>
            Site : www.stylandgrip.com
        </div>
        <div class="document-info">
            <h2>COMMANDE N° {{ $commande->numero_commande }}</h2>
            Date : {{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}<br>
            @if($commande->date_realisation_prevue)
                Date de réalisation prévue : {{ \Carbon\Carbon::parse($commande->date_realisation_prevue)->format('d/m/Y') }}
            @endif
        </div>
    </div>

    <div class="client-info">
        <strong>CLIENT :</strong><br>
        @if($commande->client?->type == 'individu')
            {{ $commande->client?->individu->civilite }} {{ $commande->client?->individu->nom }} {{ $commande->client?->individu->prenom }}<br>
            {{ $commande->client?->individu->adresse }}<br>
            {{ $commande->client?->individu->code_postal }} {{ $commande->client?->individu->ville }}
        @else
            {{ $commande->client?->entite->forme_juridique }} {{ $commande->client?->entite->raison_sociale }}<br>
            {{ $commande->client?->entite->adresse }}<br>
            {{ $commande->client?->entite->code_postal }} {{ $commande->client?->entite->ville }}
        @endif
    </div>

    <div class="commande-details">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Qté</th>
                    <th>Px unit. HT</th>
                    <th>Remise</th>
                    {{-- <th>Montant HT</th> --}}
                    <th>Bénéficiaire</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->produits as $produit)
                    <tr>
                        <td width="50%">{{ $produit->nom }}</td>
                        <td>{{ $produit->pivot->quantite }}</td>
                        <td width="20%">{{ number_format($produit->pivot->prix_unitaire, 2, ',', ' ') }} </td>
                        <td class="reduction">
                            @if($produit->pivot->remise > 0)
                                @if($produit->pivot->taux_remise)
                                    {{ $produit->pivot->taux_remise }}%
                                @else
                                    {{ number_format($produit->pivot->remise, 2, ',', ' ') }} 
                                @endif
                            @else
                                
                            @endif
                        </td>
                        {{-- <td>{{ number_format($produit->pivot->montant_ht, 2, ',', ' ') }} </td> --}}
                        <td>
                            @if($produit->pivot->beneficiaire_id)
                                @php 
                                    $beneficiaire = App\Models\Contact::find($produit->pivot->beneficiaire_id);
                                @endphp
                                @if($beneficiaire->type == 'individu')
                                    {{ $beneficiaire->individu->nom }} {{ $beneficiaire->individu->prenom }}
                                @else
                                    {{ $beneficiaire->entite->raison_sociale }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="totals">
        <table>
            <tr>
                <td>Total HT :</td>
                <td>{{ number_format($commande->montant_ht, 2, ',', ' ') }} €</td>
            </tr>
            @if($commande->montant_remise > 0)
            <tr class="reduction">
                <td>Total remises :</td>
                <td>- {{ number_format($commande->montant_remise, 2, ',', ' ') }} €</td>
            </tr>
            @endif
            <tr>
                <td>Total TVA :</td>
                <td>{{ number_format($commande->montant_tva, 2, ',', ' ') }} €</td>
            </tr>
            <tr class="total-row">
                <td>Total TTC :</td>
                <td>{{ number_format($commande->montant_ttc, 2, ',', ' ') }} €</td>
            </tr>
        </table>
    </div>

    <div class="net-a-payer">
        NET À PAYER : {{ number_format($commande->net_a_payer, 2, ',', ' ') }} €
    </div>

    <div class="footer">
        Sarl VENZINI - SIRET : XXXXXXXX - TVA : FRXXXXXXXXX<br>
        115 Avenue de la roquette, ZA de berret, 30200 BAGNOLS-SUR-CEZE
    </div>
</body>
</html> 