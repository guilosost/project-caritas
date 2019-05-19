function validateDateCita(){
    var fechaCita = document.forms["altaCita"]["fechacita"].value;
    var currdate = new Date();
    if (currdate < fechaCita){
      alert("No se pueden crear citas en el futuro.");
    }
  }