// Gestion diaporama
document.addEventListener("DOMContentLoaded", function () {

    let images = document.getElementsByTagName("img");
    let boutonDiapo = document.getElementsByTagName("button");
    // console.log(boutonDiapo);
    let enPause = false;
    let index = 1;

    function diaporama() {
        if (!enPause) {
            if (index === images.length) {
                index = 0;
            }
            for (let i = 0; i < images.length; i++) {
                if (i != index) {
                    images[i].style.display = "none";
                } else {
                    images[i].style.display = "block";
                }
            }
            index++;
        }

    }

    // Gestion de l'arrêt et de la reprise du diaporama par bouton
    boutonDiapo[0].addEventListener("click", () => {
        if (enPause) {
            enPause = false;
            console.log("Reprise du diaporama (bouton)");
        } else {
            enPause = true;
            console.log("Diaporama en pause (bouton)");
        }
    });

    // Gestion de l'arrêt et de la reprise du diaporama par survol de la souris sur l'image
    for (const image of images) {
        image.addEventListener("mouseover", () => {
            if (enPause) {
                enPause = false;
                console.log("Reprise du diaporama (survol)");
            } else {
                enPause = true;
                console.log("Diaporama en pause (survol)");
            }
        })
    }

    // Exécution de la fonction diaporama toutes les 1.5 secondes
    setInterval(diaporama, 1500);

});


// Gestion de l'affichage des commentaires
document.addEventListener("DOMContentLoaded", function () {

    function affichageCommentaires() {
        let request = new XMLHttpRequest();
        let comm = document.getElementById("liste-commentaires");
        let idLoutre = comm.dataset.idloutre;

        request.addEventListener("load", function (data) {
            // console.log(data.target);
            let ret = data.target.responseText;
            ret = JSON.parse(ret);
            let new_html = "";
            // console.log(ret);
            for (let index = 0; index < ret.length; index++) {
                new_html += "<p>" + ret[index]["auteur"] + "<br>"
                    + "<br>" + ret[index].date + "<br>"
                    + "<p>" + ret[index].texte + "</p>" + "<hr>";
            };
            comm.innerHTML = new_html;
        })

        request.open("GET", "./wsListeCommentaires.php?id=" + idLoutre);
        request.send();
    }

    setInterval(affichageCommentaires, 500);

});


// Gestion de l'ajout de commentaires
document.addEventListener("DOMContentLoaded", function () {
    let formulaire = document.getElementById("form-ajout-commentaire");
    let comm = document.getElementById("liste-commentaires");

    formulaire.addEventListener("submit", function (event) {
        event.preventDefault();
        let request = new XMLHttpRequest();
        let dataForm = new FormData(formulaire);
        let date = new Date().toISOString();
        dataForm.append("date", date);
        dataForm.append("id_loutre", comm.dataset.idloutre);
        console.log(dataForm);
        request.open("POST", "wsAjoutCommentaire.php");
        request.send(dataForm);
        
    })

});