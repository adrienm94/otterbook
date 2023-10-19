<?php

function getLoutreById($id) {
    // connexion à la base de données SQL
    $pdo = new PDO('sqlite:otterbook.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // requête de sélection de la loutre ayant l'identifiant $id (colonne "id"), et de toutes les images liées
    $requeteSQL = "SELECT * FROM loutres LEFT JOIN images ON loutres.id = images.id_loutre WHERE loutres.id=" . $id;
    // exécution de la requête
    $stm = $pdo->query($requeteSQL);
    // récupération des résultats
    $infosLoutreBrutes = $stm->fetchAll(PDO::FETCH_ASSOC);
    // compilation de toutes les images dans un tableau
    $imagesLoutre = [];
    foreach ($infosLoutreBrutes as $ilb) {
        array_push($imagesLoutre, $ilb["url"]);
    }
    // extraction de la première ligne de résultats (elles contiennent toutes les mêmes données sur la loutre demandée)
    $infosLoutre = $infosLoutreBrutes[0];
    // suppression de la case "url" d'origine
    unset($infosLoutre["url"]);
    // ajout du tableau d'images à cette ligne, dans une nouvelle case "images"
    $infosLoutre["images"] = $imagesLoutre;

    return $infosLoutre;
}

function getAmis($id) {
    // connexion à la base de données SQL
    $pdo = new PDO('sqlite:otterbook.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // requête de sélection des amis de la loutre ayant l'identifiant $id
    $requeteSQL = "SELECT * FROM amis WHERE id_loutre_a=" . $id . " OR id_loutre_b=" . $id;
    // exécution de la requête
    $stm = $pdo->query($requeteSQL);
    // récupération du résultat
    $amisLoutre = $stm->fetchAll(PDO::FETCH_ASSOC);
    // agrégation des identifiants des amis en une liste à plat
    $amis = [];
    foreach ($amisLoutre as $a) {
        if ($a["id_loutre_a"] == $id) {
            array_push($amis, $a["id_loutre_b"]);
        } else {
            array_push($amis, $a["id_loutre_a"]);
        }
    }
    return $amis;
}

function getCommentaires($id) {
    // connexion à la base de données SQL
    $pdo = new PDO('sqlite:otterbook.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // requête de sélection des commentaires concernant la loutre ayant l'identifiant $id,
    // triés par ordre chronologique inverse
    $requeteSQL = "SELECT * FROM commentaires WHERE id_loutre=" . $id . " ORDER BY date DESC";
    // exécution de la requête
    $stm = $pdo->query($requeteSQL);
    // récupération du résultat
    $commLoutre = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $commLoutre;
}

function addCommentaire($infosComm) {
    // connexion à la base de données SQL
    $pdo = new PDO('sqlite:otterbook.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // requête d'insertion de données; l'identifiant est automatique si on ne le fournit pas
    $requeteSQL = "INSERT INTO commentaires (id_loutre, texte, auteur, date) VALUES(:id_loutre, :texte, :auteur, :date)";
    // exécution de la requête
    $stmt = $pdo->prepare($requeteSQL);
    // $stmt->debugDumpParams();
    return $stmt->execute($infosComm);
}

function addLoutre($infosLoutre) {
    // connexion à la base de données SQL
    $pdo = new PDO('sqlite:otterbook.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // requête d'insertion de données; l'identifiant est automatique si on ne le fournit pas
    $requeteSQL = "INSERT INTO loutres (nom, nom_latin, image, description, taille_min, taille_max, pelage, poids_min, poids_max) VALUES(:nom, :nom_latin, :image, :description, :taille_min, :taille_max, :pelage, :poids_min, :poids_max)";
    // exécution de la requête
    $stmt = $pdo->prepare($requeteSQL);
    // $stmt->debugDumpParams();
    return $stmt->execute($infosLoutre);
}
