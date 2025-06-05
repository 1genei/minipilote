<script>

    // Filtrer les produits
    function filtrer_produits() {
        // Filtrer les produits
        $(".filtrer").change(function(e){
            
            e.preventDefault();
            
            $.ajax({
                url: '/produits/rechercher', 
                type: 'GET',
                data: {
                    categorie_id: $('#categorie').val(), 
                    voiture_id: $('#voiture').val(), 
                    circuit_id: $('#circuit').val() 
                },
                success: function(response) {
                    
                    var nb_produit = response.length;
                    $('#nb_produit').html('<span class="text-danger">'+nb_produit+' produits trouvés</span>');
                    tab_produits = [];
                    liste_produits = "";
                    
                    $("#produit").empty(); 
                    response.forEach(function(produit) {
                        $("#produit").append('<option value="' + produit.id + '">' + produit.nom + '</option>');
                        liste_produits += '<option value="' + produit.id + '">' + produit.nom + '</option>';        
                        tab_produits[produit.id] = produit;
                        
                    });
                    
                    
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error("An error occurred: " + status + " " + error);
                }
            });
        
        });
    }


    // Retourne la liste des tvas sous forme de tableau d'options et de tableau associatif
    function liste_tvas(tvas) {
        var liste_tvas = "";
        var tab_tvas = {};

        tvas.forEach(element => {
            liste_tvas += '<option value="' + element.id + '">' + element.nom + '</option>'; 
            tab_tvas[element.id] = element.taux;
        });
        
       return {liste_tvas, tab_tvas};
        
    }
    // Retourne la liste des produits sous forme de tableau d'options et de tableau associatif
    function liste_produits(produits) {
        var liste_produits = "";
        var tab_produits = {};
        
        produits.forEach(element => {
            liste_produits += '<option value="' + element.id + '">' + element.nom + '</option>'; 
            tab_produits[element.id] = element;
        });
        
        return {liste_produits, tab_produits};
        
    }

    // Lorsqu'on change le produit sur une ligne, mettre à jour le prix ht, le tva et le prix ttc
    function mettre_a_jour_prix_ht_ttc(tab_produits) {
        $(document).on('change', '.select_produit', function() { 
            var id = $(this).val();

            var prix_ht = tab_produits[id].prix_vente_ht;
            var tva = tab_produits[id].tva_id;
            var prix_ttc = prix_ht * (1 + tva / 100);
                        
            $(this).parent().parent().find('.prix_ht').val(prix_ht);
            $(this).parent().parent().find('.tva option[value="'+tva+'"]').attr("selected",true);
            $('#actualiser').click();
        });
    }
        
    // Ajouter une ligne de produit dans la commande
    function ajouter_ligne_produit_commande(liste_produits, liste_tvas, tab_produits, numero_ligne) {
        var y = numero_ligne;
        $(document).ready(function() {
            var max_produits = 30;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");

            
            
            
            $(add_button).click(function(e) {
       

                e.preventDefault();
                if (y < max_produits) {
                    var nom_produit = $("#produit").val();
                    
                    if(nom_produit != "" && nom_produit !== undefined) {
                        y++;
                        
                        var fieldHTML = `
                            <div class="row gy-2 gx-2 align-items-center field${y}"> 
                                <div class="col-4">
                                    <label for="produit${y}">Produit: </label> 
                                    <select class="form-control select2 liste_produits select_produit" id="produit${y}" name="produit${y}">
                                        <option></option>
                                        ${liste_produits}
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="quantite${y}">Quantité: </label>
                                    <input class="form-control quantite" type="number"  min="1" value="1" id="quantite${y}" required name="quantite${y}"/>
                                </div>
                                <div class="col-1">
                                    <label for="prix_ht${y}">Prix HT (€): </label>
                                    <input class="form-control prix_ht" type="number" min="1" step="0.01" value="${tab_produits[nom_produit].prix_vente_ht}" required id="prix_ht${y}" name="prix_ht${y}" >
                                </div>
                                <div class="col-1">
                                    <label for="tva${y}">Tva: </label>
                                    <select class="form-select liste_tvas tva" width="80px" id="tva${y}" name="tva${y}">
                                        <option value="0"></option>
                                        ${liste_tvas}
                                    </select>
                                </div> 
                                <div class="col-1">
                                    <label for="type_reduction${y}">Réduction: </label>
                                    <select class="form-select type_reduction" id="type_reduction${y}" name="type_reduction${y}">
                                        <option> </option>
                                        <option value="pourcentage">%</option>
                                        <option value="montant">EUR</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="reduction${y}"> </label>
                                    <input class="form-control reduction" type="number" step="0.01" min="0" id="reduction${y}" name="reduction${y}" readonly >
                                </div>
                                <div class="col-2">
                                    <label for="beneficiaire${y}">Bénéficiaire : </label>
                                    <select class="form-control select2" id="beneficiaire${y}" name="beneficiaire${y}">
                                        <option value="">Sélectionnez un bénéficiaire</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="remove_field btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete"></i>
                                    </a>
                                </div>
                            </div>`;
                
                        $(wrapper).append(fieldHTML);
                        
                        // Initialiser select2 sur le nouveau champ bénéficiaire
                        initContactsSelect2('#beneficiaire' + y);
                        
                        // Initialiser select2 sur le nouveau champ produit
                        $(`#produit${y}`).select2({
                            placeholder: "Sélectionnez un produit",
                            allowClear: true,
                            width: '100%'
                        });
                        
                        // Sélectionner le produit
                        $(`#produit${y}`).val(nom_produit).trigger('change');
                        
                        $("#quantite" + y + '').val(1);                        
                        $("#prix_ht" + y + '').val(tab_produits[nom_produit].prix_vente_ht);                        
                        $("#tva" + y + ' option[value="'+tab_produits[nom_produit].tva_id+'"]').attr("selected",true);                       
                        $("#pal" + y + '').hide();                        
                        $("#quantite" + y + '').change(function() {
                            var quantite = $(this).val();
                            var prix_ht = $("#prix_ht" + y + '').val();
                            var tva = $("#tva" + y + '').val();
                            var prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            var montant_tva = prix_ttc - prix_ht;
                            
                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);
                            
                        });
                        
                        $("#prix_ht" + y + '').change(function() {
                            var quantite = $("#quantite" + y + '').val();
                            var prix_ht = $(this).val();
                            var tva = $("#tva" + y + '').val();
                            var prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            var montant_tva = prix_ttc - prix_ht;
                            
                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);
                            
                        });
                        
                        $("#tva" + y + '').change(function() {
                            var quantite = $("#quantite" + y + '').val();
                            var prix_ht = $("#prix_ht" + y + '').val();
                            var tva = $(this).val();
                            var prix_ttc = quantite*prix_ht * (1 + tva / 100);
                            var montant_tva = prix_ttc - prix_ht;
                            
                            prix_ttc = prix_ttc.toFixed(2);
                            montant_tva = montant_tva.toFixed(2);
                            
                            $("#prix_ttc" + y + '').val(prix_ttc);
                            $("#montant_tva" + y + '').val(montant_tva);
                            
                        });
                        
                        $('#actualiser').click();

                    }
                } else {
                    swal.fire(
                        'Ajout impossible!',
                        'Le maximum de produit est atteint!',
                        'error'
                    );
                }

            });

            $(wrapper).on("click", ".remove_field", function(e) {
                e.preventDefault();
                $(this).parent().parent('div').remove();
                y--;
                $('#actualiser').click();
            });
        });  

        return y;
    }
    

   

</script>