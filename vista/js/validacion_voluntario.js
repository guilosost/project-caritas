function validateForm() {
    var noValidation = document.getElementById("#altaVoluntario").novalidate;
    
    if (!noValidation){
        // Comprobar que la longitud de la contraseña es >=8, que contiene letras mayúsculas y minúsculas y números
        var error1 = passwordValidation();
        
        var error2 = passwordConfirmation();
        
        return (error1.length==0) && (error2.length==0);
    }
    else 
        return true;
}
function passwordConfirmation(){
    // Obtenemos el campo de password y su valor
    var password = document.getElementById("pass");
    var pwd = password.value;
    // Obtenemos el campo de confirmación de password y su valor
    var passconfirm = document.getElementById("confirmpass");
    var confirmation = passconfirm.value;

    // Los comparamos
    if (pwd != confirmation) {
        var error = "Las contraseñas introducidas no son iguales";
    }else{
        var error = "";
    }

    passconfirm.setCustomValidity(error);

    return error;
}
function passwordStrength(password){
    // Creamos un Map donde almacenar las ocurrencias de cada carácter
    var letters = {};

    // Recorremos la contraseña carácter por carácter
    var length = password.length;
    for(x = 0, length; x < length; x++) {
        // Consultamos el carácter en la posición x
        var l = password.charAt(x);

        // Si NO existe en el Map, inicializamos su contador a uno
        // Si ya existía, incrementamos el contador en uno
        letters[l] = (isNaN(letters[l])? 1 : letters[l] + 1);
    }

    // Devolvemos el cociente entre el número de caracteres únicos (las claves del Map)
// y la longitud de la contraseña
    return Object.keys(letters).length / length;
}

function passwordValidation(){
    var password = document.getElementById("pass");
    var pwd = password.value;
    var valid = true;

    // Comprobamos la longitud de la contraseña
    valid = valid && (pwd.length>=8);
    
    // Comprobamos si contiene letras mayúsculas, minúsculas y números
    var hasNumber = /\d/;
    var hasUpperCases = /[A-Z]/;
    var hasLowerCases = /[a-z]/;
    valid = valid && (hasNumber.test(pwd)) && (hasUpperCases.test(pwd)) && (hasLowerCases.test(pwd));
    
    // Si no cumple las restricciones, devolvemos un error
    if(!valid){
        var error = "Please enter a valid password! Length >= 8, (upper and lower case) letters and digits";
    }else{
        var error = "";
    }
        password.setCustomValidity(error);
    return error;
}
// EJERCICIO 4: Coloreado del campo de contraseña según su fortaleza
function passwordColor(){
var passField = document.getElementById("pass");
var strength = passwordStrength(passField.value);

if(!isNaN(strength)){
    passField.css("background-color",red);
    var type = "weakpass";
    if(passwordValidation()!=""){
        $("#pass").css("background-color",orange);   
        type = "weakpass";
    }else if(strength > 0.7){
        $("#pass").css("background-color",red);
        type = "strongpass";
    }else if(strength > 0.4){
        $("#pass").css("background-color",yellow);
        type = "middlepass";
    }
}else{
    passField.css("background-color",red);
    type = "nanpass";
}
passField.className = type;

return type;
}
