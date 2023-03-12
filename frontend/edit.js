const editForm = document.getElementById("edit");
const editButton = document.getElementById("edit-submit");
const id = new URLSearchParams(window.location.search).get('cid');

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
    editForm.firstname.value = contact[0][0];
    editForm.lastname.value = contact[0][1];
    editForm.email.value = contact[0][3];
    editForm.phone.value = contact[0][2];
    editForm.date.value = "Date Added: " + contact[0][4];
})

//this will actually update the contact
editForm.addEventListener("submit", (event) => {
    const firstname = editForm.firstname.value;
    const lastname = editForm.lastname.value;
    const email = editForm.email.value;
    const phone = editForm.phone.value;
    //function for getting the id;
    const id = new URLSearchParams(window.location.search).get('cid');
  
    var raw = "{\r\n    \"contactID\" :\"" + id + "\",\r\n    \"firstName\" : \"" + firstname + "\",\r\n    \"lastName\" : \"" + lastname + "\",\r\n    \"email\" : \"" + email + "\",\r\n    \"phone\" : \"" + phone + "\"\r\n}";
    
    var requestOptions = {
        method: 'POST',
        body: raw,
        redirect: 'follow'
      };

    fetch("https://cop4331-2023.xyz/resource/editContact.php", requestOptions)
      .then(response => response.text())
      .then(response => {
            window.location.href = "/details.html?cid=" + id
      })
    event.preventDefault();
  })