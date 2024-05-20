document.addEventListener('DOMContentLoaded', function() {
    const signupForm = document.getElementById('signupForm');
    const errorMessages = {
        field: document.getElementById('fielderror'),
        nom: document.getElementById('nomerror'),
        prenom: document.getElementById('prenomer>WXC><ror'),
        email: document.getElementById('emailerror'),
        pwd: document.getElementById('pwderror'),
        c_pwd: document.getElementById('c_pwderror'),
        termsCheckbox: document.getElementById('GCUerror'),
        general: document.getElementById('generalError')
    };
    const successModal = document.getElementById('successModal');
    const successMessage = document.getElementById('successMessage');
    const closeModal = document.getElementsByClassName('close')[0];

    if (signupForm) {
        signupForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(signupForm);

            fetch('/project_ethnogout/api/user/apiuser.php', {
                method: 'POST',
                body: formData
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
                        successMessage.textContent = data.message; // Afficher le message de succès
                        successModal.style.display = "block"; // Afficher la modal

                        setTimeout(() => {
                            window.location.href = 'login.php'; // Redirection vers la page d'accueil
                        }, 2000);
                    }

                })
                .catch(error => {
                    console.error('Erreur lors de la requête :', error);
                    if (errorMessages.general) {
                        errorMessages.general.textContent = 'Une erreur s\'est produite. Veuillez réessayer.';
                    }
                });
        });
    } else {
        console.error('Le formulaire d\'inscription n\'a pas été trouvé.');
    }
});
