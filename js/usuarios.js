const COLORS_STATE = {

    current_user_id: null,
    colors: []
}

let $colorCheckbox = document.getElementsByTagName("cores");

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
    COLORS_STATE.current_user_id = userId;
    COLORS_STATE.colors = window.USER_COLORS[userId];


    Array.from($colorCheckbox).forEach((x) => x.checked = false);
    Array.from($colorCheckbox).forEach((el) => {

        let id = el.getAttribute('value');
        let hasColor = COLORS_STATE.colors.find((c) => c.id == id);
        if (hasColor) {
            el.checked = true;
        }
    })
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function adicionarCor() {
    let body = {"cores": Array.from($colorCheckbox).filter(x => x.checked).map(x => x.getAttribute('value'))};
    let url = getBaseUrl() + "/usuarios/" + COLORS_STATE.current_user_id;

    fetch(url, {
        method: "PUT",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    }).then(response => {
        if (response.redirected) {
            window.location.replace(response.url);
        }
    }).catch( (e) => {
        console.error("Erro na requisição", e.message)
    } )
    closeModal();
}

window.addEventListener('DOMContentLoaded', () => {
    $colorCheckbox = document.getElementsByName("cores[]");

    let $rmList = document.getElementsByClassName("rm");
    Array.from($rmList).forEach((el) => {
        el.addEventListener("click", (e) => {
            removeRecordEvent(e)
        });
    })

});



