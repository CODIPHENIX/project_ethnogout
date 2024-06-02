document.addEventListener('DOMContentLoaded', function() {
    const newAdminForm = document.getElementById('newAdminForm');
    const errorMessages = {
        field: document.getElementById('fielderror'),
        nom: document.getElementById('nomerror'),
        prenom: document.getElementById('prenomerror'),
        email: document.getElementById('emailerror'),
        pwd: document.getElementById('pwderror'),
        c_pwd: document.getElementById('c_pwderror'),
        general: document.getElementById('generalError')
    };
    const successModal = document.getElementById('successModal');
    const successMessage = document.getElementById('successMessage');
    const closeModal = document.getElementsByClassName('close')[0];
    if(closeModal){
        closeModal.onclick = function() {
            successModal.style.display = "none";
        }
    }

    if (newAdminForm) {
        newAdminForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(newAdminForm);

            fetch('/project_ethnogout/api/user/setadmin.php', {
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
                        successMessage.textContent = data.message;
                        successModal.style.display = "block";

                        setTimeout(() => {
                            window.location.href = 'dashboard.php';
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
