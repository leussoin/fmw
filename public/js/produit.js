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


    //checkbox_deleted_products.checked => true or false


});

