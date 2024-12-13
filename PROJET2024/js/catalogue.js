// Récupération des paramètres de l'URL
const urlParams = new URLSearchParams(window.location.search);
const imageSrc = urlParams.get('image');
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");
const img = new Image();
var points = [];
affichercanva();
// Affichage de l'image si le paramètre 'src' existe
function affichercanva() {
    return new Promise((resolve) => {
        if (imageSrc) {
            img.src = imageSrc;
            img.onload = function() {
                // Ajuste la taille du canvas
                canvas.width = img.width;
                canvas.height = img.height;
                context.drawImage(img, 0, 0);
                console.log("Image chargée et prête.");
                fonction1Appelée = true;  // Marque l'image comme chargée
                resolve();  // Résout la promesse une fois l'image chargée
            };
        } else {
            document.body.innerHTML = "<p>Aucune image à afficher.</p>";
            resolve();  // Résout immédiatement si aucune image n'est fournie
        }
    });
}
