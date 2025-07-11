<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devis {{ $devis->numero_devis }}</title>
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
        .devis-details {
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
            <h2>DEVIS N° {{ $devis->numero_devis }}</h2>
            @if($devis->nom_devis)
                <strong>{{ $devis->nom_devis }}</strong><br>
            @endif
            Date : {{ \Carbon\Carbon::parse($devis->date_devis)->format('d/m/Y') }}<br>
            Validité : {{ $devis->duree_validite }} jours
        </div>
    </div>

    <div class="client-info">
        <strong>CLIENT :</strong><br>
        @if($devis->client_prospect()?->type == "individu")
            {{ $devis->client_prospect()?->infos()?->civilite }} {{ $devis->client_prospect()?->infos()?->nom }} {{ $devis->client_prospect()?->infos()?->prenom }}<br>
            {{ $devis->client_prospect()?->infos()?->numero_voie }} {{ $devis->client_prospect()?->infos()?->nom_voie }}<br>
            {{ $devis->client_prospect()?->infos()?->code_postal }} {{ $devis->client_prospect()?->infos()?->ville }}
        @else
            {{ $devis->client_prospect()?->infos()?->forme_juridique }} {{ $devis->client_prospect()?->infos()?->raison_sociale }}<br>
            {{ $devis->client_prospect()?->infos()?->numero_voie }} {{ $devis->client_prospect()?->infos()?->nom_voie }}<br>
            {{ $devis->client_prospect()?->infos()?->code_postal }} {{ $devis->client_prospect()?->infos()?->ville }}
        @endif
    </div>

    <div class="devis-details">
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Qté</th>
                    <th>Px unit. HT</th>
                    <th>Remise</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tab_produits as $produit)
                    <tr>
                        <td width="50%">{{ $produit["produit"]->nom }}</td>
                        <td>{{ number_format($produit["quantite"], 2, ',', ' ') }}</td>
                        <td>{{ number_format($produit["prix_unitaire_ht"], 2, ',', ' ') }} €</td>
                        <td class="reduction">
                            @if($produit["remise"] > 0)
                                - {{ number_format($produit["remise"], 2, ',', ' ') }} €
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
                <td>{{ number_format($devis->montant_ht, 2, ',', ' ') }} €</td>
            </tr>
            @if($devis->montant_remise_total > 0)
            <tr class="reduction">
                <td>Total remises :</td>
                <td>- {{ number_format($devis->montant_remise_total, 2, ',', ' ') }} €</td>
            </tr>
            @endif
            <tr>
                <td>Total TVA :</td>
                <td>{{ number_format($devis->montant_tva, 2, ',', ' ') }} €</td>
            </tr>
            <tr class="total-row">
                <td>Total TTC :</td>
                <td>{{ number_format($devis->montant_ttc, 2, ',', ' ') }} €</td>
            </tr>
        </table>
    </div>

    {{-- <div class="net-a-payer">
        NET À PAYER : {{ number_format($devis->net_a_payer, 2, ',', ' ') }} €
    </div> --}}

    <div class="footer">
        Sarl VENZINI - SIRET : XXXXXXXX - TVA : FRXXXXXXXXX<br>
        115 Avenue de la roquette, ZA de berret, 30200 BAGNOLS-SUR-CEZE
    </div>
</body>
</html>
