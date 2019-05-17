
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

function letrasYEspacio(){
  var nombre = document.forms["altaUsuario"]["nombre"].value;
  alert(nombre);
  if(nombre.match("[^A-Za-záéíóúÑñ\s]")){
    alert("perita");
  }else{
    alert("aaaaaaaaaa");
  }
}