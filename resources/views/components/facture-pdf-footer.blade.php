<style>
    @page { margin: 50px 45px; }
    .footer {
        position: fixed;
        bottom: 50px;
        left: 0px; right: 0px;  height: 150px; 
        align-content: center;
    }
</style>
<div class="footer">
    <table style="height: 40px;" cellspacing="0" border="0">
        <tbody>
            <tr>
                <td style="width: 100%; text-align: center; font-size: 12px;">
                    <strong>Conditions de paiement: à réception de facture par virement:</strong>
                </td>
            </tr>
            <tr>
                <td style="width: 100%;  font-size: 12px;  text-align: center;">
                    En cas de retard de paiement, une indemnité forfaitaire pour frais de recouvrement de 40 € sera appliquée. 
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table" style="width: 100%; text-align: center;" cellspacing="0">
        <tbody>
            <tr style="height: 18px;"> 
                <td class="produits" align="center" style="height: 18px;"><strong>Banque</strong></td>
                <td class="produits" align="center" style="height: 18px;">{{ $societePrincipale?->banque }}</td>
                <td class="produits" align="center" style="height: 18px;"><strong>IBAN</strong></td>
                <td class="produits" align="center" style="height: 18px;">{{ $societePrincipale?->iban }}</td>
            </tr>
            <tr style="height: 18px;">
                <td class="produits" align="center" style="height: 18px;"><strong>BIC</strong></td>
                <td class="produits" align="center" style="height: 18px;">{{ $societePrincipale?->bic }}</td>
                <td class="produits" align="center" style="height: 18px;"><strong>RIB</strong></td>
                <td class="produits" align="center" style="height: 18px;">{{ $societePrincipale?->rib }}</td>
            </tr>
        </tbody>
    </table> 
    <table style="width: 100%; text-align: center;">
        <tbody>
            <tr>
                <td style="width: 100%; text-align: center; font-size: 12px;" >
                    <strong> {{ $societePrincipale?->forme_juridique }} {{ $societePrincipale?->raison_sociale }}   </strong> au capital social de {{ $societePrincipale?->capital }}€ Numéro de SIRET {{ $societePrincipale?->numero_siret }} - 
                RCS de {{ $societePrincipale?->ville_rcs }} (B {{ $societePrincipale?->numero_rcs }})  
                </td>
            </tr>
            <tr>          
                <td style="width: 100%; text-align: center; font-size: 12px;" >
                    Numéro de TVA intracommunautaire {{ $societePrincipale?->numero_tva }}
                </td>
            </tr>
        </tbody>
    </table>
</div> 