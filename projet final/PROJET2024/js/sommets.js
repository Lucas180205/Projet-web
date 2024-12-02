// Récupération des paramètres de l'URL
const urlParams = new URLSearchParams(window.location.search);
const imageSrc = urlParams.get('image');
const bouton = document.getElementById("boutton_envoyer");
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");
const img = new Image();
var points = [];
bouton.disabled = true;
bouton.style.opacity = "0.5"; // Optionnel
bouton.style.cursor = "not-allowed";


// Affichage de l'image si le paramètre 'src' existe
if (imageSrc) {
    // Chargement de l'image
    img.src = imageSrc;
    img.onload = function() {
        // Définit la taille fixe du canvas
        canvas.width = 500;
        canvas.height = 500;

        // Calcule les ratios pour le redimensionnement et le centrage
        const widthRatio = 500 / img.width;
        const heightRatio = 500 / img.height;
        const scale = Math.max(widthRatio, heightRatio);

        const newWidth = img.width * scale;
        const newHeight = img.height * scale;

        const offsetX = (500 - newWidth) / 2;
        const offsetY = (500 - newHeight) / 2;
        // Dessine l'image redimensionnée et centrée
        context.drawImage(img, offsetX, offsetY, newWidth, newHeight);
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
    
    hiddenPositionPoints.value = points.join(":");
    console.log(hiddenPositionPoints.value);
};

canvas.addEventListener("click", evt => {
	points.push([evt.offsetX, evt.offsetY]);
	dessinerPoints(evt.offsetX, evt.offsetY);
	
})



bouton.addEventListener("click", () =>{
	dessinerForme(points);

})

const dessinerForme = points => {
	 // On réactive le bouton
     bouton.disabled = false; 
     bouton.style.opacity = "1"; 
     bouton.style.cursor = "pointer"; 

     context.lineWidth = 2;

     // Effacer le canvas
     context.clearRect(0, 0, canvas.width, canvas.height); 

     // Redessiner l'image avec redimensionnement et centrage
     const widthRatio = 500 / img.width;
     const heightRatio = 500 / img.height;
     const scale = Math.max(widthRatio, heightRatio);
     const newWidth = img.width * scale;
     const newHeight = img.height * scale;
     const offsetX = (500 - newWidth) / 2;
     const offsetY = (500 - newHeight) / 2;

     context.drawImage(img, offsetX, offsetY, newWidth, newHeight);

     // Tracer la forme
     context.beginPath();
     context.moveTo(points[0][0], points[0][1]); // Commencer au premier point

     // Tracer des lignes vers tous les autres points
     for (let i = 1; i < points.length; i++) {
         context.lineTo(points[i][0], points[i][1]);
     }

     context.closePath(); // Relier le dernier point au premier pour fermer la forme
     context.stroke();

     afficherCoordonnees(); // Mettre à jour les coordonnées
 }


console.log("Chemin de l'image :", imageSrc);

img.onerror = function() {
    console.error("Erreur lors du chargement de l'image :", imageSrc);
    document.body.innerHTML = "<p>Erreur lors du chargement de l'image.</p>";
};

