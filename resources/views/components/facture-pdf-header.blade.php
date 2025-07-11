<style>
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
        font-size: 14px;
    }
</style>
<div class="header">
    <img class="logo" width="100%" height="40px" src="https://www.stylandgrip.com/wp-content/uploads/2021/08/SG_LOGO_CARTOUCHE_SEUL-1-2048x200.png">
    <div class="company-info">
        <strong>{{ $societePrincipale?->forme_juridique }} {{ $societePrincipale?->raison_sociale }}</strong><br>
        {{ $societePrincipale?->numero_voie }} {{ $societePrincipale?->nom_voie }} {{ $societePrincipale?->complement_voie }}<br>
        {{ $societePrincipale?->code_postal }} {{ $societePrincipale?->ville }}<br>
        Tél : {{ $societePrincipale?->indicatif }} {{ $societePrincipale?->telephone }}<br>
        Email : {{ $societePrincipale?->email }}<br>
        Site : www.stylandgrip.com
    </div>
    <div class="document-info">
        <h2>
            @if(isset($preview) && $preview)
                FACTURE PROVISOIRE N° {{ $facture->numero ?? '' }}
            @else
                FACTURE N° {{ $facture->numero ?? '' }}
            @endif
        </h2>
        @if(isset($facture) && $facture->numero_origine)
            <strong>Facture fournisseur : {{ $facture->numero_origine }}</strong><br>
        @endif
        Date : {{ isset($facture) ? \Carbon\Carbon::parse($facture->date)->format('d/m/Y') : '' }}<br>
    </div>
</div> 