
/**
* Formater un numéro de téléphone dans un champ input pendant la saisie
*/

function formater_tel(selecteur_telephone, selecteur_indicatif){

    $(document).ready(function() {
    
        $(selecteur_telephone).attr("placeholder", "Entrez le numéro sans le premier '0' ");

 

        $(selecteur_telephone).on('input', function() {
            // Supprimez les caractères non numériques
            var numero = $(this).val().replace(/\D/g, '');

            // Formate le numéro avec un espace après chaque 2 chiffres
            var numeroFormate = '';
            
            for (var i = 0; i < numero.length; i++) {
                if (i === 1) {
                    numeroFormate += ' ';
                }
                if (i > 1 && (i - 1) % 2 === 0) {
                    numeroFormate += ' ';
                }
                numeroFormate += numero[i];
                
            }

            var indicatif_fixe = $(selecteur_indicatif).val();
        

            // Limitez le numéro à 10 chiffres maximum si c'est un numéro francais
            if (indicatif_fixe == "+33") {
                numeroFormate = numeroFormate.substring(0, 13); // 9 chiffres + 4 espaces
            }else{
                numeroFormate = numeroFormate.substring(0, 20); 
            
            }

            // Mettez à jour la valeur du champ
            $(this).val(numeroFormate);
        });
    });
}

// ######### FIN




/**
* Autocomplète des code postaux et adresses pendant la saisie
*/
let autocomplete_adresse;
let autocomplete_code_postal;
let autocomplete_ville;



function initAutocomplete() {
    autocomplete_adresse = new google.maps.places.Autocomplete(
        document.getElementById('nom_voie'), {
            types: ['address'],
            componentRestrictions: {
                'country': ['FR']
            },
            fields: ['address_components', 'address_components', 'adr_address', 'formatted_address', 'name',
                'vicinity'
            ]
        }
    );

    autocomplete_code_postal = new google.maps.places.Autocomplete(
        document.getElementById('code_postal'), {
            types: ['postal_code'],
            componentRestrictions: {
                'country': ['FR']
            },
            fields: ['name', 'vicinity']
        }
    );

    autocomplete_ville = new google.maps.places.Autocomplete(
        document.getElementById('ville'), {
            types: ['geocode'],
            componentRestrictions: {
                'country': ['FR']
            },
            fields: ['address_components', 'address_components', 'adr_address', 'formatted_address', 'name',
                'vicinity'
            ]
        }
    );

    autocomplete_adresse.addListener('place_changed', onPlaceChanged);
    autocomplete_code_postal.addListener('place_changed', onPlaceChanged);
    autocomplete_ville.addListener('place_changed', onPlaceChanged);

}


function onPlaceChanged() {
    var place_voie = autocomplete_adresse.getPlace();
    var place_ville = autocomplete_ville.getPlace();
    var place_code_postal = autocomplete_code_postal.getPlace();
    var codePostal = "";

    if (place_voie) {

        document.getElementById('nom_voie').value = place_voie.name;
        document.getElementById('ville').value = place_voie.vicinity;

        place_voie.address_components.forEach(function(component) {
            if (component.types.includes('postal_code')) {
                codePostal = component.long_name;
            }
        });
        document.getElementById('code_postal').value = codePostal;

    }

    if (place_code_postal) {
        document.getElementById('ville').value = place_code_postal.vicinity;
        document.getElementById('code_postal').value = place_code_postal.name;
    }

    if (place_ville) {
        document.getElementById('ville').value = place_ville.vicinity;
    }

}
// ############### FIN