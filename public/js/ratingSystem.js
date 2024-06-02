export const ratingSystem=()=>{
    const ratingForm=document.getElementById('commentForm')
    const stars = document.querySelectorAll('#commentForm .star');
    const errorMessages ={
      comment: document.getElementById('commentError'),
        general: document.getElementById('ratingGeneralError')
    }
    if(stars){
        stars.forEach(star => {
            star.addEventListener('click', function() {
            const selectedRating = this.getAttribute('data-value');
                document.getElementById('rating-' + selectedRating).checked = true;
                stars.forEach(s => s.classList.remove('checked'));
                this.classList.add('checked');
                let prevSibling = this.previousElementSibling;
                while (prevSibling) {
                    prevSibling.classList.add('checked');
                    prevSibling = prevSibling.previousElementSibling;
                }
            });
        });
    }
    const successModal = document.getElementById('successModal');
    const successMessage = document.getElementById('successMessage');
    const closeModal = document.getElementsByClassName('close')[0];
    const textvide=document.getElementById('comment')
    if(closeModal){
        closeModal.onclick = function() {
            successModal.style.display = "none";
        }
    }

    if (ratingForm) {
        ratingForm.addEventListener('submit', function(event) {
            event.preventDefault();


            const formData = new FormData(ratingForm);

            fetch('/project_ethnogout/api/avis/addAvis.php', {
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
                        textvide.value = '';
                        stars.forEach(s => s.classList.remove('checked'));
                        setTimeout(() => {
                            successModal.style.display = "none";
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

}