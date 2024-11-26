// Récupération des paramètres de l'URL
const urlParams = new URLSearchParams(window.location.search);
const imageSrc = urlParams.get('image');
const bouton = document.getElementById("boutton_envoyer");
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");
const img = new Image();
var points = [];
affichercanva();
let fonction1Appelée = false; 
console.log("to");




// Affichage de l'image si le paramètre 'src' existe
function affichercanva() {
    return new Promise((resolve) => {
        if (imageSrc) {
            img.src = imageSrc;
            img.onload = function() {
                // Ajuste la taille du canvas
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

// Dessiner un point sur le canvas
const dessinerPoints = (x, y) => {
    context.beginPath();
    context.arc(x, y, 1, 0, 2 * Math.PI);
    context.fill();
};

// Fonction pour dessiner les points et la forme
const dessinerPoly = (tab) => {
        for (var j = 0; j < tab.length; j++) {
            console.log(tab[j][0], tab[j][1]);
            dessinerPoints(tab[j][0], tab[j][1]);
        }
        dessinerForme(tab);  // Dessiner la forme complète
          
    }


    
const dessinerForme = points => {
    context.clearRect(0, 0, canvas.newWidth, canvas.newHeight); // Effacer le canvas
    // Ajuste la taille du canvas
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
    context.beginPath();
    context.moveTo(points[0][0], points[0][1]); // Commencer au premier point

    // Tracer des lignes vers tous les autres points
    for (let i = 1; i < points.length; i++) {
        context.lineTo(points[i][0], points[i][1]);
    }

    context.closePath(); // Relier le dernier point au premier pour fermer la forme
    context.stroke();
}

 // Fonction pour créer un bouton
 function createButton(text, id) {
    // Créer un élément bouton
    const button = document.createElement('button');
    button.innerText = text; // Définir le texte du bouton
    button.id = id; // Ajouter un ID au bouton

    document.getElementById('tdd').appendChild(button);
}



// Créer plusieurs boutons dynamiquement

const boutonM = document.getElementById("bouton_masquer");
boutonM.addEventListener("click", () =>{
	location.reload();
})

