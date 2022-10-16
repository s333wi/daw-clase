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
    (validateEmailAddress(email.value)) ? canRemove(errorEmail) : canAppend(errorEmail);
    (passLength) ? canRemove(errorPassLength) : canAppend(errorPassLength);
    passContainsNumber(password.value) ? canRemove(errorPassNumber) : canAppend(errorPassNumber);
    passHasUpper(password.value) ? canRemove(errorPassUpper) : canAppend(errorPassUpper);
    (password.value === confirmPassword.value) ? canRemove(errorPassMatch) : canAppend(errorPassMatch);

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
function canAppend(error) {
    console.log(error);
    const obj_errors = {
        errorEmail: "L'email no es valid",
        errorPassLength: "La contrasenya ha de ser mes gran de 9 caracters",
        errorPassNumber: "El password ha de contenir minim 1 numero",
        errorPassUpper: "El password ha de contenir minim 2 majuscules",
        errorPassMatch: "Els passwords no coincideixen"
    };
    errorDiv.innerHtml += (value === null) ? "<p class='error' id='" + error + "'>" + obj_errors.error + "</p>" : "";
}
function validateEmailAddress(emailString) {
    console.log({ emailString });
    let atSymbol = emailString.indexOf("@");
    let dot = emailString.indexOf(".");
    if (atSymbol < 1 && dot <= atSymbol + 2 && dot === emailString.length - 1) {
        return false;
    }
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