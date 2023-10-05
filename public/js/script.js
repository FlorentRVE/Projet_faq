
document.addEventListener('DOMContentLoaded', function() {

    // =================== Variables =====================
    
    let category_choice;
    
    let buttons = document.querySelectorAll('.category'); // Récupère tous les éléments avec la classe category de la page FAQ
    let buttonsAdmin = document.querySelectorAll('.categoryAdmin'); // Récupère tous les éléments avec la classe categoryAdmin du pannel d'administration
    let questions = document.querySelectorAll('.objet'); // Récupère toutes les questions/réponses avec la classe objet    
    let buttonReset = document.querySelector('.reset'); // Récupère l'élement pour reset les catégories


    
    // ================ Evènement pour la page FAQ numéro client ======================

    buttons.forEach(button => {
        button.addEventListener('click', (e) => { // Pour chaque bouton (City ker, vert, velo), au click ...

            category_choice = e.target.dataset.categorie; // ... on récupère l'attribut data-categorie et on le stocke dans category_choice
            
            questions.forEach(item => { // ensuite pour chaque question/réponse ...                
                
                if(item.dataset.categorie !== category_choice) { // ... on vérifie si l'attribut data-categorie de l'item est different de category_choice
                    item.style.display = 'none'; // si c'est le cas, on le masque
                } else {
                    item.style.display = 'block'; // sinon on le montre
                }
                
            }) 
            
        });
    });

    // ==================== Evènement pour le panneau d'administration FAQ =================

    buttonsAdmin.forEach(button => {
        button.addEventListener('click', (e) => { // Pour chaque bouton (City ker, vert, velo), au click ...

            category_choice = e.target.dataset.categorie; // ... on récupère l'attribut data-categorie et on le stocke dans category_choice
            
            questions.forEach(item => { // ensuite pour chaque question/réponse ...                
                
                if(item.dataset.categorie !== category_choice) { // ... on vérifie si l'attribut data-categorie de l'item est different de category_choice
                    item.style.display = 'none'; // si c'est le cas, on le masque
                } else {
                    item.style.display = 'table-row'; // sinon on le montre
                }
                
            }) 
            
        });
    });
    
    // ============= Boutton reset pour recharger la page ================

    buttonReset.addEventListener('click', () => { // Reload la page pour re afficher tous les objets
        window.location.reload();
    });

});



