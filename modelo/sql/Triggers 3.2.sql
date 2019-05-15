CREATE OR REPLACE TRIGGER es_menor BEFORE
    INSERT ON usuarios
    FOR EACH ROW
DECLARE
    anyo INTEGER;
    mes INTEGER;
    dia INTEGER;
    anyo2 INTEGER;
    mes2 INTEGER;
    dia2 INTEGER;
BEGIN
  select extract(year from sysdate) into anyo from dual;
  select extract(year from TO_DATE(:NEW.fechanacimiento,'DD/MM/RRRR')) into anyo2 from dual;
  select extract(month from sysdate) into mes from dual;
  select extract(month from :NEW.fechanacimiento) into mes2 from dual;
  select extract(day from sysdate) into dia from dual;
    select extract(day from :NEW.fechanacimiento) into dia2 from dual;
    
    IF(:new.solicitante = 'Sí' AND( ( (anyo-anyo2)<18) OR ( (anyo-anyo2)=17 AND mes>mes2) OR ((anyo-anyo2)=17 AND mes=mes2 AND dia>dia2))) THEN
    raise_application_error(-20600, 'El solicitante con DNI ' || :NEW.dni || ' es menor.');

    END IF;
   

END es_menor;
/

CREATE OR REPLACE TRIGGER rest_poblacion_unidadfamiliar BEFORE
    INSERT ON unidadesfamiliares
    FOR EACH ROW
DECLARE BEGIN
    IF ( :new.poblacion != 'San Juan de Aznalfarache' ) THEN
        raise_application_error(-20610, 'La unidad familiar debe residir en San Juan del Aznalfarache y reside en ' || :new.poblacion);
    END IF;
END;

/

CREATE OR REPLACE TRIGGER proteccion_datos BEFORE
    INSERT ON usuarios
    FOR EACH ROW
BEGIN
    IF ( :new.solicitante='Sí' AND :new.protecciondatos = 'No' ) THEN
        raise_application_error(-20610, 'El solicitante con DNI '
                                        || :new.dni
                                        || ' no ha firmado la protección de datos');
    END IF;
END;
/
CREATE OR REPLACE TRIGGER trigger_usuario_duplicado BEFORE
    INSERT ON usuarios
    FOR EACH ROW
BEGIN
    IF(usuario_duplicado(:NEW.dni)) THEN
     raise_application_error(-20615, 'El solicitante con DNI '
                                        || :new.dni
                                        || ' está duplicado');
    END IF;
END;
/

CREATE OR REPLACE TRIGGER ingresos_individuales BEFORE
     INSERT OR UPDATE ON usuarios
    FOR EACH ROW
BEGIN

 IF ( :NEW.ingresos > 1000 ) THEN
        raise_application_error(-20605, 'Los ingresos del usuario con DNI ' || :new.dni || ' son ' || :NEW.ingresos || ' y no pueden sobrepasar los 1000 €');
    END IF;
    
END;
/

CREATE OR REPLACE TRIGGER rest_pide BEFORE
    INSERT ON ayudas
    FOR EACH ROW
    DECLARE
  cita  citas%ROWTYPE;
 BEGIN
 Select * INTO cita FROM citas WHERE oid_c=:new.oid_c;
 
    IF ( ingresosfamiliares_de_uf(unidadfamiliar_de_solicitante(cita.dni)) >1000 ) THEN
       raise_application_error(-20605, 'La suma de ingresos de la unidad familiar con OID ' || unidadfamiliar_de_solicitante(cita.dni) || ' es de ' || ingresosfamiliares_de_uf(unidadfamiliar_de_solicitante(cita.dni)) || ' y no puede sobrepasar los 1000 €');
   END IF;
END;
/
CREATE OR REPLACE TRIGGER rest_suma_ingresos_uf BEFORE
    INSERT  ON usuarios
    FOR EACH ROW
   DECLARE
   
BEGIN
    obtener_ingresosfamilia(:NEW.oid_uf,:NEW.ingresos);
   
END;
/
CREATE OR REPLACE TRIGGER rest_suma_ingresos_uf2 BEFORE
    UPDATE  ON usuarios
    FOR EACH ROW
   DECLARE
   PRAGMA AUTONOMOUS_TRANSACTION;
BEGIN
    obtener_ingresosfamilia(:NEW.oid_uf,:NEW.ingresos);
   COMMIT;
END;
/

CREATE OR REPLACE TRIGGER usuarios_en_curso BEFORE
 UPDATE ON cursos 
 FOR EACH ROW
 BEGIN 
    IF(:OLD.numeroalumnosmaximo<:NEW.numeroalumnosactuales)THEN
    raise_application_error(-20670, 'Curso completo');
      END IF;
END usuarios_en_curso;
/
CREATE OR REPLACE TRIGGER dos_solicitantes_mismo_dni BEFORE
     INSERT ON usuarios
    FOR EACH ROW
    DECLARE
    usuario int;
BEGIN
        SELECT
           count(*)
        INTO usuario
        FROM
            usuarios
        WHERE
            dni=:NEW.dni;
 IF ( usuario > 0 ) THEN
        raise_application_error(-20605, 'El DNI es único, este usuario está repetido');
    END IF;
    
END;
/