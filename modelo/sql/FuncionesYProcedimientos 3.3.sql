CREATE OR REPLACE PROCEDURE nueva_unidadfamiliar (
    w_poblacion       IN                unidadesfamiliares.poblacion%TYPE,
    w_domicilio       IN                unidadesfamiliares.domicilio%TYPE,
    w_codigopostal    IN                unidadesfamiliares.codigopostal%TYPE,
    w_gastosfamilia   IN                unidadesfamiliares.gastosfamilia%TYPE
) IS
BEGIN
    INSERT INTO unidadesfamiliares (
        oid_uf,
        ingresosfamilia,
        gastosfamilia,
        poblacion,
        domicilio,
        codigopostal
    ) VALUES (
        0,
        0,
        w_gastosfamilia,
        w_poblacion,
        w_domicilio,
        w_codigopostal
    );

END nueva_unidadfamiliar;
/

CREATE OR REPLACE FUNCTION unidadfamiliar_de_solicitante (
    w_dni   IN      usuarios.dni%TYPE
) RETURN INTEGER IS
    w_oid_uf   usuarios.oid_uf%TYPE;
BEGIN
    SELECT
        oid_uf
    INTO w_oid_uf
    FROM
        usuarios
    WHERE
        w_dni = dni;

    RETURN w_oid_uf;
END unidadfamiliar_de_solicitante;
/

CREATE OR REPLACE PROCEDURE nuevo_solicitante (
    w_dni                    IN                       usuarios.dni%TYPE,
    w_nombre                 IN                       usuarios.nombre%TYPE,
    w_apellidos              IN                       usuarios.apellidos%TYPE,
    w_ingresos               IN                       usuarios.ingresos%TYPE,
    w_situacionlaboral       IN                       usuarios.situacionlaboral%TYPE,
    w_estudios               IN                       usuarios.estudios%TYPE,
    w_sexo                   IN                       usuarios.sexo%TYPE,
    w_telefono               IN                       usuarios.telefono%TYPE,
    w_poblacion              IN                       unidadesfamiliares.poblacion%TYPE,
    w_domicilio              IN                       unidadesfamiliares.domicilio%TYPE,
    w_codigopostal           IN                       unidadesfamiliares.codigopostal%TYPE,
    w_gastosfamilia          IN                       unidadesfamiliares.gastosfamilia%TYPE,
    w_estadocivil            IN                       usuarios.estadocivil%TYPE,
    w_fechanacimiento        IN                       usuarios.fechanacimiento%TYPE,
    w_protecciondatos        IN                       usuarios.protecciondatos%TYPE,
    w_problematica           IN                       usuarios.problematica%TYPE,
    w_tratamiento            IN                       usuarios.tratamiento%TYPE,
    w_minusvalia             IN                       usuarios.minusvalia%TYPE,
    w_valoracionminusvalia   IN                       usuarios.valoracionminusvalia%TYPE
) IS
BEGIN
    nueva_unidadfamiliar(w_poblacion, w_domicilio, w_codigopostal, w_gastosfamilia);
    INSERT INTO usuarios (
        dni,
        nombre,
        apellidos,
        ingresos,
        situacionlaboral,
        estudios,
        sexo,
        telefono,
        estadocivil,
        fechanacimiento,
        protecciondatos,
        solicitante,
        parentesco,
        problematica,
        tratamiento,
        minusvalia,
        valoracionminusvalia,
        oid_uf,
        dni_so
    ) VALUES (
        w_dni,
        w_nombre,
        w_apellidos,
        w_ingresos,
        w_situacionlaboral,
        w_estudios,
        w_sexo,
        w_telefono,
        w_estadocivil,
        TO_DATE(w_fechanacimiento, 'DD/MM/YYYY'),
        w_protecciondatos,
        'Sí',
        NULL,
        w_problematica,
        w_tratamiento,
        w_minusvalia,
        w_valoracionminusvalia,
        sec_uf.CURRVAL,
        NULL
    );

END nuevo_solicitante;
/

CREATE OR REPLACE PROCEDURE borrar_solicitante (
    w_dni   IN      usuarios.dni%TYPE
) AS
    usuario   usuarios%rowtype;
BEGIN
    SELECT
        *
    INTO usuario
    FROM
        usuarios
    WHERE
        dni = w_dni;

    DELETE FROM usuarios
    WHERE
        oid_uf = usuario.oid_uf;

    DELETE FROM unidadesfamiliares
    WHERE
        oid_uf = usuario.oid_uf;

END borrar_solicitante;
/

CREATE OR REPLACE PROCEDURE nuevo_familiar (
    w_dni                    IN                       usuarios.dni%TYPE,
    w_nombre                 IN                       usuarios.nombre%TYPE,
    w_apellidos              IN                       usuarios.apellidos%TYPE,
    w_ingresos               IN                       usuarios.ingresos%TYPE,
    w_situacionlaboral       IN                       usuarios.situacionlaboral%TYPE,
    w_estudios               IN                       usuarios.estudios%TYPE,
    w_sexo                   IN                       usuarios.sexo%TYPE,
    w_telefono               IN                       usuarios.telefono%TYPE,
    w_estadocivil            IN                       usuarios.estadocivil%TYPE,
    w_fechanacimiento        IN                       usuarios.fechanacimiento%TYPE,
    w_parentesco             IN                       usuarios.parentesco%TYPE,
    w_problematica           IN                       usuarios.problematica%TYPE,
    w_tratamiento            IN                       usuarios.tratamiento%TYPE,
    w_minusvalia             IN                       usuarios.minusvalia%TYPE,
    w_valoracionminusvalia   IN                       usuarios.valoracionminusvalia%TYPE,
    w_dni_so                 IN                       usuarios.dni_so%TYPE
) IS
BEGIN
    INSERT INTO usuarios (
        dni,
        nombre,
        apellidos,
        ingresos,
        situacionlaboral,
        estudios,
        sexo,
        telefono,
        estadocivil,
        fechanacimiento,
        protecciondatos,
        solicitante,
        parentesco,
        problematica,
        tratamiento,
        minusvalia,
        valoracionminusvalia,
        oid_uf,
        dni_so
    ) VALUES (
        w_dni,
        w_nombre,
        w_apellidos,
        w_ingresos,
        w_situacionlaboral,
        w_estudios,
        w_sexo,
        w_telefono,
        w_estadocivil,
        TO_DATE(w_fechanacimiento, 'DD/MM/RRRR'),
        'No',
        'No',
        w_parentesco,
        w_problematica,
        w_tratamiento,
        w_minusvalia,
        w_valoracionminusvalia,
        unidadfamiliar_de_solicitante(w_dni_so),
        w_dni_so
    );

END nuevo_familiar;
/

CREATE OR REPLACE PROCEDURE borrar_familiar (
    w_dni   IN      usuarios.dni%TYPE
) IS
BEGIN
    DELETE FROM usuarios
    WHERE
        dni = w_dni;

END borrar_familiar;
/

CREATE OR REPLACE PROCEDURE obtener_ingresosfamilia (
    w_oid_uf     IN           usuarios.oid_uf%TYPE,
    w_ingresos   IN           unidadesfamiliares.ingresosfamilia%TYPE
) IS
    w_ingresosfamilia   unidadesfamiliares.ingresosfamilia%TYPE;
BEGIN
    SELECT
        SUM(ingresos)
    INTO w_ingresosfamilia
    FROM
        usuarios
    WHERE
        oid_uf = w_oid_uf;

    IF ( w_ingresosfamilia = 0 ) THEN
        UPDATE unidadesfamiliares
        SET
            ingresosfamilia = ( w_ingresos + w_ingresosfamilia )
        WHERE
            oid_uf = w_oid_uf;

    ELSE
        UPDATE unidadesfamiliares
        SET
            ingresosfamilia = ( ingresosfamilia + w_ingresos )
        WHERE
            oid_uf = w_oid_uf;

    END IF;

END obtener_ingresosfamilia;
/

CREATE OR REPLACE PROCEDURE nueva_ayuda_de_comida (
    w_suministradapor   IN                  ayudas.suministradapor%TYPE,
    w_concedida         IN                  ayudas.concedida%TYPE,
    w_bebe              IN                  comidas.bebe%TYPE,
    w_niño              IN                  comidas.niño%TYPE,
    w_oid_c             IN                  citas.oid_c%TYPE
) IS
BEGIN
    INSERT INTO ayudas (
        oid_a,
        suministradapor,
        concedida,
        oid_c
    ) VALUES (
        0,
        w_suministradapor,
        w_concedida,
        w_oid_c
    );

    INSERT INTO comidas (
        oid_co,
        bebe,
        niño,
        oid_a
    ) VALUES (
        0,
        w_bebe,
        w_niño,
        sec_a.CURRVAL
    );

END nueva_ayuda_de_comida;
/

CREATE OR REPLACE PROCEDURE nueva_ayuda_economica (
    w_suministradapor   IN                  ayudas.suministradapor%TYPE,
    w_concedida         IN                  ayudas.concedida%TYPE,
    w_cantidad          IN                  ayudaseconomicas.cantidad%TYPE,
    w_motivo            IN                  ayudaseconomicas.motivo%TYPE,
    w_prioridad         IN                  ayudaseconomicas.prioridad%TYPE,
    w_oid_c             IN                  citas.oid_c%TYPE
) IS
BEGIN
    INSERT INTO ayudas (
        oid_a,
        suministradapor,
        concedida,
        oid_c
    ) VALUES (
        0,
        w_suministradapor,
        w_concedida,
        w_oid_c
    );

    INSERT INTO ayudaseconomicas (
        oid_ae,
        cantidad,
        motivo,
        prioridad,
        oid_a
    ) VALUES (
        0,
        w_cantidad,
        w_motivo,
        w_prioridad,
        sec_a.CURRVAL
    );

END nueva_ayuda_economica;
/

CREATE OR REPLACE PROCEDURE nueva_ayuda_trabajo (
    w_suministradapor     IN                    ayudas.suministradapor%TYPE,
    w_concedida           IN                    ayudas.concedida%TYPE,
    w_descripcion         IN                    trabajos.descripcion%TYPE,
    w_empresa             IN                    trabajos.empresa%TYPE,
    w_salarioaproximado   IN                    trabajos.salarioaproximado%TYPE,
    w_oid_c               IN                    citas.oid_c%TYPE
) IS
BEGIN
    INSERT INTO ayudas (
        oid_a,
        suministradapor,
        concedida,
        oid_c
    ) VALUES (
        0,
        w_suministradapor,
        w_concedida,
        w_oid_c
    );

    INSERT INTO trabajos (
        oid_t,
        descripcion,
        empresa,
        salarioaproximado,
        oid_a
    ) VALUES (
        0,
        w_descripcion,
        w_empresa,
        w_salarioaproximado,
        sec_a.CURRVAL
    );

END nueva_ayuda_trabajo;
/

CREATE OR REPLACE PROCEDURE nuevo_curso (
    w_profesor                IN                        cursos.profesor%TYPE,
    w_materia                 IN                        cursos.materia%TYPE,
    w_fechacomienzo           IN                        cursos.fechacomienzo%TYPE,
    w_fechafin                IN                        cursos.fechafin%TYPE,
    w_numerosesiones          IN                        cursos.numerosesiones%TYPE,
    w_horasporsesion          IN                        cursos.horasporsesion%TYPE,
    w_numeroalumnosactuales   IN                        cursos.numeroalumnosactuales%TYPE,
    w_numeroalumnosmaximo     IN                        cursos.numeroalumnosmaximo%TYPE,
    w_lugar                   IN                        cursos.lugar%TYPE
) IS
BEGIN
    INSERT INTO cursos (
        oid_cu,
        profesor,
        materia,
        fechacomienzo,
        fechafin,
        numerosesiones,
        horasporsesion,
        numeroalumnosactuales,
        numeroalumnosmaximo,
        lugar,
        oid_a
    ) VALUES (
        0,
        w_profesor,
        w_materia,
        TO_DATE(w_fechacomienzo, 'DD/MM/RRRR'),
        TO_DATE(w_fechafin, 'DD/MM/RRRR'),
        w_numerosesiones,
        w_horasporsesion,
        w_numeroalumnosactuales,
        w_numeroalumnosmaximo,
        w_lugar,
        NULL
    );

END nuevo_curso;
/

CREATE OR REPLACE PROCEDURE nueva_cita (
    w_fechacita       IN                citas.fechacita%TYPE,
    w_objetivo        IN                citas.objetivo%TYPE,
    w_observaciones   IN                citas.observaciones%TYPE,
    w_nombrev         IN                citas.nombrev%TYPE,
    w_dni             IN                usuarios.dni%TYPE
) IS
BEGIN
    INSERT INTO citas (
        oid_c,
        fechacita,
        objetivo,
        observaciones,
        nombrev,
        oid_pc,
        dni
    ) VALUES (
        0,
        TO_DATE(w_fechacita, 'DD/MM/RRRR'),
        w_objetivo,
        w_observaciones,
        w_nombrev,
        NULL,
        w_dni
    );

END nueva_cita;
/

CREATE OR REPLACE PROCEDURE nuevo_voluntario (
    w_nombrev      IN             voluntarios.nombrev%TYPE,
    w_contraseña   IN             voluntarios.contraseña%TYPE,
    w_permiso      IN             voluntarios.permiso%TYPE
) IS
BEGIN
    INSERT INTO voluntarios (
        nombrev,
        contraseña,
        permiso
    ) VALUES (
        w_nombrev,
        w_contraseña,
        w_permiso
    );

END nuevo_voluntario;
/

CREATE OR REPLACE FUNCTION usuario_duplicado (
    w_dni   IN      usuarios.dni%TYPE
) RETURN BOOLEAN AS
    res   BOOLEAN;
    CURSOR c IS
    SELECT
        dni
    FROM
        usuarios
    ORDER BY
        dni;

BEGIN
    res := false;
    FOR fila IN c LOOP
        IF ( fila.dni = w_dni ) THEN
            res := true;
        END IF;
    END LOOP;

    RETURN res;
END usuario_duplicado;
/

CREATE OR REPLACE FUNCTION ingresosfamiliares_de_uf (
    w_oid_uf   IN         unidadesfamiliares.oid_uf%TYPE
) RETURN NUMBER IS
    w_ingresosfamilia   unidadesfamiliares.ingresosfamilia%TYPE;
BEGIN
    SELECT
        ingresosfamilia
    INTO w_ingresosfamilia
    FROM
        unidadesfamiliares
    WHERE
        w_oid_uf = oid_uf;

    RETURN w_ingresosfamilia;
END ingresosfamiliares_de_uf;
/

CREATE OR REPLACE FUNCTION assert_equals (
    salida BOOLEAN,
    salida_esperada BOOLEAN
) RETURN VARCHAR2 AS
BEGIN
    IF ( salida = salida_esperada ) THEN
        RETURN 'EXITO';
    ELSE
        RETURN 'FALLO';
    END IF;
END assert_equals;
/

CREATE OR REPLACE PROCEDURE interesado_en_curso (
    w_suministradapor   IN                  ayudas.suministradapor%TYPE,
    w_concedida         IN                  ayudas.concedida%TYPE,
    w_oid_cu            IN                  cursos.oid_cu%TYPE,
    w_oid_c             IN                  citas.oid_c%TYPE
) AS
    aux     INT;
    curso   cursos%rowtype;
BEGIN
    INSERT INTO ayudas (
        oid_a,
        suministradapor,
        concedida,
        oid_c
    ) VALUES (
        0,
        w_suministradapor,
        w_concedida,
        w_oid_c
    );

    SELECT
        numeroalumnosactuales
    INTO aux
    FROM
        cursos
    WHERE
        oid_cu = w_oid_cu;

    aux := ( aux + 1 );
    UPDATE cursos
    SET
        numeroalumnosactuales = aux
    WHERE
        oid_cu = w_oid_cu;

END interesado_en_curso;
/

CREATE OR REPLACE FUNCTION contraseñas (
    w_contraseña   IN             voluntarios.contraseña%TYPE,
    w_nombrev      IN             voluntarios.nombrev%TYPE
) RETURN BOOLEAN AS
    res   BOOLEAN := true;
    aux   voluntarios.contraseña%TYPE;
BEGIN
    SELECT
        contraseña
    INTO aux
    FROM
        voluntarios
    WHERE
        nombrev = w_nombrev;

    IF ( aux <> w_contraseña ) THEN
        res := false;
    END IF;
    RETURN res;
END contraseñas;
/
CREATE OR REPLACE PROCEDURE editar_solicitante (
    w_dni                    IN                       usuarios.dni%TYPE,
    w_nombre                 IN                       usuarios.nombre%TYPE,
    w_apellidos              IN                       usuarios.apellidos%TYPE,
    w_ingresos               IN                       usuarios.ingresos%TYPE,
    w_situacionlaboral       IN                       usuarios.situacionlaboral%TYPE,
    w_estudios               IN                       usuarios.estudios%TYPE,
    w_sexo                   IN                       usuarios.sexo%TYPE,
    w_telefono               IN                       usuarios.telefono%TYPE,
    w_poblacion              IN                       unidadesfamiliares.poblacion%TYPE,
    w_domicilio              IN                       unidadesfamiliares.domicilio%TYPE,
    w_codigopostal           IN                       unidadesfamiliares.codigopostal%TYPE,
    w_gastosfamilia          IN                       unidadesfamiliares.gastosfamilia%TYPE,
    w_estadocivil            IN                       usuarios.estadocivil%TYPE,
    w_fechanacimiento        IN                       usuarios.fechanacimiento%TYPE,
    w_protecciondatos        IN                       usuarios.protecciondatos%TYPE,
    w_problematica           IN                       usuarios.problematica%TYPE,
    w_tratamiento            IN                       usuarios.tratamiento%TYPE,
    w_minusvalia             IN                       usuarios.minusvalia%TYPE,
    w_valoracionminusvalia   IN                       usuarios.valoracionminusvalia%TYPE,
    w_oid_uf    IN          unidadesfamiliares.oid_uf%TYPE,
    w_solicitante   IN  usuarios.solicitante%TYPE
) IS
BEGIN
    UPDATE unidadesfamiliares SET poblacion=w_poblacion, domicilio=w_domicilio, codigopostal=w_codigopostal, gastosfamilia=w_gastosfamilia WHERE oid_uf = w_oid_uf;
    UPDATE usuarios SET nombre=w_nombre,apellidos=w_apellidos, ingresos=w_ingresos, situacionlaboral=w_situacionlaboral, estudios=w_estudios, sexo=w_sexo, telefono=w_telefono, estadocivil=w_estadocivil,
    fechanacimiento=w_fechanacimiento, protecciondatos=w_protecciondatos, problematica=w_problematica, tratamiento=w_tratamiento, minusvalia=w_minusvalia, valoracionminusvalia=w_valoracionminusvalia,
    solicitante=w_solicitante WHERE dni=w_dni;

END editar_solicitante;
/