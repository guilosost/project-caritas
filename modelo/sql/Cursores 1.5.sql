CREATE OR REPLACE PROCEDURE muestra_ayudas (
    limite INT
) AS

    CURSOR c IS
    SELECT
        oid_a,
        oid_c,
        suministradapor,
        concedida,
        fechacita,
        nombre,
        apellidos,
        dni
    FROM
        ayudas
        NATURAL JOIN citas
        NATURAL JOIN usuarios
    ORDER BY
        oid_a;

BEGIN
    dbms_output.put_line('LISTA DE AYUDAS:');
    FOR fila IN c LOOP
        EXIT WHEN c%rowcount = limite + 1;
        dbms_output.put_line('OID_A: '
                             || fila.oid_a
                             || ' | '
                             || 'Concedida: '
                             || fila.concedida
                             || ' | '
                             || 'Suministrada por: '
                             || fila.suministradapor
                             || ' | '
                             || 'OID_C: '
                             || fila.oid_c
                             || ' | '
                             || 'Fecha de resolución: '
                             || ' '
                             || fila.fechacita
                             || ' | '
                             || 'Nombre y apellidos: '
                             || fila.nombre
                             || ' '
                             || fila.apellidos
                             || ' | '
                             || 'DNI: '
                             || fila.dni);

    END LOOP;

END;
/

CREATE OR REPLACE PROCEDURE muestra_todas_ayudas AS

    CURSOR c IS
    SELECT
        oid_a,
        oid_c,
        suministradapor,
        concedida,
        fechacita,
        nombre,
        apellidos,
        dni
    FROM
        ayudas
        NATURAL JOIN citas
        NATURAL JOIN usuarios
    ORDER BY
        oid_a;

BEGIN
    dbms_output.put_line('LISTA DE AYUDAS:');
    FOR fila IN c LOOP
        EXIT WHEN c%notfound = true;
        dbms_output.put_line('OID_A: '
                             || fila.oid_a
                             || ' | '
                             || 'Concedida: '
                             || fila.concedida
                             || ' | '
                             || 'Suministrada por: '
                             || fila.suministradapor
                             || ' | '
                             || 'OID_C: '
                             || fila.oid_c
                             || ' | '
                             || 'Fecha de resolución: '
                             || ' '
                             || fila.fechacita
                             || ' | '
                             || 'Nombre y apellidos: '
                             || fila.nombre
                             || ' '
                             || fila.apellidos
                             || ' | '
                             || 'DNI: '
                             || fila.dni);

    END LOOP;

END;
/

CREATE OR REPLACE PROCEDURE muestra_usuarios (
    limite INT
) AS
    CURSOR c IS
    SELECT
        dni,
        nombre,
        apellidos,
        situacionlaboral,
        oid_uf
    FROM
        usuarios
    ORDER BY
        apellidos;

BEGIN
    dbms_output.put_line('LISTA DE USUARIOS:');
    FOR fila IN c LOOP
        EXIT WHEN c%rowcount = ( limite + 1 );
        dbms_output.put_line('DNI: '
                             || fila.dni
                             || ' | '
                             || 'Nombre y apellidos: '
                             || fila.nombre
                             || ' '
                             || fila.apellidos
                             || ' | '
                             || 'Situación laboral: '
                             || fila.situacionlaboral
                             || ' | '
                             || 'OID_UF: '
                             || fila.oid_uf);

    END LOOP;

END;
/

CREATE OR REPLACE PROCEDURE muestra_todos_usuarios AS
    CURSOR c IS
    SELECT
        dni,
        nombre,
        apellidos,
        situacionlaboral,
        oid_uf
    FROM
        usuarios
    ORDER BY
        apellidos;

BEGIN
    dbms_output.put_line('LISTA DE USUARIOS:');
    FOR fila IN c LOOP
        EXIT WHEN c%notfound = true;
        dbms_output.put_line('DNI: '
                             || fila.dni
                             || ' | '
                             || 'Nombre y apellidos: '
                             || fila.nombre
                             || ' '
                             || fila.apellidos
                             || ' | '
                             || 'Situación laboral: '
                             || fila.situacionlaboral
                             || ' | '
                             || 'OID_UF: '
                             || fila.oid_uf);

    END LOOP;

END;
/

CREATE OR REPLACE PROCEDURE muestra_usuario_completo (
    w_dni   IN      usuarios.dni%TYPE
) AS

    CURSOR c IS
    SELECT
        dni,
        nombre,
        apellidos,
        estadocivil,
        estudios,
        fechanacimiento,
        ingresos,
        minusvalia,
        problematica,
        protecciondatos,
        sexo,
        solicitante,
        telefono,
        tratamiento,
        valoracionminusvalia,
        situacionlaboral,
        oid_uf
    FROM
        usuarios
    WHERE
        w_dni = dni
    ORDER BY
        apellidos;

BEGIN
    dbms_output.put_line('USUARIO CON DNI: ' || w_dni);
    FOR fila IN c LOOP
        EXIT WHEN c%rowcount = 2;
        dbms_output.put_line('Nombre y apellidos: '
                             || fila.nombre
                             || ' '
                             || fila.apellidos
                             || ' | '
                             || 'Situación laboral: '
                             || fila.situacionlaboral
                             || ' | '
                             || 'OID_UF: '
                             || fila.oid_uf
                             || ' | '
                             || 'Estado civil: '
                             || fila.estadocivil
                             || ' | '
                             || 'Estudios: '
                             || fila.estudios
                             || ' | '
                             || 'Fecha nac.: '
                             || fila.fechanacimiento
                             || ' | '
                             || 'Ingresos(€): '
                             || fila.ingresos
                             || '  '
                             || 'Minusvalía: '
                             || fila.minusvalia
                             || '  '
                             || 'Valoración minusv: '
                             || fila.valoracionminusvalia);

        dbms_output.put_line('Problemática: '
                             || fila.problematica
                             || ' | '
                             || 'Tratamiento: '
                             || fila.tratamiento
                             || ' | '
                             || 'Sexo: '
                             || fila.sexo
                             || ' | '
                             || 'Solicitante: '
                             || fila.solicitante
                             || ' | '
                             || 'Teléfono: '
                             || fila.telefono);

    END LOOP;

END;
/

CREATE OR REPLACE PROCEDURE muestra_cursos AS

    CURSOR c IS
    SELECT
        fechacomienzo,
        fechafin,
        materia,
        horasporsesion,
        lugar,
        numeroalumnosactuales,
        numeroalumnosmaximo,
        numerosesiones,
        oid_cu,
        profesor
    FROM
        cursos
    WHERE
        fechafin > SYSDATE
        AND numeroalumnosactuales < numeroalumnosmaximo
    ORDER BY
        fechacomienzo;

BEGIN
    dbms_output.put_line('CURSOS:');
    FOR fila IN c LOOP
        EXIT WHEN c%notfound = true;
        dbms_output.put_line('FechaComienzo: '
                             || fila.fechacomienzo
                             || ' | '
                             || 'FechaFin: '
                             || fila.fechafin
                             || ' | '
                             || 'Materia: '
                             || fila.materia
                             || ' | '
                             || 'HorasPorSesion: '
                             || fila.horasporsesion
                             || ' | '
                             || 'Lugar: '
                             || fila.lugar
                             || ' | '
                             || 'NumeroDeAlumnosActuales: '
                             || fila.numeroalumnosactuales
                             || ' | '
                             || 'NumeroDeAlumnosMaximos: '
                             || fila.numeroalumnosmaximo
                             || ' | '
                             || 'NumeroDeSesiones: '
                             || fila.numerosesiones
                             || ' | '
                             || 'OID_CU: '
                             || fila.oid_cu
                             || ' | '
                             || 'Profesor: '
                             || fila.profesor);

    END LOOP;

END;
/

CREATE OR REPLACE PROCEDURE muestra_curso_menos_plazas AS

    CURSOR c IS
    SELECT
        fechacomienzo,
        fechafin,
        materia,
        numeroalumnosactuales,
        numeroalumnosmaximo,
        oid_cu
    FROM
        cursos
    WHERE
        fechafin > SYSDATE
        AND numeroalumnosactuales < numeroalumnosmaximo
    ORDER BY
        fechacomienzo;

    aux          INT := 0;
    aux2         INT := 9999;
    aux_oid_cu   VARCHAR2(10);
    curso        cursos%rowtype;
BEGIN
    dbms_output.put_line('CURSO CON MENOS PLAZAS:');
    FOR fila IN c LOOP
        EXIT WHEN c%notfound = true;
        aux := fila.numeroalumnosmaximo - fila.numeroalumnosactuales;
        IF ( aux < aux2 ) THEN
            aux2 := aux;
            aux_oid_cu := fila.oid_cu;
        END IF;

    END LOOP;

    SELECT
        *
    INTO curso
    FROM
        cursos
    WHERE
        oid_cu = aux_oid_cu;

    dbms_output.put_line('FechaComienzo: '
                         || curso.fechacomienzo
                         || ' | '
                         || 'FechaFin: '
                         || curso.fechafin
                         || ' | '
                         || 'Materia: '
                         || curso.materia
                         || ' | '
                         || 'HorasPorSesion: '
                         || curso.horasporsesion
                         || ' | '
                         || 'Lugar: '
                         || curso.lugar
                         || ' | '
                         || 'NumeroDeAlumnosActuales: '
                         || curso.numeroalumnosactuales
                         || ' | '
                         || 'NumeroDeAlumnosMaximos: '
                         || curso.numeroalumnosmaximo
                         || ' | '
                         || 'NumeroDeSesiones: '
                         || curso.numerosesiones
                         || ' | '
                         || 'OID_CU: '
                         || curso.oid_cu
                         || ' | '
                         || 'Profesor: '
                         || curso.profesor);

END;
/