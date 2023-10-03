
document.addEventListener('DOMContentLoaded', function() {
    let category_choice;

    let buttons = document.querySelectorAll('.category'); // Récupère tous les boutons de gauche
    let questions = document.querySelectorAll('.objet'); // Récupère toutes les questions/réponses

    let buttonReset = document.querySelector('.reset'); // Récupère le boutton pour reset les catégories

    buttons.forEach(button => {
        button.addEventListener('click', (e) => { // Pour chaque bouton, au click ...
            
            category_choice = e.target.dataset.categorie; // ... on récupère l'attribut data-categorie et on le stocke dans category_choice

            questions.forEach(item => { // ensuite pour chaque question/réponse ...


                if(item.dataset.categorie !== category_choice) { // ... on vérifie si l'attribut data-categorie de l'item est different de category_choice
                    item.style.display = 'none'; // si c'est le cas, on le masque
                } else {
                    item.style.display = 'block'; // sinon on affiche
                }

            })

            

        });
    });

    buttonReset.addEventListener('click', () => { // Reload de la page pour re afficher tous les objets
        window.location.reload();
    });

});



