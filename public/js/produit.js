$(document).ready(function () {
    let wrapper = $("#container_input");
    $("#ajouter_produit").on('click', function () {
        $(wrapper).append(`<div class="row"><div class="col"><div class="form-group"><input type="text" class="form-control produit" placeholder="Entrez un produit" name="aNomProduit[]"/></div></div><div class="col"><div class="form-group"><input type="text" class="form-control" name="aPrixProduit[]" placeholder="Entrez son prix"></div></div><div class="col"><div class="form-group"><input type="text" class="form-control" name="aCaloriesProduit[]" placeholder="Entrez sa valeur calorifique"></div></div><a href="#" class="delete">X</a></div>`);
    });
    $(wrapper).on("click", ".delete", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });


    $(".suppr-produit").on("click", function () {
        let id = $(this).attr("data-id");
        if (confirm("Voulez vous supprimer ce produit ?")) {
            $(this).closest('tr').remove();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/produit/supprimer/" + id,
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


    $('.table tr').on("click", function () {
        let id = $(this).closest("tr").attr("id");
        console.log(id);
        if (id) {
            window.location = "/produit/modifier/"+id;
        }
    });



    //checkbox_deleted_products.checked => true or false














});

