<?php
    include_once("./libLoutre.php");

    if (!isset($_GET['id'])){
        print_r("paramètre id manquant dans l'url");
        http_response_code(400);
    } else {
        $id = $_GET['id'];
        $commentaires = getCommentaires($id);
        header("Content-type : Application/JSON");
        http_response_code(200);
        $commentairesJSON = json_encode($commentaires);
        echo $commentairesJSON;

    }
    
    

?>