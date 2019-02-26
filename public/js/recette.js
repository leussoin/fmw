$(document).ready(function () {

    var wrapper = $("#container_input");

    $("#ajouter_ingredient").click(function () {
        $(wrapper).append('<div class="form-group"><input type="text" class="form-control produit" placeholder="Entrez un ingrédient" name="aIngredient[]"/><a href="#" class="delete">Effacer</a></div>');
    });

    $(wrapper).on("click", ".delete", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });

    // autocomplete
    /*$(".produit").autocomplete({
        source: "autocomplete",
        select: function (event, ui) {
            event.preventDefault();
            $(".produit").val(ui.item.id);
        }
    });*/


});

