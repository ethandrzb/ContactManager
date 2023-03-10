
function User(firstName, lastName, email, phone, date){
    this.firstName = firstName;
    this.lastName = lastName;
    this.email = email;
    this.phone = phone;
    this.date = date;
} 

function getResults() {
    var searchQuery = document.getElementById('searchbar').value;

    var raw = "{\r\n    \"searchQuery\" : \"" + searchQuery + "\",\r\n    \"page\": 1,\r\n    \"resultsPerPage\": \"25\"\r\n}";

    var requestOptions = {
    method: 'POST',
    body: raw,
    redirect: 'follow'
    };

    fetch("https://cop4331-2023.xyz/resource/searchContact.php", requestOptions)
    .then(response => response.text())
    .then(result => console.log(result))
    .catch(error => console.log('error', error));

}

var users;
// for(var i = 1; i < users.length; i++)
// {
//     cloneCard(users[i]);
// }

if (document.getElementById('add-contact')) {
    document.getElementById('add-contact').addEventListener('click', 
    function(){
        const firstName = document.querySelector('#firstName');
        const lastName = document.querySelector('#lastName');
        const email = document.querySelector('#email');
        const phone = document.querySelector('#phone');
        addContact(firstName.value, lastName.value, email.value, phone.value);
    });
}

function cloneCard(user){ 
    var cardContents = document.getElementById('contact-details').innerHTML;
    var clone = document.createElement("input");
    clone.type = "preview";
    clone.value = user.firstName + " " + user.lastName;
    clone.innerHTML = cardContents;
    clone.hidden = false;
    document.getElementById('contactcard').append(clone);
}

function addContact(name, email, phone) {
    const contactDiv = document.createElement('div');
    contactDiv.className ="contact-entry";

    const firstNameDiv = document.createElement('div');
    firstNameDiv.className = 'firstName';
    firstNameDiv.textContent = firstName;
    
    const lastNameDiv = document.createElement('div');
    lastNameDiv.className = 'lastName';
    lastNameDiv.textContent = lastName;

    const emailDiv = document.createElement('div');
    emailDiv.className = 'email';
    emailDiv.textContent = email;

    const phoneDiv = document.createElement('div');
    phoneDiv.className = 'phone';
    phoneDiv.textContent = phone;

    contactDiv.append(firstNameDiv);
    contactDiv.append(lastNameDiv);
    contactDiv.append(emailDiv);
    contactDiv.append(phoneDiv);

    users.push(firstName, lastName, email, phone, '03/12/23');

}