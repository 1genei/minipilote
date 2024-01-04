<x-mail::message>
# Bonjour @if($contact->type == "individu") {{$contact->individu?->civilite}} {{$contact->individu?->nom}} {{$contact->individu?->prenom}} @endif,

Vous trouverez ci-joint le devis n°{{$devis->numero_devis}} .

<x-mail::button :url="route('devis.telecharger', Crypt::encrypt($devis->id))">
Télécharger le devis
</x-mail::button>

Bien cordialement,<br>
StylandGrip.

</x-mail::message>
