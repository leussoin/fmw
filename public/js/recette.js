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
        sUnit = $("#unit option:selected").text();


        $(wrapper).append(`<div class="row">`
            + `<div class="col"><div class="form-group"><input placeholder="Entrez un produit" value="` + sName + `"  type="text" id="name_` + $icpt + `" class="form-control produit" name="aProductName[]"/></div></div>`
            + `<div class="col"><div class="form-group"><input placeholder="Quantité" value="` + iQantity + `"  type="text" id="quantity_` + $icpt + `" class="form-control" name="aQuantity[]"></div></div>`
            + `<div class="col"><div class="form-group"><select id="units_` + $icpt + `" class="form-control unit-select" name="aUnit[]"><option>Choisissez l'unité</option></div></div>`
            + `<a href="#" class="delete">X</a></div>`);


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/recette/getUnitAjax",
            type: 'get',
            dataType: 'JSON',
            success: function (data, status, error) {
                // pour chaque ligne dans mon tableau d'unités
                // pour chaque valeur j'ajoute une option
                data.forEach(function (unit) {
                    $('.unit-select').append('<option value=' + unit.id + '>' + unit.name + '</option>');
                });
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

        $('#name').val("");
        $('#quantity').val("");
        $("#unit option:selected").text("Unité");
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

    /**
     * redirect to update product view
     */
    $('.table tr').on("click", function () {
        let id = $(this).closest("tr").attr("id");
        console.log(id);
        if (id) {
            window.location = "/recette/modifier/" + id;
        }
    });


});