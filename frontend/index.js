const loginForm = document.getElementById("login");
const registerForm = document.getElementById("signup");
const loginButton = document.getElementById("login-submit");
const registerButton = document.getElementById("register-submit");

loginForm.addEventListener("submit", (event) => {
    const loginUsername = loginForm.loginUsername.value;
    const loginPassword = loginForm.loginPassword.value;

    //Login User
    var raw = "{\r\n    \"username\" : \"" + loginUsername + "\",\r\n    \"password\" : \"" + loginPassword + "\"\r\n}";

    var requestOptions = {
    method: 'POST',
    body: raw,
    redirect: 'follow'
    };

    fetch("http://cop4331-2023.xyz/resource/login.php", requestOptions)
    .then(response => {
        if (response.ok) {
            //display a success message
            document.getElementById("login-success").hidden = false;
            // Redirect to contacts page
            console.log("this code is running");
            window.location.href = window.location.href + "/contacts.html";
        } else {
            document.getElementById("login-error").hidden = false;
        }
        // return response.text();
    })
    // .then(result => {
    //     // Redirect to contacts page
    //     console.log("this code is running");
    //     window.location.href = window.location.href + "/contacts.html";
    // })
    .catch(error => {
        document.getElementById("login-error").hidden = false;
    });

    event.preventDefault();
})


registerForm.addEventListener("submit", (event) => {
    const registerUsername = registerForm.registerUsername.value;
    const registerPassword = registerForm.registerPassword.value;
    const confirmPassword = registerForm.confirmPassword.value;

    //check if passwords are the same
    if(registerForm.registerPassword.value != registerForm.confirmPassword.value)
    {
        event.preventDefault();
        document.getElementById("register-error").hidden = false;
        return;
    }
    //if not show an error

    //Register User
    var raw = "{\r\n    \"username\" : \"" + registerUsername + "\",\r\n    \"password\" : \"" + registerPassword + "\"\r\n}";

    var requestOptions = {
    method: 'POST',
    body: raw,
    redirect: 'follow'
    };

    fetch("http://cop4331-2023.xyz/resource/register.php", requestOptions)
    .then(response => {
        if (response.ok) {
            document.getElementById("register-success").hidden = false;
            // Display a message saying the account creation succeeded
        } else {
            document.getElementById("failed-error").hidden = false;
        }

        // return response.text();
    })
    // .then(result => console.log(result))
    .catch(error => {
        document.getElementById("failed-error").hidden = false;
    });

    event.preventDefault();
})


