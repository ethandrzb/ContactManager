const editForm = document.getElementById("edit");
const editButton = document.getElementById("edit-submit");

//this will populate form placeholders
//var contact = new contact();
const currentFirst = document.querySelector('.first');
const currentLast = document.querySelector('.last');
const currentEmail = document.querySelector('.email');
const currentPhone = document.querySelector('.phone');
const currentDate = document.querySelector('.date');
/*
function printContact(){
    //var contact = new contact();
    //figure out how to fetch this data
    //var first = ;
    //var last = ;
    //var email = ;
    //var phone = ;
    //var date = ;
    currentFirst.innerHTML = first;
    currentLast.innerHTML = last;
    currentEmail.innerHTML = email;
    currentPhone.innerHTML = phone;
    currentDate.innerHMTL = date;
}
//printContact();
*/

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
            window.location.href = "/details.html"
      })
    event.preventDefault();
  })

