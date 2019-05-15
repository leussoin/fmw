$(document).ready(function () {
    let selectedObj;
    $("#produit").autocomplete({
        source: "/produit/autocomplete",
        select: function (event, ui) { // lors de la sélection d'une proposition
            //$('#description').val(ui.item); // on ajoute la description de l'objet dans un bloc
            selectedObj = ui.item;
            console.log(selectedObj);
            $("#produit").val = "";

            $('#liste-ingredients').text(selectedObj.value + ',');

        }
    });
});