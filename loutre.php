<?php
include_once("./libLoutre.php");
$idLoutre = $_GET["id"];
$infosLoutre = getLoutreById($idLoutre);
$infosAmis = getAmis($idLoutre);
// print_r($infosLoutre);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Loutre</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="./style.css">
    <script src="./loutre.js"></script>
</head>

<body>
    <header>
        <p id="logo">otterbook</p>
    </header>
    <main>
        <div id="profil">
            <h2>
                <?php echo $infosLoutre["nom"]; ?>
            </h2>
            <h3>
                <?php echo $infosLoutre["nom_latin"]; ?>
            </h3>
            <button>Interrompre/Reprendre le diaporama</button>
            <br>
            <br>
            <?php
                $images = $infosLoutre["images"];
                foreach ($images as $index => $url) {
                    $alt = str_replace(" ","_",$infosLoutre['nom']);
                    echo "<img class='rounded-circle' src=" . $url . " alt=" . "$alt" . " >";
                };
            ?>
            <p>
                <?php echo $infosLoutre['description']; ?>
            </p>
        </div>
        <div id="description">
            <ul>
                <li><span class="element-description">Taille :</span>
                    <?php echo $infosLoutre['taille_min']; ?> à
                    <?php echo $infosLoutre['taille_max']; ?>cm de long
                </li>
                <li><span class="element-description">Pelage :</span>
                    <?php echo $infosLoutre['pelage']; ?>
                </li>
                <li><span class="element-description">Poids :</span>
                    <?php echo $infosLoutre['poids_min']; ?> à
                    <?php echo $infosLoutre['poids_max']; ?>kg
                </li>
            </ul>
        </div>
        <div id="amis">
            <h2>Amis</h2>
            <ul>
                <?php
                foreach ($infosAmis as $key => $value) {
                    $idAmi = $value;
                    $infosLoutreAmie = getLoutreById($idAmi);
                    echo "<li><a href='./loutre.php?id=$idAmi'>" . $infosLoutreAmie["nom"] . "</a></li>";
                }
                ?>
            </ul>
        </div>
        <div id="commentaires">
            <h2>Commentaires</h2>
            <div id="ajout-commentaire">
                <form id="form-ajout-commentaire">
                    <label for="auteur">Auteur :</label>
                    <input type="text" name="auteur" id="auteur"><br>
                    <label for="texte">Texte :</label>
                    <textarea name="texte" id="texte" cols="30" rows="10"></textarea><br><br>
                    <input type="submit" value="Envoyer">
                </form>
            </div>
            <div id="liste-commentaires" data-idloutre=<?php  echo $_GET['id'] ?>></div>
        </div>
    </main>
</body>

</html>