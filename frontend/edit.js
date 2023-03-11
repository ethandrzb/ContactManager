const editForm = document.getElementById("edit");
const editButton = document.getElementById("edit-submit");

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
    
    fetch("https://cop4331-2023.xyz/resource/getContact.php", requestOptions)
    .then(response => response.text())
    .then(response => {
        //response may be diff too
        let contact = JSON.parse(response);
        editForm.firstname.value = contact.firstname;
        editForm.lastname.value = contact.lastname;
        editForm.email.value = contact.email;
        editForm.phone.value = contact.phone;
    })
    

    fetch("https://cop4331-2023.xyz/resource/editContact.php", requestOptions)
      .then(response => response.text())
      .then(response => {
            window.location.href = "/details.html"
      })
    event.preventDefault();
  })