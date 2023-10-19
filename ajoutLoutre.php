<html>

<?php
    // Comment servir cette page :
    // ---------------------------
    //
    // cd ~/otterbook
    // php -S localhost:8000
    // => http://localhost:8000/ajoutLoutre.php

require_once("libLoutre.php");

$infosLoutre = null;

var_dump($_REQUEST);

var_dump($_FILES);

if (! empty($_REQUEST["nom"])) {
    // gestion de l'envoi de fichier
    if (! empty($_FILES["image"])) {
        $tmpName = $_FILES["image"]["tmp_name"];
        $nomImage = $_FILES["image"]["name"];
        move_uploaded_file($tmpName, "./images/" . $nomImage);
    }
    $donneesLoutre = $_REQUEST;
    $donneesLoutre["image"] = "images/" . $nomImage;
    var_dump($donneesLoutre);
    $ok = addLoutre($donneesLoutre);
    var_dump($ok); // debug
}
?>

<head>
    <title>Ajouter une nouvelle loutre</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>
    <!-- barre d'entête -->
    <header>
        <div id="logo">
            otterbook - ajout de loutre
        </div>
    </header>

    <!-- conteneur flex -->
    <main>
        <form id="nouvelle-loutre" enctype="multipart/form-data" method="post">
            <label>Nom</label>
            <input type="text" name="nom" required pattern="[a-zA-Z -]+">
            <br>
            <label>Nom latin</label>
            <input type="text" name="nom_latin" required>
            <br>
            <label>Image</label>
            <!--<input type="url" name="image">-->
            <input type="file" name="image">
            <br>
            <label>Description</label>
            <br>
            <textarea name="description" required></textarea>
            <br>
            <label>Taille minimale (cm)</label>
            <input type="number" min="10" max="200" name="taille_min">
            <br>
            <label>Taille maximale (cm)</label>
            <input type="number" min="10" max="200" name="taille_max">
            <br>
            <label>Pelage</label>
            <select name="pelage">
                <option value="brun foncé">Brun foncé</option>
                <option value="brun clair">Brun clair</option>
                <option value="noir">Noir</option>
                <option value="blanc">Blanc</option>
                <option value="autre">Rouge et vert à petits pois</option>
            </select>
            <br>
            <label>Poids minimal (kg)</label>
            <input type="number" min="1" max="50" name="poids_min">
            <br>
            <label>Poids maximal (kg)</label>
            <input type="number" min="20" max="500" name="poids_max">
            <br>
            <input type="submit" value="Ajouter">
        </form>
    </main>
</body>

</html>