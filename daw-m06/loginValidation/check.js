var errorDiv;

function formValidation() {
    window.event.preventDefault();
    let divChecker = document.getElementById("inpCheck");
    console.log(divChecker);
    let email = document.querySelector('#formEmail');
    let password = document.getElementById("formPass");
    let confirmPassword = document.getElementById("formPassConfirm");
    let passLength = password.value.length >= 9;
    let errorEmail = document.getElementById("errorEmail");
    let errorPassLength = document.getElementById("errorPassLength");
    let errorPassNumber = document.getElementById("errorPassNumber");
    let errorPassUpper = document.getElementById("errorPassUpper");
    let errorPassMatch = document.getElementById("errorPassMatch");
    errorDiv = document.getElementById("inpCheck");
    let pError = document.createElement("p");
    (validateEmailAddress(email.value)) ? canRemove(errorEmail) : canAppend('errorEmail', errorEmail);
    (passLength) ? canRemove(errorPassLength) : canAppend('errorPassLength', errorPassLength);
    passContainsNumber(password.value) ? canRemove(errorPassNumber) : canAppend('errorPassNumber', errorPassNumber);
    passHasUpper(password.value) ? canRemove(errorPassUpper) : canAppend('errorPassUpper', errorPassUpper);
    (password.value === confirmPassword.value) ? canRemove(errorPassMatch) : canAppend('errorPassMatch', errorPassMatch);

    let errorElements = document.querySelectorAll('p.error');
    if (errorElements.length === 0) {
        document.forms['loginForm'].submit();
    }

}
function canRemove(child) {

    if (child !== null) {
        errorDiv.removeChild(child);
    }
}
function canAppend(error, value) {
    switch (error) {
        case 'errorEmail':
            errorDiv.innerHTML += (value === null) ? "<p class='error' id='errorEmail'>L'email no es valid</p>" : "";
            break;
        case 'errorPassLength':
            errorDiv.innerHTML += (value === null) ? "<p class= 'error' id='errorPassLength'>La contrasenya ha de ser mes gran de 9 caracters</p>" : "";
            break;
        case 'errorPassNumber':
            errorDiv.innerHTML += (value === null) ? "<p class='error' id='errorPassNumber'>El password ha de contenir minim 1 numero</p>" : "";
            break;
        case 'errorPassUpper':
            errorDiv.innerHTML += (value === null) ? "<p class='error' id='errorPassUpper'>El password ha de contenir minim 2 majuscules</p>" : "";
            break;
        case 'errorPassMatch':
            errorDiv.innerHTML += (value === null) ? "<p class='error' id='errorPassMatch'>Els passwords no coincideixen</p>" : undefined;
            break;
        default:
            break;
    }
}
function validateEmailAddress(emailString) {
    console.log({ emailString });
    let atSymbol = emailString.indexOf("@");
    if (atSymbol < 1)
        return false;

    let dot = emailString.indexOf(".");
    if (dot <= atSymbol + 2)
        return false;

    // check that the dot is not at the end
    if (dot === emailString.length - 1)
        return false;

    return true;
}

function passContainsNumber(password) {
    for (let i = 0; i < password.length; i++) {
        if (!isNaN(password.charAt(i)) && !(password.charAt(i) === " ")) {
            return true;
        }
    }
    return false;
}

function passHasUpper(password) {
    let atLeastTwoUpper = 0;
    for (var i = 0; i < password.length; i++) {
        if (isNaN(password.charAt(i)) && password.charAt(i) === password.charAt(i).toUpperCase()) {
            atLeastTwoUpper++;
            if (atLeastTwoUpper >= 2) return true;
        }
    }
    return false;
};