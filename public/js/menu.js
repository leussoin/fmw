$(document).ready(function () {

    let idJour, plat, platChoisi;


    $(".modale").on("click", function () {
        idJour = $(this).attr('id');
        // je récupére l'input utilisateur
        if ($('#i-' + idJour).val().length > 0) {
            $('#recette').val($('#i-' + idJour).val());
        }
        delete idJour;
        $("#myModal").modal('show');
    });


    $("#recette").autocomplete({
        //$(".input").autocomplete({
        source: "/recette/autocomplete",
        select: function (event, ui) {

            $('#description').val(ui.item); // on ajoute la description de l'objet dans un bloc
            platChoisi = ui.item.label;


            // je souhaite récupérer la quantité de calorie d'un plat
            /*$.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/recette/getCalorie",
                type: 'get',
                data: {platChoisi: platChoisi},
                dataType: 'JSON',
                success: function (response) {
                    alert(response);
                },
                error: function (e) {
                    console.log(e.responseText);
                },
            });*/
        }
    });
    ;

    $("#ajouter").on("click", function () {

        plat = $('#recette').val();

        $('#i-' + idJour).val(plat);


        $('#recette').val('');

        // si je fais ça, je disable les champs "input" pour forcer l'utilisateur à selectionner un plat avec mon systéme

        //Rajouter un bouton "calculer" pour recalculer les valeurs de chaqu'un des jours

        //ajouter la valeur de l'input dans le champ getById => this.id
        $("#myModal").modal('toggle');
    });


    $(".input").on("change", function () {

        //ajouter la valeur de l'input dans le champ getById => this.id
        //$("#myModal").modal('close');
    });


})
;

