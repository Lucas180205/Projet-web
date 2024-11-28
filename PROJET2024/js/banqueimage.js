// Tableau des images


// Référence à la liste d'images
const imageListe = document.getElementById("image-liste");

// Création de la liste d'images
images.forEach(image => {
    const item = document.createElement("div");
    item.className = "image-item";

    const img = document.createElement("img");
    img.src = `img/${image.file}`;
    img.alt = "image.name";
    img.addEventListener("click", () => {
        window.location.href = `imageBank.php?position=${image.position}&bank=${bank}`;
    });

    
    const caption = document.createElement("span");
    caption.textContent = image.name;

    item.appendChild(img);
    item.appendChild(caption);
    imageListe.appendChild(item);
});