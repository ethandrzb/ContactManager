document.querySelector('#add')
.addEventListener('click', function(){
    const name = document.querySelector('#name');
    const email = document.querySelector('#email');
    const phone = document.querySelector('#phone');
    addContact(name.value, email.value, phone.value);
});
function addContact(name, email, phone) {
    const contactDiv = document.createElement('div');
    contactDiv.className ="contact-entry";

    const nameDiv = document.createElement('div');
    nameDiv.className = 'name';
    nameDiv.textContent = name;

    const emailDiv = document.createElement('div');
    emailDiv.className = 'email';
    emailDiv.textContent = email;

    const phoneDiv = document.createElement('div');
    phoneDiv.className = 'phone';
    phoneDiv.textContent = phone;

    contactDiv.adppend(nameDiv);
    contactDiv.append(emailDiv);
    contactDiv.append(phoneDiv);
    document.querySelector('#contacts-list').append(contactDiv);
}