$(document).ready(function () {

    var price = $("#price").val();
    if (price == 1) {
        $('#euro-vert').attr('src', 'http://fmw.com/svg/euros_vert.png' );
    } else if (price == 2) {
        $('#euro-vert').attr('src', 'http://fmw.com/svg/euros_vert.png' );
        $('#euro-orange').attr('src', 'http://fmw.com/svg/euros_orange.png' );

    } else if (price == 3) {
        $('#euro-vert').attr('src', 'http://fmw.com/svg/euros_vert.png' );
        $('#euro-orange').attr('src', 'http://fmw.com/svg/euros_orange.png' );
        $('#euro-rouge').attr('src', 'http://fmw.com/svg/euros_rouge.png' );
    }

    $('.datatable').DataTable( {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/French.json'
        }
    });


    $('#euro-vert').on("click", function () {
        $(this).attr('src', 'http://fmw.com/svg/euros_vert.png' );
        $('#euro-orange').attr('src', 'http://fmw.com/svg/euros_vide.png' );
        $('#euro-rouge').attr('src', 'http://fmw.com/svg/euros_vide.png' );
        $("#price").val("1");

    });

    $('#euro-orange').on("click", function () {
        $(this).attr('src', 'http://fmw.com/svg/euros_orange.png' );
        $('#euro-vert').attr('src', 'http://fmw.com/svg/euros_vert.png' );
        $('#euro-rouge').attr('src', 'http://fmw.com/svg/euros_vide.png' );
        $("#price").val("2");

    });

    $('#euro-rouge').on("click", function () {
        $(this).attr('src', 'http://fmw.com/svg/euros_rouge.png' );
        $('#euro-vert').attr('src', 'http://fmw.com/svg/euros_vert.png' );
        $('#euro-orange').attr('src', 'http://fmw.com/svg/euros_orange.png' );
        $("#price").val("3");
    });











});