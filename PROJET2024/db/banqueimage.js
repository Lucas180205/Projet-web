// Tableau des images
const images = [
    { name: "Hello Kitty", file: "img/hellokitty.jpg" },
    { name: "tortue", file: "img/tortue.jpg" },
    { name: "Paon", file: "img/paon.jpg" },
];

// Référence à la liste d'images
const imageListe = document.getElementById("image-liste");

// Création de la liste d'images
images.forEach(image => {
    const item = document.createElement("div");
    item.className = "image-item";

    const img = document.createElement("img");
    img.src = `img/${image.file}`;
    img.alt = image.name;
    img.addEventListener("click", () => {
        window.location.href = `view.html?image=${image.file}`;
    });

    const caption = document.createElement("span");
    caption.textContent = image.name;

    item.appendChild(img);
    item.appendChild(caption);
    imageListe.appendChild(item);
});
