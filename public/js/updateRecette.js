document.addEventListener('DOMContentLoaded', function() {
    const recetteForm = document.getElementById('formRecette');
    const errorMessages = {
        namerecette: document.getElementById('titreRecetteError'),
        image_recette: document.getElementById('imgError'),
        temp_prepa: document.getElementById('prepaError'),
        tmp_cuisson: document.getElementById('cookError'),
        difficulter: document.getElementById('difError'),
        pays: document.getElementById('paysError'),
        ingredient: document.getElementById('ingredientError'),
        stepDescription: document.getElementById('stepError'),
        general: document.getElementById('generalError')
    };



    const successModal = document.getElementById('successModal');
    const successMessage = document.getElementById('successMessage');
    const closeModal = document.getElementsByClassName('close')[0];

    if (recetteForm) {
        recetteForm.addEventListener('submit', function(event) {
            event.preventDefault();


            const formData = new FormData(recetteForm);

            fetch('/project_ethnogout/api/recette/updateRecette.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {

                    Object.values(errorMessages).forEach(elem => {
                        if (elem) elem.textContent = '';
                    });



                    if (data.error) {
                        for (const key in data.message) {
                            if (data.message.hasOwnProperty(key) && errorMessages[key]) {
                                errorMessages[key].textContent = data.message[key];
                            } else if (errorMessages.general) {
                                errorMessages.general.textContent = data.message[key];
                            }
                        }
                    } else {
                        successMessage.textContent = data.message;
                        successModal.style.display = "block";

                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 1000);
                    }

                })
                .catch(error => {
                    console.error('Erreur lors de la requête :', error);
                    if (errorMessages.general) {
                        errorMessages.general.textContent = 'Une erreur s\'est produite. Veuillez réessayer.';
                    }
                });
        });
    }



});