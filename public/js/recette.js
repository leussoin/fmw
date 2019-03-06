$(document).ready(function () {


    let wrapper = $("#container_input");
    let $icpt = 0, sName, iQantity, sUnit;

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

    $(wrapper).on("click", ".delete", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });

    // autocomplete
    $(".produit").autocomplete({
        source: "/produit/autocomplete",
        select: function (event, ui) { // lors de la sélection d'une proposition
            $('#description').val(ui.item); // on ajoute la description de l'objet dans un bloc
        }
    });

});