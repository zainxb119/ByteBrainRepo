const firstName = document.querySelector('#firstName')
const lastName = document.querySelector('#lastName')
const email = document.querySelector('#email')
const uname = document.querySelector('#uname')
const byear = document.querySelector('#byear')
const password = document.querySelector('#password')
const confirmPassword = document.querySelector('#confirmPassword')
const form = document.querySelector('form')







function showError(input, msg) {
    input.setAttribute("style", "color: red");
    const p = input.nextElementSibling
    p.innerText = msg
}





function showSuccess(input) {
    input.setAttribute("style", "color: lightgreen");
    const small = input.nextElementSibling
    p.innerText = ""
}

function checkNames(input) {
    let wrongInput = 0;
    const pattern = /^[a-zA-Z]{3,30}$/
    if (pattern.test(input.value.trim())) {
        showSuccess(input)
    } else {
        showError(input, "Invalid Name Input (3-30 characters)")
        wrongInput++
    }
    return wrongInput
}

function checkUname(input) {
    let wrongInput = 0;
    const pattern = /^[a-zA-Z0-9_.-]{4,25}$/
    if (pattern.test(input.value.trim())) {
        showSuccess(input)
    } else {
        showError(input, "username should contain alphabets,numbers and _.- only")
        wrongInput++
    }
    return wrongInput
}


function checkEmail(input) {
    let wrongInput = 0;
    const pattern = /^([a-zA-Z][\w\_\.]{6,15})\@([a-zA-Z0-9.-]+)\.([a-zA-Z]{2,4})$/
    if (pattern.test(input.value.trim())) {
        showSuccess(input)
    } else {
        showError(input, "Invalid Email Input")
        wrongInput++
    }

    return wrongInput
}




function checkPassword(input) {
    let wrongInput = 0;
    const pattern = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9_#@%\*\-]{8,24}$/
    if (pattern.test(input.value.trim())) {
        showSuccess(input)
    } else {
        showError(input, "Invalid Password Input")
        wrongInput++
    }

    return wrongInput
}




function checkByear(input) {
    let wrongInput = 0;
    const pattern = /^19[5-9]\d|200[0-5]$/
    if (pattern.test(input.value.trim())) {
        showSuccess(input)
    } else {
        showError(input, "Choose a year between 1950 and 2005")
        wrongInput++
    }

    return wrongInput
}



function samePasswords(passwordOne, passwordTwo) {
    if (passwordOne.value !== passwordTwo.value) {
        showError(passwordTwo, "Passwords do not Match")
        return 1;
    } else if (passwordOne.value === passwordTwo.value) {
        showSuccess(passwordTwo);
        return 0;
    }

}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    let count = 0;
    count += checkNames(firstName)
    count += checkNames(lastName)
    count += checkUname(uname)    
    count += checkEmail(email)
    count += checkByear(byear)
    count += checkPassword(password)
    count += samePasswords(password, confirmPassword)

    console.log(count)
    if (count == 0) {
        form.submit()
    }
})
