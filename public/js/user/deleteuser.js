async function deleteuser(id) {
    const deleteModal = document.getElementById('deleteModal');
    const closeModal = document.getElementsByClassName('close')[0];
    const deleteButton = document.getElementById('delete_btn');

    deleteModal.style.display = "block";

    closeModal.onclick = function() {
        deleteModal.style.display = "none";
    }


    window.onclick = function(event) {
        if (event.target === deleteModal) {
            deleteModal.style.display = "none";
        }
    }


    $(deleteButton).on('click', async function() {
        const response = await fetch(`/project_ethnogout/api/user/deleteuser.php?id=${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();
        if (result.error) {
            alert(`Error: ${result.message}`);
        } else {
            alert(result.message);
            deleteModal.style.display = "none";
            document.getElementById(`user-${id}`).remove();


        }
    });
}