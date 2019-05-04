/*function validarCalle() {
    var direccion = document.getElementById("#direccion");
    var res = false;
    fetch('/ficheros/callejero.txt')
    .then(res => res.text())
    .then(content => {
      let lines = content.split(/\n/);
      lines.forEach(function(){
        if(line == direccion){
            res==true;
        }else{
            error="error";
            direccion.setCustomValidity(error);
        }
      });
      var resultado = lines.filter(line => line == direccion).find;
    });
    return res;
};

function validateForm() {
  var noValidation = document.getElementById("#altaUsuario").novalidate;
  
  if (!noValidation){

    var error1 = blankValidation();
        
    return (error1.length==0);
  }
  else 
    return true;
}
*/
function validateDate(){
  var form = document.getElementById("#AltaUsuario");
  var fechaNac = document.forms["altaUsuario"]["fechaNac"].value;
  var solicitante = document.forms["altaUsuario"]["solicitante"].value;
  var array = fechaNac.split("-");
  var day = array[2];
  var month = array[1];
  var year =array[0];
  var age = 18;
  var mydate = new Date();
  mydate.setFullYear(year, month-1, day);
  var currdate = new Date();
  currdate.setFullYear(currdate.getFullYear() - age);
  if ((currdate - mydate) < 0 && solicitante =="Sí" ){
    alert("El solicitante debe ser mayor de edad");
  }

}
function blankValidation(){
  var form = document.getElementById("#AltaUsuario");
  var celda = document.getElementsByClassName("celda");
  var nombre = document.forms["altaUsuario"]["nombre"].value;
  var apellidos = document.forms["altaUsuario"]["apellidos"].value;
  var dni = document.forms["altaUsuario"]["dni"].value;
  var fechaNac = document.forms["altaUsuario"]["fechaNac"].value;
  var genero = document.forms["altaUsuario"]["genero"].value;
  var telefono = document.forms["altaUsuario"]["telefono"].value;
  var estudios = document.forms["altaUsuario"]["estudios"].value;
  var sitlaboral = document.forms["altaUsuario"]["sitlaboral"].value;
  var ingresos = document.forms["altaUsuario"]["ingresos"].value;
  var minusvalia = document.forms["altaUsuario"]["minusvalia"].value;
  var solicitante = document.forms["altaUsuario"]["solicitante"].value;
  var gastosfamilia = document.forms["altaUsuario"]["gastosfamilia"].value;
  var poblacion = document.forms["altaUsuario"]["poblacion"].value;
  var domicilio = document.forms["altaUsuario"]["domicilio"].value;
  var codigopostal = document.forms["altaUsuario"]["cosigopostal"].value;
  var protecciondatos = document.forms["altaUsuario"]["proteccionDatos"].value;
  var dnisol = document.forms["altaUsuario"]["dniSol"].value;
  var parentesco = document.forms["altaUsuario"]["parentesco"].value;

  var error = "";
  if (nombre == ""){
    var error = "El nombre no puede estar vacío";
  }
  if (apellidos == ""){
    var error = "Los apellidos no pueden estar vacío";
  }
  if (dni == ""){
    var error = "El dni no puede estar vacío";
  }
  if (fechaNac == ""){
    var error = "La fecha de nacimiento no puede estar vacío";
  }
  if (genero == ""){
    var error = "El genero no puede estar vacío";
  }
  if (telefono == ""){
    var error = "El telefono no puede estar vacío";
  }
  if (estudios == ""){
    var error = "Los estudios no puede estar vacío";
  }
  if (sitlaboral == ""){
    var error = "la situación laboral no puede estar vacía";
  }
  if (ingresos == ""){
    var error = "Los ingresos no pueden estar vacío";
  }
  if (minusvalia == ""){
    var error = "El campo de minusvalia no puede estar vacío";
  }
  if (solicitante == ""){
    var error = "El campo de solicitante no puede estar vacío";
  }
if(solicitante =="Sí"){
    if (gastosfamilia == ""){
      var error = "Los gastos familiares no pueden estar vacío";
    }
    if (poblacion == ""){
     var error = "La poblacion no puede estar vacía";
    }
    if (domicilio == ""){
      var error = "El domicilio no puede estar vacío";
    }
    if (codigopostal == ""){
      var error = "El codigopostal no puede estar vacío";
    }
    if (protecciondatos == ""){
      var error = "El protecciondatos no puede estar vacío";
    }
}else{

  if (dnisol == ""){
    var error = "El dni del solicitante no puede estar vacío";
  }
  if (parentesco == ""){
    var error = "El parentesco no puede estar vacío";
  }
}
celda.setCustomValidity(error);
return error;
}