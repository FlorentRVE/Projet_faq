
document.addEventListener('DOMContentLoaded', function() {

    // ================================ Variables ============================
    
    let category_choice;
    
    let buttons = document.querySelectorAll('.category'); // Récupère tous les boutons de sélection de catégorie
    let questions = document.querySelectorAll('.objet'); // Récupère toutes les blocs questions/réponses

    let infoGen = document.querySelector('.infoGen'); // Récupère le conteneur pour la sous-catégorie infoGen
    let reclam = document.querySelector('.reclam'); // Récupère le conteneur pour la sous-catégorie reclam
    let test = document.querySelector('.test'); // Récupère le conteneur pour la sous-catégorie test

    let buttonReset = document.querySelector('.reset'); // Récupère le boutton pour reset les catégories



    // ================================== Fonctions ====================================

    // =================== Fonctions permettant d'afficher les sous-catégories si il y a au moins un objet de visible =====================
    function toggleContainer(container) {
        let childObjects = container.querySelectorAll('.objet'); // Récupère tous les blocs questions/réponses avec la classe objet correspondant à la sous-catégorie
        let allHidden = true; // Variable 'Tout caché'
      
        childObjects.forEach(div => { // Pour chaque bloc ...
          if (div.style.display !== 'none') { // ... on vérifie si le display est différent de none
            allHidden = false; // si c'est le cas, on passe la variable 'Tout caché' à false, car il y a au moins un élément visible
          }
        });
      
        container.style.display = allHidden ? 'none' : ''; // si tous les blocs sont cachés, on masque le conteneur, sinon on l'affiche
      }

    
    
    
      // ========================== Evènement sélection catégorie ==============================

    buttons.forEach(button => {
        button.addEventListener('click', (e) => { // Pour chaque bouton (City ker, vert, velo), au click ...

            category_choice = e.target.dataset.categorie; // ... on récupère l'attribut data-categorie du bouton et on le stocke dans category_choice

            questions.forEach(item => { // ensuite pour chaque bloc question/réponse ...                
                
                if(item.dataset.categorie !== category_choice) { // ... on vérifie si l'attribut data-categorie du bloc est different de category_choice
                    item.style.display = 'none'; // si c'est le cas, on le masque
                } else {
                    item.style.display = ''; // sinon on le montre
                }
                
            })


            toggleContainer(infoGen);
            toggleContainer(reclam);
            toggleContainer(test);

                        
        });
    });
    
    // ============= Boutton reset pour recharger la page ================

    buttonReset.addEventListener('click', () => { // Reload la page pour re afficher tous les objets
        window.location.reload();
    });

});



