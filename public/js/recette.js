$(document).ready(function () {

    let wrapper = $("#container_input");
    let icpt = 0, sName, iQantity, iIdUnit;

    /**
     * Add product row when add or update product to create a recipe
     */
    $("#add_product").on('click', function () {

        console.log("click");

        icpt++;
        sName = $('#name').val();
        iQantity = $('#quantity').val();
        iIdUnit = $("#unit option:selected").val();

        console.log(sName, iQantity, iIdUnit);

        // ajout de la nouvelle ligne
        $(wrapper).append(`<div class="row">`
            + `<div class="col"><div class="form-group"><input placeholder="Entrez un produit" value="` + sName + `"  type="text" id="name_` + icpt + `" class="form-control produit" name="aProductName[]"/></div></div>`
            + `<div class="col"><div class="form-group"><input placeholder="Quantité" value="` + iQantity + `"  type="text" id="quantity_` + icpt + `" class="form-control quantity" name="aQuantity[]"></div></div>`
            + `<div class="col"><div class="form-group"><select id="units_` + icpt + `" class="form-control unit-select" name="aUnit[]"><option>Choisissez l'unité</option></select></div></div>`
            + `<a href="#" class="delete">X</a></>`);

        // recupération des unités
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/recette/getUnitAjax",
            type: 'get',
            dataType: 'JSON',
            // construction de mes options sur la valeur choisie
            success: function (data, status, error) {
                data.forEach(function (unit) {
                    $('#units_' + icpt).append('<option value=' + unit.id + '>' + unit.name + '</option>');
                });
                $('#units_' + icpt).val(iIdUnit);
                // selectionne de base choisissez l'unité
                document.getElementById("units_" + icpt).selectedIndex = "0";

            },
            error: function (e) {
                console.log(e.responseText);
            },


        });


        $(".produit").autocomplete({
            source: "/produit/autocomplete",
            select: function (event, ui) { // lors de la sélection d'une proposition
                $('#description').val(ui.item); // on ajoute la description de l'objet dans un bloc
            }
        });


        // reset des valeurs du premier champ
        $('#name').val("");
        $('#quantity').val("");
        $("#unit").prop('selectedIndex', 0);

    });

    /**
     * Delete product row when add or update product to create a recipe
     */
    $('.delete').on("click", function (e) {
        console.log('click');
        $(this).closest('.row').remove();
        e.preventDefault();

    });

    /**
     * Display availlable products to add or update a recipe
     */
    $(".produit").autocomplete({
        source: "/produit/autocomplete",
        select: function (event, ui) { // lors de la sélection d'une proposition
            $('#description').val(ui.item); // on ajoute la description de l'objet dans un bloc
        }
    });

    /**
     * Soft delete recipe ajax
     */
    $(".suppr-recipe").on("click", function (e) {
        let id = $(this).attr("data-id");
        if (confirm("Voulez vous supprimer cette recette ?")) {
            $(this).closest('tr').css('background', 'pink');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/recette/supprimer/" + id,
                type: 'post',
                data: {id: id},
                dataType: 'JSON',

                success: function (response) {

                    alert(response);
                },
                error: function (e) {
                    console.log(e.responseText);
                },
            });
        }
        e.stopPropagation();

    });

    /**
     * redirect to update product view
     */
    $('.datatable tr').on("click", function () {
        let id = $(this).closest("tr").attr("id");
        console.log(id);
        if (id) {
            window.location = "/recette/modifier/" + id;
        }
    });


    /**
     * Check inputs before submit
     */
    $('.btn-primary').on("click", function (event) {

        event.preventDefault();

        var recipeName = $("#recipeName").val();
        var aProductName = new Array();
        var aQuantity = new Array();
        var aUnit = new Array();
        var error = "";


        $('.produit').each(function () {
            aProductName.push($(this).val());
        });

        $('.quantity').each(function () {
            aQuantity.push($(this).val());
        });

        $('.unit-select').each(function () {
            aUnit.push($(this).val());
        });


        if (recipeName.length > 3) {

            $.each(aProductName, function (key, value) {
                // si j'ai un nom de produit
                if (value.length > 0) {
                    console.log(value.length);
                    // si j'ai une quantité
                    if (aQuantity[key].length > 0 && !isNaN(parseInt(aQuantity[key]))) {
                        console.log(aQuantity[key].length);
                        // verifier quelle valeur il prends: est sa value ? ou bien la valeur 'affichée'
                        if (aUnit[key].length > 0) {
                            console.log(aUnit[key].length);
                            error = '';
                        } else {
                            error = "Erreur sur l'unité";
                            $(this.input).css("background", "red");
                            return false;
                        }
                    } else {
                        error = "Erreur sur quantité";
                        $(this.input).css("background", "red");
                        return false;
                    }
                } else {
                    error = "Pas de nom";
                    $(this.input).css("background", "red");
                    return false;
                }
            })

        } else {
            error = "Le nom de la recette doit faire au moins 3 caractéres";
        }

        if (error.length == 0) {
            $( "#form-recipe" ).submit();

        }

        console.log(error);


    });


});

