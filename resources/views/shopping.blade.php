<?php App\Misc::isAuth(); ?>


@extends('layouts/master', ['title' => "liste" ])
@section('content')

    <h1>Voici votre liste de course pour la semaine du tant au tant</h1>
    <?php
            var_dump($aUnit);

    if (!empty($aListeDeProduit)) {
    echo "<ul>";
    foreach ($aListeDeProduit as $product => $quantity) { ?>
    <li><?php echo $product . " - " . $quantity; ?></li>
    <?php }
    echo "</ul>";

    }
    ?>
@endsection

