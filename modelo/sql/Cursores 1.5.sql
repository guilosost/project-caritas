create or replace PROCEDURE muestra_ayudas (
limite int
) AS CURSOR c IS 
    SELECT oid_a, oid_c, suministradapor, concedida, fechacita, nombre, apellidos, dni FROM ayudas natural join citas natural join usuarios
    ORDER BY oid_a;
BEGIN
DBMS_OUTPUT.PUT_LINE('LISTA DE AYUDAS:');
FOR fila IN c LOOP
EXIT WHEN C%ROWCOUNT = limite+1;
DBMS_OUTPUT.PUT_LINE('OID_A: '||fila.oid_a||' | '||'Concedida: '||fila.concedida||' | '||'Suministrada por: '||fila.suministradapor||' | '||'OID_C: '||fila.oid_c||' | '||'Fecha de resolución: '||' '||fila.fechacita||' | '
||'Nombre y apellidos: '||fila.nombre||' '||fila.apellidos||' | '||'DNI: '||fila.dni);
END LOOP;
END;
/

create or replace PROCEDURE muestra_todas_ayudas
AS CURSOR c IS 
    SELECT oid_a, oid_c, suministradapor, concedida, fechacita, nombre, apellidos, dni FROM ayudas natural join citas natural join usuarios
    ORDER BY oid_a;
BEGIN
DBMS_OUTPUT.PUT_LINE('LISTA DE AYUDAS:');
FOR fila IN c LOOP
EXIT WHEN C%NOTFOUND = TRUE;
DBMS_OUTPUT.PUT_LINE('OID_A: '||fila.oid_a||' | '||'Concedida: '||fila.concedida||' | '||'Suministrada por: '||fila.suministradapor||' | '||'OID_C: '||fila.oid_c||' | '||'Fecha de resolución: '||' '||fila.fechacita||' | '
||'Nombre y apellidos: '||fila.nombre||' '||fila.apellidos||' | '||'DNI: '||fila.dni);
END LOOP;
END;
/

create or replace PROCEDURE muestra_usuarios (
limite int
) AS 
CURSOR c IS 
    SELECT dni, nombre,apellidos,situacionlaboral,oid_uf  FROM usuarios
    ORDER BY apellidos;
BEGIN
DBMS_OUTPUT.PUT_LINE('LISTA DE USUARIOS:');
FOR fila IN c LOOP
EXIT WHEN C%ROWCOUNT = (limite+1);
DBMS_OUTPUT.PUT_LINE('DNI: '||fila.dni||' | '||'Nombre y apellidos: '||fila.nombre||' '||fila.apellidos||' | '||'Situación laboral: '||fila.situacionlaboral||' | '||'OID_UF: '||fila.oid_uf);
END LOOP;
END;
/

create or replace PROCEDURE muestra_todos_usuarios 
 AS CURSOR c IS 
    SELECT dni, nombre,apellidos,situacionlaboral,oid_uf  FROM usuarios
    ORDER BY apellidos;
BEGIN
DBMS_OUTPUT.PUT_LINE('LISTA DE USUARIOS:');
FOR fila IN c LOOP
EXIT WHEN C%NOTFOUND = TRUE;
DBMS_OUTPUT.PUT_LINE('DNI: '||fila.dni||' | '||'Nombre y apellidos: '||fila.nombre||' '||fila.apellidos||' | '||'Situación laboral: '||fila.situacionlaboral||' | '||'OID_UF: '||fila.oid_uf);
END LOOP;
END;
/

create or replace PROCEDURE muestra_usuario_completo (
w_dni IN usuarios.dni%TYPE
) AS CURSOR c IS 
    SELECT dni, nombre,apellidos,estadocivil,estudios,fechanacimiento,ingresos,minusvalia,problematica
    ,protecciondatos,sexo,solicitante,telefono,tratamiento,valoracionminusvalia ,situacionlaboral,oid_uf  FROM usuarios
    WHERE w_dni=dni
    ORDER BY apellidos;
BEGIN
DBMS_OUTPUT.PUT_LINE('USUARIO CON DNI: '|| w_dni);
FOR fila IN c LOOP
EXIT WHEN C%ROWCOUNT = 2;
DBMS_OUTPUT.PUT_LINE('Nombre y apellidos: '||fila.nombre||' '||fila.apellidos||' | '||'Situación laboral: '||fila.situacionlaboral||' | '||'OID_UF: '||fila.oid_uf||' | '||'Estado civil: '||fila.estadocivil
||' | '||'Estudios: '||fila.estudios||' | '||'Fecha nac.: '||fila.fechanacimiento||' | '||'Ingresos(€): '||fila.ingresos||'  '||'Minusvalía: '||fila.minusvalia||'  '||'Valoración minusv: '||fila.valoracionminusvalia);
DBMS_OUTPUT.PUT_LINE('Problemática: '||fila.problematica||' | '||'Tratamiento: '||fila.tratamiento||' | '||'Sexo: '||fila.sexo||' | '||'Solicitante: '||fila.solicitante||' | '||'Teléfono: '||fila.telefono);
END LOOP;
END;
/

CREATE OR REPLACE PROCEDURE muestra_cursos 
AS CURSOR c IS 
    SELECT fechacomienzo, fechafin,materia,horasporsesion,lugar,numeroalumnosactuales,numeroalumnosmaximo,numerosesiones,oid_cu,profesor  FROM cursos
    WHERE fechafin>SYSDATE AND numeroalumnosactuales < numeroalumnosmaximo
    ORDER BY fechacomienzo;
BEGIN
DBMS_OUTPUT.PUT_LINE('CURSOS:');
FOR fila IN c LOOP
EXIT WHEN C%NOTFOUND = TRUE;
DBMS_OUTPUT.PUT_LINE('FechaComienzo: '||fila.fechacomienzo||' | '||'FechaFin: '||fila.fechafin||' | '||'Materia: '||fila.materia||' | '||'HorasPorSesion: '||fila.horasporsesion||' | '||'Lugar: '||fila.lugar||' | '
||'NumeroDeAlumnosActuales: '||fila.numeroalumnosactuales||' | '||'NumeroDeAlumnosMaximos: '||fila.numeroalumnosmaximo||' | '||'NumeroDeSesiones: '||fila.numerosesiones
||' | '||'OID_CU: '||fila.oid_cu||' | '||'Profesor: '||fila.profesor);
END LOOP;
END;
/
CREATE OR REPLACE PROCEDURE muestra_curso_menos_plazas
AS CURSOR c IS 
    SELECT fechacomienzo, fechafin,materia,numeroalumnosactuales,numeroalumnosmaximo,oid_cu  FROM cursos
    WHERE fechafin>SYSDATE AND numeroalumnosactuales < numeroalumnosmaximo
    ORDER BY fechacomienzo;
    aux int:=0;
    aux2 int:=9999;
    aux_oid_cu VARCHAR2(10);
    curso cursos%ROWTYPE;
BEGIN
DBMS_OUTPUT.PUT_LINE('CURSO CON MENOS PLAZAS:');
FOR fila IN c LOOP
EXIT WHEN C%NOTFOUND = TRUE;
aux:=fila.numeroalumnosmaximo-fila.numeroalumnosactuales;
if(aux<aux2)then
aux2:=aux;
aux_oid_cu:=fila.oid_cu;
end if;
END LOOP;
select * INTO curso FROM cursos WHERE oid_cu=aux_oid_cu;
DBMS_OUTPUT.PUT_LINE('FechaComienzo: '||curso.fechacomienzo||' | '||'FechaFin: '||curso.fechafin||' | '||'Materia: '||curso.materia||' | '||'HorasPorSesion: '||curso.horasporsesion||' | '||'Lugar: '||curso.lugar||' | '
||'NumeroDeAlumnosActuales: '||curso.numeroalumnosactuales||' | '||'NumeroDeAlumnosMaximos: '||curso.numeroalumnosmaximo||' | '||'NumeroDeSesiones: '||curso.numerosesiones
||' | '||'OID_CU: '||curso.oid_cu||' | '||'Profesor: '||curso.profesor);
END;
/
