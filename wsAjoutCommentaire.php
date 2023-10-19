<?php

    include_once("./libLoutre.php");

    $idLoutre = $_POST["id_loutre"];
    $texte = $_POST["texte"];
    $auteur = $_POST["auteur"];
    $date = $_POST["date"];




    $infosComm = ["id_loutre" => $idLoutre, "texte" => $texte, "auteur" => $auteur, "date" => $date];
    // print_r($infosComm);
    $commAjoutes = addCommentaire($infosComm);

    if ($commAjoutes) {
        http_response_code(200);
    }

?>