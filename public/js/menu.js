$(document).ready(function () {

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


            // je souhaite récupérer la quantité de calorie d'un plat
            /*$.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/recette/getCalorie",
                type: 'get',
                data: {platChoisi: platChoisi},
                dataType: 'JSON',
                success: function (response) {
                    alert(response);
                },
                error: function (e) {
                    console.log(e.responseText);
                },
            });*/
        }
    });


    $("#ajouter").on("click", function () {

        plat = $('#recette').val();
        $('#i-' + idJour).val(plat);
        $('#recette').val('');
        $("#myModal").modal('toggle');
    });

    $("#calcul").on("click", function () {
        //let tableauRecette = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
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
                        $(this).attr("id")[$(this).attr("id").length - 1] == 'm' ? tableauRecette.push({'i-mem': platDuJour}) : tableauRecette.push({'i-mem': platDuJour});
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
                console.log(response);
                for (let prop in response) {

                    calories += response[prop];
                    console.log(calories);
                    if (prop == 'i-lm' || prop == 'i-ls') {
                        $('#lu').val(calories);
                    } else if (prop == 'i-mam' || prop == 'i-mas') {
                        $('#ma').val(calories);
                    } else if (prop == 'i-mem' || prop == 'i-mes') {
                        $('#mer').val(calories);
                    }

                    totalCalories += calories;
                    //calories = 0;

                    //console.log('ID du jour : '+prop+ '=' + response[prop]);
                }
                $('#total').val(totalCalories);


                /*var myarr = response.toString().split(",");
                var total = parseInt(myarr[0]) + parseInt(myarr[1]);
                $('#lu').val(total);*/


            },
            error: function (e) {
                //console.log(e.responseText);
            },
        });
    });


})
;

