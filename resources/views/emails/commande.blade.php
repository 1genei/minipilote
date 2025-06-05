<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="https://www.stylandgrip.com/wp-content/uploads/2021/08/SG_LOGO_CARTOUCHE_SEUL-1-2048x200.png" alt="Logo">
            <h2>Commande N° {{ $commande->numero_commande }}</h2>
        </div>

        <div class="content">
            <p>Bonjour 
                @if($contact->type == 'individu')
                    {{ $contact->individu->civilite }} {{ $contact->individu->nom }}
                @else
                    {{ $contact->entite->raison_sociale }}
                @endif,
            </p>

            <p>Veuillez trouver ci-joint votre commande N° {{ $commande->numero_commande }} du {{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}.</p>

            @if($message_perso)
                <div class="message">
                    <p>{{ $message_perso }}</p>
                </div>
            @endif

            <div class="details">
                <p><strong>Montant total :</strong> {{ number_format($commande->net_a_payer, 2, ',', ' ') }} €</p>
                @if($commande->date_realisation_prevue)
                    <p><strong>Date de réalisation prévue :</strong> {{ \Carbon\Carbon::parse($commande->date_realisation_prevue)->format('d/m/Y') }}</p>
                @endif
            </div>

            <p>Pour toute question concernant votre commande, n'hésitez pas à nous contacter.</p>
        </div>

        <div class="footer">
            <p>
                Sarl VENZINI<br>
                115 Avenue de la roquette, ZA de berret<br>
                30200 BAGNOLS-SUR-CEZE<br>
                Tél : 06 80 42 85 48<br>
                Email : contact@venzini.fr
            </p>
        </div>
    </div>
</body>
</html> 