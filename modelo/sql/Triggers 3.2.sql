CREATE OR REPLACE TRIGGER es_menor BEFORE
    INSERT ON usuarios
    FOR EACH ROW
DECLARE
    anyo    INTEGER;
    mes     INTEGER;
    dia     INTEGER;
    anyo2   INTEGER;
    mes2    INTEGER;
    dia2    INTEGER;
BEGIN
    SELECT
        EXTRACT(YEAR FROM SYSDATE)
    INTO anyo
    FROM
        dual;

    SELECT
        EXTRACT(YEAR FROM TO_DATE(:new.fechanacimiento, 'DD/MM/RRRR'))
    INTO anyo2
    FROM
        dual;

    SELECT
        EXTRACT(MONTH FROM SYSDATE)
    INTO mes
    FROM
        dual;

    SELECT
        EXTRACT(MONTH FROM :new.fechanacimiento)
    INTO mes2
    FROM
        dual;

    SELECT
        EXTRACT(DAY FROM SYSDATE)
    INTO dia
    FROM
        dual;

    SELECT
        EXTRACT(DAY FROM :new.fechanacimiento)
    INTO dia2
    FROM
        dual;

    IF ( :new.solicitante = 'S�' AND ( ( ( anyo - anyo2 ) < 18 ) OR ( ( anyo - anyo2 ) = 17 AND mes > mes2 ) OR ( ( anyo - anyo2

    ) = 17 AND mes = mes2 AND dia > dia2 ) ) ) THEN
        raise_application_error(-20600, 'El solicitante con DNI '
                                        || :new.dni
                                        || ' es menor.');
    END IF;

END es_menor;
/

CREATE OR REPLACE TRIGGER rest_poblacion_unidadfamiliar BEFORE
    INSERT ON unidadesfamiliares
    FOR EACH ROW
DECLARE BEGIN
    IF ( :new.poblacion != 'San Juan de Aznalfarache' ) THEN
        raise_application_error(-20610, 'La unidad familiar debe residir en San Juan de Aznalfarache y reside en ' || :new.poblacion
        );
    END IF;
END;
/

CREATE OR REPLACE TRIGGER proteccion_datos BEFORE
    INSERT ON usuarios
    FOR EACH ROW
BEGIN
    IF ( :new.solicitante = 'S�' AND :new.protecciondatos = 'No' ) THEN
        raise_application_error(-20610, 'El solicitante con DNI '
                                        || :new.dni
                                        || ' no ha firmado la protecci�n de datos');
    END IF;
END;
/

CREATE OR REPLACE TRIGGER trigger_usuario_duplicado BEFORE
    INSERT ON usuarios
    FOR EACH ROW
BEGIN
    IF ( usuario_duplicado(:new.dni) ) THEN
        raise_application_error(-20615, 'El solicitante con DNI '
                                        || :new.dni
                                        || ' est� duplicado');
    END IF;
END;
/

CREATE OR REPLACE TRIGGER ingresos_individuales BEFORE
    INSERT OR UPDATE ON usuarios
    FOR EACH ROW
BEGIN
    IF ( :new.ingresos > 1000 ) THEN
        raise_application_error(-20605, 'Los ingresos del usuario con DNI '
                                        || :new.dni
                                        || ' son '
                                        || :new.ingresos
                                        || ' y no pueden sobrepasar los 1000 �');

    END IF;
END;
/

CREATE OR REPLACE TRIGGER rest_pide BEFORE
    INSERT ON ayudas
    FOR EACH ROW
DECLARE
    cita   citas%rowtype;
BEGIN
    SELECT
        *
    INTO cita
    FROM
        citas
    WHERE
        oid_c = :new.oid_c;

    IF ( ingresosfamiliares_de_uf(unidadfamiliar_de_solicitante(cita.dni)) > 1000 ) THEN
        raise_application_error(-20605, 'La suma de ingresos de la unidad familiar con OID '
                                        || unidadfamiliar_de_solicitante(cita.dni)
                                        || ' es de '
                                        || ingresosfamiliares_de_uf(unidadfamiliar_de_solicitante(cita.dni))
                                        || ' y no puede sobrepasar los 1000 �');

    END IF;

END;
/

CREATE OR REPLACE TRIGGER rest_suma_ingresos_uf BEFORE
    INSERT ON usuarios
    FOR EACH ROW
DECLARE BEGIN
    obtener_ingresosfamilia(:new.oid_uf, :new.ingresos);
END;
/

CREATE OR REPLACE TRIGGER rest_suma_ingresos_uf2 BEFORE
    UPDATE ON usuarios
    FOR EACH ROW
DECLARE
    PRAGMA autonomous_transaction;
BEGIN
    obtener_ingresosfamilia(:new.oid_uf, :new.ingresos);
    COMMIT;
END;
/

CREATE OR REPLACE TRIGGER usuarios_en_curso BEFORE
    UPDATE ON cursos
    FOR EACH ROW
BEGIN
    IF ( :old.numeroalumnosmaximo < :new.numeroalumnosactuales ) THEN
        raise_application_error(-20670, 'Curso completo');
    END IF;
END usuarios_en_curso;
/

CREATE OR REPLACE TRIGGER dos_solicitantes_mismo_dni BEFORE
    INSERT ON usuarios
    FOR EACH ROW
DECLARE
    usuario   INT;
BEGIN
    SELECT
        COUNT(*)
    INTO usuario
    FROM
        usuarios
    WHERE
        dni = :new.dni;

    IF ( usuario > 0 ) THEN
        raise_application_error(-20605, 'El DNI es �nico, este usuario est� repetido');
    END IF;
END;
/