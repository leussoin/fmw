$(document).ready(function () {

    calculateCalories();

    $(".input").on("change", function () {
        calculateCalories();
    });





    let idJour, plat, platChoisi, inputClass, inputId;


    $(".modale").on("click", function () {
        idJour = $(this).attr('id');
        // je récupére l'input utilisateur
        if ($('#i-' + idJour).val().length > 0) {
            $('#recette').val($('#i-' + idJour).val());
        }
        delete idJour;
        $("#myModal").modal('show');
    });

    $(".input").autocomplete({
        //$(".input").autocomplete({
        source: "/recette/autocomplete",
        select: function (event, ui) {

            $('#description').val(ui.item); // on ajoute la description de l'objet dans un bloc
            platChoisi = ui.item.label;

        }
    });

    $("#ajouter").on("click", function () {

        plat = $('#recette').val();
        $('#i-' + idJour).val(plat);
        $('#recette').val('');
        $("#myModal").modal('toggle');
    });


    $("#-").on("click", function () {
        console.log('ok');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/recette/getCalorie",
            type: 'get',
            data: {tableauRecette: tableauRecette},
            dataType: 'JSON',
            success: function () {


            },
            error: function (e) {
                //console.log(e.responseText);
            }
        });
    });

    $(".input").on("click", function () {
        $(this).select();
    });


});


function calculateCalories() {
    //$("#calcul").on("click", function () {

    let tableauRecette = [];
    let platDuJour, jour, repas, calories = 0, totalCalories = 0;
    $(".input").each(function () {
        if ($(this).val().length > 0) {

            inputClass = $(this).attr("class").toString().split(" ");
            platDuJour = $(this).val();
            switch (inputClass[1]) {
                case 'lu':
                    $(this).attr("id")[$(this).attr("id").length - 1] == 'm' ? tableauRecette.push({'i-lm': platDuJour}) : tableauRecette.push({'i-ls': platDuJour});
                    break;
                case 'ma':
                    $(this).attr("id")[$(this).attr("id").length - 1] == 'm' ? tableauRecette.push({'i-mam': platDuJour}) : tableauRecette.push({'i-mas': platDuJour});
                    break;
                case 'mer':
                    $(this).attr("id")[$(this).attr("id").length - 1] == 'm' ? tableauRecette.push({'i-mem': platDuJour}) : tableauRecette.push({'i-mes': platDuJour});
                    break;
                case 'jeu':
                    $(this).attr("id")[$(this).attr("id").length - 1] == 'm' ? tableauRecette.push({'i-jm': platDuJour}) : tableauRecette.push({'i-js': platDuJour});
                    break;
                case 'ven':
                    $(this).attr("id")[$(this).attr("id").length - 1] == 'm' ? tableauRecette.push({'i-vm': platDuJour}) : tableauRecette.push({'i-vs': platDuJour});
                    break;
                case 'sam':
                    $(this).attr("id")[$(this).attr("id").length - 1] == 'm' ? tableauRecette.push({'i-sm': platDuJour}) : tableauRecette.push({'i-ss': platDuJour});
                    break;
                case 'dim':
                    $(this).attr("id")[$(this).attr("id").length - 1] == 'm' ? tableauRecette.push({'i-dm': platDuJour}) : tableauRecette.push({'i-ds': platDuJour});
                    break;
                default:
                    console.log('pas de jour');
            }
            inputId = $(this).attr("id");
        }
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/recette/getCalorie",
        type: 'get',
        data: {tableauRecette: tableauRecette},
        dataType: 'JSON',
        success: function (response) {
            for (let prop in response) {
                //console.log(response[prop]);

                if (prop === 'i-lm' || prop === 'i-ls') {
                    calories += response[prop];
                    $('#lu').val(calories);
                    if (prop === 'i-ls') {
                        calories = 0;
                    }

                } else if (prop === 'i-mam' || prop === 'i-mas') {
                    calories += response[prop];
                    $('#ma').val(calories);
                    if (prop === 'i-mas') {
                        calories = 0;
                    }
                } else if (prop === 'i-mem' || prop === 'i-mes') {
                    calories += response[prop];
                    $('#mer').val(calories);
                    if (prop === 'i-mes') {
                        calories = 0;
                    }
                } else if (prop === 'i-jm' || prop === 'i-js') {
                    calories += response[prop];
                    $('#jeu').val(calories);
                    if (prop === 'i-js') {
                        calories = 0;
                    }
                } else if (prop === 'i-vm' || prop === 'i-vs') {
                    calories += response[prop];
                    $('#ve').val(calories);
                    if (prop === 'i-vs') {
                        calories = 0;
                    }
                } else if (prop === 'i-sm' || prop === 'i-ss') {
                    calories += response[prop];
                    $('#sam').val(calories);
                    if (prop === 'i-ss') {
                        calories = 0;
                    }
                } else if (prop === 'i-dm' || prop === 'i-ds') {
                    calories += response[prop];
                    $('#dim').val(calories);
                    if (prop === 'i-ds') {
                        calories = 0;
                    }
                }
            }

            totalCalories = 0;
            $(".cal").each(function () {
                if ($(this).val().length > 0) {
                    if ($(this).val() > 2400) {
                        $(this).css("background", "red");
                    } else {
                        $(this).css("background", "green");
                    }
                    totalCalories += parseInt($(this).val());
                }
            });
            if (totalCalories > 16800) {
                alert('Attention cette semaine ne corresponds pas a vos attentes');
            }
            $('#total').val(totalCalories);

            /*var myarr = response.toString().split(",");
            var total = parseInt(myarr[0]) + parseInt(myarr[1]);
            $('#lu').val(total);*/
        },
        error: function (e) {
            //console.log(e.responseText);
        }
    });

    //});
}