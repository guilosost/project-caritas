function validarCalle() {
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
