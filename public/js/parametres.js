$(document).ready(function () {
    let selectedObj, produit;


    $("#produit").autocomplete({
        source: "/produit/autocomplete",
        select: function (event, ui) { // lors de la sélection d'une proposition
            //$('#description').val(ui.item); // on ajoute la description de l'objet dans un bloc
            selectedObj = ui.item;
            console.log(selectedObj.value);
            $("#produit").html('');
            produit = '<span class="box-product">' + selectedObj.value + '<i class="delete far fa-window-close"></i></span>';
            $("#div-textarea").append(produit);

        }
    });

    $(document).on("submit", "form", function (e) {
        let produitDeteste = "";
        e.preventDefault();
        $(".box-product").each(function () {
            if (this.innerHTML.length > 0) {
                produitDeteste += this.innerHTML.replace('<i class="delete far fa-window-close"></i>', '') + ";";
            }
        });
        $("#products").val(produitDeteste);

        if ($("#password").val() === $("#confirm-password").val()) {
            document.getElementById("formulaire").submit();        } else {
            alert('Les mots de passe ne correspondent pas');
        }

    });

    $('#produit').click(function () {
        $(this).select();
    });

    $(document).on("click", '.delete', function () {
        $(this).closest('span').remove();
    });


});






