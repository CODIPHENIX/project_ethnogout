document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('updateUser');
    const errorMessages = {
        field: document.getElementById('fielderror'),
        nom: document.getElementById('nomerror'),
        prenom: document.getElementById('prenomerror'),
        email: document.getElementById('emailerror'),
        pwd: document.getElementById('pwderror'),
        c_Npwd: document.getElementById('c_Npwderror'),
        general: document.getElementById('generalError')
    };
    const successModal = document.getElementById('successModal');
    const successMessage = document.getElementById('successMessage');
    const closeModal = document.getElementsByClassName('close')[0];

    if (updateForm) {
        updateForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(updateForm);

            fetch('/project_ethnogout/api/user/updateuser.php', {
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
    } else {
        console.error('Le formulaire d\'inscription n\'a pas été trouvé.');
    }
});
