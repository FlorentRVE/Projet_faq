
document.addEventListener('DOMContentLoaded', function() {

    // ================================ Variables ============================
    
    let category_choice;
    
    let buttons = document.querySelectorAll('.category'); // Récupère tous les boutons de sélection de catégorie
    let questions = document.querySelectorAll('.objet'); // Récupère toutes les blocs questions/réponses
    let toggleBtn = document.querySelectorAll('.toggleBtn'); // Collapse toggle bouton
    let containers = document.querySelectorAll('.container'); // Récupère tous les conteneurs de sous-catégories
    
    let buttonReset = document.querySelector('.reset'); // Récupère le boutton pour reset les catégories

    let toggleDark = document.querySelector('.toggleDark'); // Dark mode toggle bouton
    let containerDark = document.documentElement; // Récupération de la balise <html> pour y toggle la classe 'dark'
    



    // ================================== Fonctions ====================================

    // =================== Fonctions permettant d'afficher les sous-catégories seulement s'il y a au moins un objet de visible =====================
    function toggleContainer(container) {
        let childObjects = container.querySelectorAll('.objet'); // Récupère tous les blocs questions/réponses avec la classe objet et correspondant à la sous-catégorie
        let allHidden = true; // Variable 'Tout caché'
      
        childObjects.forEach(div => { // Pour chaque bloc ...
          if (div.style.display !== 'none') { // ... on vérifie si le display est différent de none
            allHidden = false; // si c'est le cas, on passe la variable 'Tout caché' à false, car il y a au moins un élément visible
          }
        });
      
        container.style.display = allHidden ? 'none' : ''; // si la variable 'Tout caché' est True, on masque le conteneur, sinon on l'affiche
      }

    
    
    
      // ========================== Evènement sélection catégorie ==============================

    buttons.forEach(button => {
        button.addEventListener('click', (e) => { // Pour chaque bouton (City ker, vert, velo), au click ...

            category_choice = e.target.dataset.departement; // ... on récupère l'attribut data-categorie du bouton et on le stocke dans category_choice

            questions.forEach(item => { // ensuite pour chaque bloc question/réponse ...                
                
                if(item.dataset.departement !== category_choice) { // ... on vérifie si l'attribut data-categorie du bloc est different de category_choice
                    item.style.display = 'none'; // si c'est le cas, on le masque
                } else {
                    item.style.display = ''; // sinon on le montre
                }
                
            })


            // // Appel de la fonction permettant d'afficher les sous-catégories seulement s'il y a au moins un objet de visible pour chaque sous-catégorie
            containers.forEach(container => {
                toggleContainer(container);
            });

                        
        });
    });
    
    // ============= Boutton reset pour recharger la page ================

    buttonReset.addEventListener('click', () => { // Reload la page pour re afficher tous les objets
        window.location.reload();
    });

    //========================= Gestion du dark mode =======================

    toggleDark.addEventListener('click', () => {

        containerDark.classList.toggle('dark'); // Ajoute ou retire la class dark à la balise <html>
    });

    //========================= Gestion du collapse =======================

    toggleBtn.forEach(btn => {

        btn.addEventListener('click', (e) => {

            e.target.nextElementSibling.classList.toggle('show'); // Ajoute ou retire la class show au conteneur de la réponse

        });
    });

});



