$(document).ready(function () {


    let wrapper = $("#container_input");

    $("#add_product").on('click', function () {
        $(wrapper).append(`<div class="row"><div class="col"><div class="form-group"><input type="text" class="form-control produit" name="aName[]" placeholder="Entrez un produit"/></div></div><div class="col"><div class="form-group"><input type="text" class="form-control" name="aQuantity[]" placeholder="Entrez son prix"></div></div><div class="col"><div class="form-group"><select class="form-control" name="aUnit[]"><option>Default select</option></select></div></div><a href="#" class="delete">X</a></div>`);
    });

    $(wrapper).on("click", ".delete", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });

    // autocomplete
    /*$(".produit").autocomplete({
        source: "autocomplete",
        select: function( event, ui ) {
            event.preventDefault();
            $(".produit").val(ui.item.id);
        }
    });*/

});