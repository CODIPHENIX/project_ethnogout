document.addEventListener('DOMContentLoaded', () => {
    const favIcons = document.querySelectorAll('.icon_fav');

    favIcons.forEach(icon => {
        icon.addEventListener('click', async function () {
            const iduser = this.getAttribute('data-iduser');
            const idrecette = this.getAttribute('data-idrecette');
            const isFavorite = this.classList.contains('favorite');

            const formData = new FormData();
            formData.append('iduser', iduser);
            formData.append('idrecette', idrecette);

            const response = await fetch('/project_ethnogout/api/favoris/istogglefav.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            if (result.error) {
                alert(`Erreur : ${result.message}`);
            } else {

                const icon = document.querySelector('.icon_fav i');
                if (result.action === 'added') {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                } else if (result.action === 'removed') {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                }
            }
        });
    });
});
