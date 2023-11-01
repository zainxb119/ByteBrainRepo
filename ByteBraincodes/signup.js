function showError(input, message) {
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');
    input.nextElementSibling.innerHTML = message;
  }
  function showSuccess(input) {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
  }

const emailPattern = /^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*$/,
  onlyCharactersPattern = /^[a-z]+/i,
  emailInvalidFeedback = document.querySelector('#email-input + .invalid-feedback');
  

  document.forms['update_profile']?.addEventListener('submit', validateForm);
  
  function validateForm(e) {
    let form = e.target;
    let errors = true;
    let input;
  
    input = form['firtsname']
    if (input.value.length < 3)
      showError(input, 'First name cannot be shorter than 3 characters')
    else if (input.value.length > 15)
      showError(input, 'First name cannot be longer than 15 characters')
    else if (!input.value.match(onlyCharactersPattern))
      showError(input, 'First name must only contain English alphbetic characters')
    else
      showSuccess(input)
  
    input = form['lastname']
    if (input.value.length < 3)
      showError(input, 'Last name cannot be shorter than 3 characters')
    else if (input.value.length > 15)
      showError(input, 'Last name cannot be longer than 15 characters')
    else if (!input.value.match(onlyCharactersPattern))
      showError(input, 'Last name must only contain English alphbetic characters')
    else
      showSuccess(input)

    input = form['mobilenumber']
    if (!input.value.match(/^((\+?|00)973\s?)?[36][0-9]{7}$/))
      showError(input, 'Invalid phone number')
    else
      showSuccess(input)

    input = form['email'].onchange();
    if (!input.value.match(emailPattern))
        showError(input, 'Invalid email')
    else
        showSuccess(input)  
    
    input = form['birthyear']
    if (!input.value.match(/^(199[5-9]|200[0-3])$/))
        showError(input, 'Invalid birth year')
    else
        showSuccess(input) 
    
  
    if (document.querySelectorAll('input.is-invalid').length !== 0)
      e.preventDefault();
  }

  function checkUniqueEmail(e) {
    if (e.value.length == 0)
      return showError(e, 'Email is required');
  
    if (!e.value.match(emailPattern)) {
      return showError(e, 'Invalid email');
    }
    showSuccess(e);
  
    const r = new XMLHttpRequest();
    r.onload = function () {
      let data = this.responseText;
      if (data == 'y')
        showSuccess(e);
      else
        showError(e, 'Email is already taken');
    };
    r.open('GET', `UniqueEmail.php?q=${e.value}`);
    r.send();
  }

 /* function checkUniqueEmail(e){
    if (e.length==0)
    {document.getElementById("email").innerHTML="";
         return showError(e, 'Email is required');}
    const xhttp= new XMLHttpRequest();
    xhttp.onload= function(){
        document.getElementById("email").innerHTML=this.responseText;
    }
    xhttp.open("GET","UniqueEmail.php?q="+e);
    xhttp.send();
}*/