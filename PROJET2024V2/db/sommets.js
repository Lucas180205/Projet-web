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

const dessinerPoints = (x, y) => {
	context.beginPath()
	context.arc(x, y, 1, 0, 2*Math.PI);
	context.fill()
}

const positionPoint = document.getElementById("positionPoint");
const hiddenPositionPoints = document.getElementById("hiddenPoints");

// Fonction pour afficher les coordonnées des points
const afficherCoordonnees = () => {
    positionPoint.textContent = points.join(":");
    hiddenPositionPoints.value = points.join(":");
    console.log(hiddenPositionPoints.value);
};

canvas.addEventListener("click", evt => {
	points.push([evt.offsetX, evt.offsetY]);
	dessinerPoints(evt.offsetX, evt.offsetY);
	afficherCoordonnees();
})


bouton.addEventListener("click", () =>{
	dessinerForme(points);
	afficherCoordonnees();
})

const dessinerForme = points => {
	if (points.length < 2) return; // S'assurer qu'il y a assez de points pour tracer une forme

    context.lineWidth = 2;
    context.clearRect(0, 0, canvas.width, canvas.height); // Effacer le canvas
    context.drawImage(img, 0, 0); // Redessiner l'image de fond pour conserver l'arrière-plan

    context.beginPath();
    context.moveTo(points[0][0], points[0][1]); // Commencer au premier point

    // Tracer des lignes vers tous les autres points
    for (let i = 1; i < points.length; i++) {
        context.lineTo(points[i][0], points[i][1]);
    }

    context.closePath(); // Relier le dernier point au premier pour fermer la forme
    context.stroke();
	afficherCoordonnees();
}

console.log("Chemin de l'image :", imageSrc);

img.onerror = function() {
    console.error("Erreur lors du chargement de l'image :", imageSrc);
    document.body.innerHTML = "<p>Erreur lors du chargement de l'image.</p>";
};
