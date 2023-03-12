const id = new URLSearchParams(window.location.search).get('cid');

const detailsForm = document.getElementById("detailsForm");

var raw = "{\r\n    \"contactID\" : \"" + id + "\"\r\n}";

var requestOptions = {
    method: 'POST',
    body: raw,
    redirect: 'follow'
    };

fetch("https://cop4331-2023.xyz/resource/getContact.php", requestOptions)
    .then(response => response.text())
    .then(response => {
        //response may be diff too
        let contact = JSON.parse(response);
        document.getElementById('first').innerHTML = contact[0][0];
        document.getElementById('last').innerHTML = contact[0][1];
        document.getElementById('email').innerHTML = contact[0][2];
        document.getElementById('phone').innerHTML = contact[0][3];
        document.getElementById('date').innerHTML = "Added on: " + contact[0][4];
    })

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