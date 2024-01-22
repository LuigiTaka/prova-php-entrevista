function getBaseUrl() {
    const protocol = window.location.protocol;
    const host = window.location.host;
    return `${protocol}//${host}`;
}

function removeRecordEvent(e) {

    if (!confirm("Quer deletar o registro do usuário?")) {
        return false;
    }

    const id = e.target.getAttribute("data-id");
    let url = getBaseUrl() + "/usuarios/" + id;
    fetch(url, {
        method: 'DELETE',
        headers: {},
        body: ""
    })
        .then(response => {
            if (response.redirected) {
                window.location.replace(response.url);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error.message);
        });
}

function openModal(userId) {
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function adicionarCor() {
    // Lógica para adicionar a nova cor ao usuário
    // Pode ser feita via AJAX ou manipulando diretamente a DOM
    closeModal();
}

window.addEventListener('DOMContentLoaded', function () {
    let $rmList = document.getElementsByClassName("rm");
    Array.from($rmList).forEach((el) => {
        el.addEventListener("click", (e) => {
            removeRecordEvent(e)
        });
    })

});



