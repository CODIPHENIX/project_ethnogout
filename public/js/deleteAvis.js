async function deleteAvis(idRecette, idUser) {


    if (confirm('Voulez-vous vraiment supprimer cet avis ?')) {

        try {
            const response = await fetch(`/project_ethnogout/api/avis/deleteAvis.php`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({idRecette,idUser})
            });

            const result = await response.json();
            if (result.error) {
                alert(`Erreur : ${result.message}`);
            } else {
                alert(result.message);
                document.getElementById(`avis-${idRecette}-${idUser}`).remove();
            }
        } catch (error) {
            console.error('Erreur lors de la requête :', error);
            alert('Une erreur s\'est produite. Veuillez réessayer.');
        }
    }
}

