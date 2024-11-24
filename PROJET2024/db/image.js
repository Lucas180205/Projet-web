// Récupération des paramètres de l'URL
const urlParams = new URLSearchParams(window.location.search);
const imageSrc = urlParams.get('image');
const bouton = document.getElementById("boutton_envoyer");
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");
const img = new Image();
var points = [];

// Affichage de l'image si le paramètre 'src' existe
if (imageSrc) {
    // Chargement de l'image
    img.src = imageSrc;
    img.onload = function() {
        // Ajuste la taille du canvas à celle de l'image
        canvas.width = img.width;
        canvas.height = img.height;
        context.drawImage(img, 0, 0);
    };
} else {
    document.body.innerHTML = "<p>Aucune image à afficher.</p>";
} 






