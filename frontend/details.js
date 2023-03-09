const id = new URLSearchParams(window.location.search).get('cid');

const detailsForm = document.getElementById("detailsForm");

detailsForm.addEventListener("submit", (event) => { 
    window.location.href = "/edit.html?cid=" + id;
    event.preventDefault();
})
