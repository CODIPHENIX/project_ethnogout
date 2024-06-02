document.addEventListener('DOMContentLoaded', () => {
    const avisUsers = document.querySelectorAll('.avis_usrs');

    avisUsers.forEach((avisUser) => {
        const modifcmtbutton = avisUser.querySelector("button.iconcomment");
        const btnModif = avisUser.querySelector('.modifCmt');
        const avisSection = avisUser.querySelector('.avisUser');
        const modifForm = avisUser.querySelector('.modifForm');
        const stars = avisUser.querySelectorAll('.modifForm .star');
        const annuler = avisUser.querySelector('.annuler');
        const modifsection = avisUser.querySelector('.actionCmtbtn');
        const modificon = avisUser.querySelector(".iconcomment i");

        const togglemodifcomment = () => {
            if (modifsection && modificon) {
                modifsection.classList.toggle('show');
                const isShow = modifsection.classList.contains('show');
                modificon.className = isShow ? 'fa-solid fa-xmark' : 'fa-solid fa-ellipsis';
            }
        };

        if (modifcmtbutton) {
            modifcmtbutton.addEventListener('click', (e) => {
                e.stopPropagation();
                togglemodifcomment();
            });

            btnModif.addEventListener('click', (e) => {
                e.stopPropagation();
                avisSection.style.display = "none";
                modifForm.style.display = "block";
            });

            annuler.addEventListener('click', (e) => {
                e.stopPropagation();
                location.reload();
            });

            document.addEventListener('click', (e) => {
                if (!modifsection.contains(e.target)) {
                    modifsection.classList.remove('show');
                    modificon.className = 'fa-solid fa-ellipsis';
                }
            });

            stars.forEach((star) => {
                star.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const selectedRating = star.getAttribute('data-value');
                    document.getElementById('ratingmod-' + selectedRating).checked = true;
                    stars.forEach(s => s.classList.remove('checked'));
                    star.classList.add('checked');
                    let prevSibling = star.previousElementSibling;
                    while (prevSibling) {
                        prevSibling.classList.add('checked');
                        prevSibling = prevSibling.previousElementSibling;
                    }
                });
            });
        }
    });

    const modifAvisForm = document.getElementById('test');
    const errorMessages = {
        comment: document.getElementById('comment2Error'),
        general: document.getElementById('ratingGeneral2Error')
    };
    const successModal = document.getElementById('successModal');
    const successMessage = document.getElementById('successMessage');
    const closeModal = document.getElementsByClassName('close')[0];


    if (closeModal) {
        closeModal.onclick = function() {
            successModal.style.display = "none";
        };
    }

    if (modifAvisForm) {
        modifAvisForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(modifAvisForm);

            try {
                const response = await fetch('/project_ethnogout/api/avis/updateAvis.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

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
                        successModal.style.display = "none";
                        location.reload();
                    }, 2000);
                }

            } catch (error) {
                console.error('Erreur lors de la requête :', error);
                if (errorMessages.general) {
                    errorMessages.general.textContent = 'Une erreur s\'est produite. Veuillez réessayer.';
                }
            }
        });
    } else {
        console.error('Le formulaire .');
    }
});
