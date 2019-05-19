function validateForm() {
    var noValidation = document.getElementById("#altaVoluntario").novalidate;
    
    if (!noValidation){
        var error1 = passwordValidation();
        
        var error2 = passwordConfirmation();
        
        return (error1.length==0) && (error2.length==0);
    }
    else 
        return true;
}
function passwordConfirmation(){
    var pwd = document.getElementById("pass").value;
    var confirmation = document.getElementById("confirmpass").value;
    if (pwd != confirmation) {
        var error = "Las contraseñas introducidas no son iguales";
    }else{
        var error = "";
    }
    passconfirm.setCustomValidity(error);
    return error;
}

function passwordValidation(){
    var password = document.getElementById("pass");
    var pwd = password.value;
    var valid = true;

    valid = valid && (pwd.length>=5);
    
    var hasNumber = /\d/;
    var hasUpperCases = /[A-Z]/;
    valid = valid && (hasNumber.test(pwd)) && (hasUpperCases.test(pwd));
    
    if(!valid){
        var error = "Introduzca una contraseña válida";
    }else{
        var error = "";
    }
        password.setCustomValidity(error);
    return error;
}
