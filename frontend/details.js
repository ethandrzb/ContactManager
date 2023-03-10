const id = new URLSearchParams(window.location.search).get('cid');

const detailsForm = document.getElementById("detailsForm");

detailsForm.addEventListener("submit", (event) => { 
    window.location.href = "/edit.html?cid=" + id;
    event.preventDefault();
})

function deleteUser() {
    var raw = "{\r\n    \"contactID\" : " + id + "\r\n}";

    var requestOptions = {
        method: 'POST',
        body: raw,
        redirect: 'follow'
    };

    fetch("https://cop4331-2023.xyz/resource/deleteContact.php", requestOptions)
    .then(response => response.text())
    .then(result => window.location.href = "/contacts.html")
    .catch(error => console.log('error', error));    
}