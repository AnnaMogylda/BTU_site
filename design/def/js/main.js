window.onload = function(){
//form validation
    let contactForm = document.getElementById('contact_form');
    let formSuccssess = document.getElementById('formSuccssess');
    let name = document.getElementById('name');
    let surname = document.getElementById('surname');
    let from = document.getElementById('from');
    let to = document.getElementById('to');
    let date = document.getElementById('date');
    let quantityPass = document.getElementById('quantityPass');
    let phoneCode = document.getElementById('phoneCode');
    let phone = document.getElementById('phone');
    let email = document.getElementById('email');
    let btnForm = document.getElementById('btn_form');

    function resetColors(inputArray){
        inputArray.forEach(input => {
            input.style.borderColor = 'rgb(175, 175, 175)';
        })
    }

    function validateData(validData, userData, input){
        if(userData.match(validData)){
            return true;
        } else{
            input.style.borderColor = '#ce2727';
            if(input.id == "phone") {
                phoneCode.style.borderColor = '#ce2727';
            }
            event.preventDefault()
            return false;
        }
    }

    function validateName(name){
        const validName = /[A-Za-zА-Яа-яЁёІіЇїЄє']/;
        const userName = name.value;
        const validationResult = validateData(validName, userName, name);
        return validationResult;
    }

    //surname can be have no value or reg exp
    function validateSurname(surname){
        const validSurname = /[A-Za-zА-Яа-яЁёІіЇїЄє']/;
        const userSurname = surname.value || "no info";
        const validationResult = validateData(validSurname, userSurname, surname);
        return validationResult;
    }

    function validateNumber(phone){
        const validPhone = /^\d{10}$/;      
        let userPhone = phone.value;
        userPhone = userPhone.trim();
        const validationResult = validateData(validPhone, userPhone, phone);    
        return validationResult;
    }

    function validateEmail(email){
        const validEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let userEmail = email.value.toLowerCase();
        userEmail = userEmail.trim();
        console.log(userEmail);
        const validationResult = validateData(validEmail, userEmail, email);
        return validationResult;
    }

    function showNotification(){
        contactForm.style.display = "none";
        formSuccssess.style.display = "block"
    }

    
    btnForm.addEventListener("click", function(){
        //to color to default
        const dataToValidate = [name, surname, phoneCode, phone, email];
        resetColors(dataToValidate);
        //if some any of fields is invalid, not to send form
        const validData = [validateName(name), validateSurname(surname), validateNumber(phone), validateEmail(email)].every(item => item);
        console.log(validData);
        //if data not valid not to send the form
        if(!validData) {
            return
        }
        showNotification(contactForm);
    });    
}
