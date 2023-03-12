const id = new URLSearchParams(window.location.search).get('cid');

const detailsForm = document.getElementById("detailsForm");

detailsForm.addEventListener("submit", (event) => { 

    var raw = "{\r\n    \"contactID\" : \"" + id + "\"\r\n}";

    var requestOptions = {
        method: 'POST',
        body: raw,
        redirect: 'follow'
      };

    window.location.href = "/edit.html?cid=" + id;
    event.preventDefault();

    fetch("https://cop4331-2023.xyz/resource/getContact.php", requestOptions)
    .then(response => response.text())
    .then(response => {
        //response may be diff too
        let contact = JSON.parse(response);
        document.getElementById('first').innerHTML = contact.firstname;
        document.getElementById('last').innerHTML = contact.lastname;
        document.getElementById('email').innerHTML = contact.email;
        document.getElementById('phone').innerHTML = contact.phone;
        document.getElementById('date').innerHTML = contact.dateCreated;
    })
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