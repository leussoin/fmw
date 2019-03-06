$(document).ready(function () {


    let wrapper = $("#container_input");
    let $icpt = 0, sName, iQantity, sUnit;

    /**
     * Add product row when add or update product to create a recipe
     */
    $("#add_product").on('click', function () {
        $icpt++;
        sName = $('#name').val();
        iQantity = $('#quantity').val();
        sUnit = $( "#unit option:selected" ).text();

        $(wrapper).append(`<div class="row">`
            + `<div class="col"><div class="form-group"><input value="`+ sName +`" disabled type="text" id="name_` + $icpt + `" class="form-control produit" name="aName[]"/></div></div>`
            + `<div class="col"><div class="form-group"><input value="`+ iQantity +`" disabled type="text" id="quantity_` + $icpt + `" class="form-control" name="aQuantity[]"></div></div>`
            + `<div class="col"><div class="form-group"><input value="`+ sUnit +`" disabled type="text" id="units_` + $icpt + `"class="form-control" name="aUnit[]"></div></div>`
            + `<a href="#" class="delete">X</a></div>`);
       $('#name').val("");
       $('#quantity').val("");
        $( "#unit option:selected" ).text("Unité");
    });

    /**
     * Delete product row when add or update product to create a recipe
     */
    $(wrapper).on("click", ".delete", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });

    /**
     * Display availlable products to add or update a recipe
     */
    // autocomplete
    $(".produit").autocomplete({
        source: "/produit/autocomplete",
        select: function (event, ui) { // lors de la sélection d'une proposition
            $('#description').val(ui.item); // on ajoute la description de l'objet dans un bloc
        }
    });

    /**
     * Soft delete recipe ajax
     */
    $(".suppr-recipe").on("click", function () {
        let id = $(this).attr("data-id");
        if (confirm("Voulez vous supprimer cette recette ?")) {
            $(this).closest('tr').remove();
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
    });
});