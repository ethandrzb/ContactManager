var date = new Date();
const todayDate = document.querySelector('.date');

function printDate(){
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth()+1;
    var year = date.getFullYear();
    todayDate.innerHTML = "Added on: " + month + "/" + day + "/" + year;
}
printDate();

const addForm = document.getElementById("add");
const addButton = document.getElementById("add-submit");

addForm.addEventListener("submit", (event) => {
  const firstname = addForm.firstname.value;
  const lastname = addForm.lastname.value;
  const email = addForm.email.value;
  const phone = addForm.phone.value;

  var raw = "{\r\n    \"firstName\" : \"" + firstname + "\",\r\n    \"lastName\" : \" "+ lastname + "\",\r\n    \"email\" : \""+ email + "\",\r\n    \"phone\" : \""+ phone +"\"\r\n}";

    var requestOptions = {
    method: 'POST',
    body: raw,
    redirect: 'follow'
    };

    fetch("https://cop4331-2023.xyz/resource/addContact.php", requestOptions)
    .then(response => response.text())
    .then(response => {
        window.location.href = "/contacts.html"
    })
    event.preventDefault();
})
