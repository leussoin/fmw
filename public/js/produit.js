$(document).ready(function () {


    let wrapper = $("#container_input");

    /**
     * Delete product row when add or update product to create a recipe
     */
    $(wrapper).on("click", ".delete", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });

    /**
     * Soft delete recipe ajax
     */
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

    /**
     * redirect to update product view
     */
    $('.datatable tr').on("click", function () {
        let id = $(this).closest("tr").attr("id");
        console.log(id);
        if (id) {
            window.location = "/produit/modifier/" + id;
        }
    });


    /**
     * Check inputs before submit
     */
    $('.btn-primary').on("click", function (event) {
        let cal = $("#cal").val();
        let productName = $(".produit").val();
        let price = $("#price").val();


        console.log(cal);

        event.preventDefault();
        // si c'est un nombre
        if (!isNaN(parseFloat(cal))) {
            console.log(cal + "est un nombre");
            if (productName.length > 0) {
                console.log(productName + " INPUT ok");
                if (price.length == 1 && !isNaN(parseInt(price))) {
                    console.log("Tout es ok je peux envoyer");
                    $( "#form-product" ).submit();

                } else {
                    console.log('faut mettre un prix')
                }
            } else {
                console.log(productName + " c'est vide");
            }
        } else {
            console.log(cal + "n'est un nombre");
        }
    });



// si je clique sur une valeur plus faible alors les symbols redeviennent normaux
//http://fmw.com/svg/euros_vide.png
    //checkbox_deleted_products.checked => true or false


});

