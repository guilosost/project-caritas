--Empezamos con los borrados de las tablas
DROP TABLE trabajos;

DROP TABLE cursos;

DROP TABLE ayudaseconomicas;

DROP TABLE comidas;

DROP TABLE ayudas;

DROP TABLE citas;

DROP TABLE usuarios;

DROP TABLE unidadesfamiliares;

DROP TABLE voluntarios;

--Seguimos con la creacion de las tablas con sus respectivos atributos

CREATE TABLE voluntarios (
    nombrev      VARCHAR2(50) NOT NULL,
    contraseña   VARCHAR2(20),
    permiso      CHAR(3)
        CONSTRAINT "BOOLEAN_CHK1" CHECK ( permiso IN (
            'Sí',
            'No'
        ) ),
    PRIMARY KEY ( nombrev )
);

CREATE TABLE unidadesfamiliares (
    oid_uf            INTEGER NOT NULL,
    ingresosfamilia   NUMBER(10, 2),
    gastosfamilia     NUMBER(10, 2),
    poblacion         VARCHAR2(30),
    domicilio         VARCHAR2(50),
    codigopostal      VARCHAR2(5),
    PRIMARY KEY ( oid_uf )
);

CREATE TABLE usuarios (
    dni                    CHAR(9) NOT NULL,
    nombre                 VARCHAR2(50) NOT NULL,
    apellidos              VARCHAR2(50) NOT NULL,
    ingresos               INTEGER NOT NULL,
    situacionlaboral       VARCHAR(20)
        CONSTRAINT "SIT_LABORAL" CHECK ( situacionlaboral IN (
            'Trabajando',
            'En paro',
            NULL
        ) ),
    estudios               VARCHAR(100),
    sexo                   VARCHAR2(10)
        CONSTRAINT "SEXO" CHECK ( sexo IN (
            'Masculino',
            'Femenino'
        ) ),
    telefono               VARCHAR(10),
    estadocivil            VARCHAR(20) NOT NULL,
    fechanacimiento        DATE NOT NULL,
    protecciondatos        CHAR(3)
        CONSTRAINT "BOOLEAN_CHK2" CHECK ( protecciondatos IN (
            'Sí',
            'No',
            NULL
        ) ),
    solicitante            CHAR(3)
        CONSTRAINT "BOOLEAN_CHK3" CHECK ( solicitante IN (
            'Sí',
            'No'
        ) ),
    parentesco             VARCHAR(20),
    problematica           VARCHAR2(100),
    tratamiento            CHAR(3)
        CONSTRAINT "BOOLEAN_CHK4" CHECK ( tratamiento IN (
            'Sí',
            'No'
        ) ),
    minusvalia             CHAR(3)
        CONSTRAINT "BOOLEAN_CHK5" CHECK ( minusvalia IN (
            'Sí',
            'No'
        ) ),
    valoracionminusvalia   CHAR(20)
        CONSTRAINT "VALORACION_MINUSVALIA" CHECK ( valoracionminusvalia IN (
            'Sí',
            'No',
            'En proceso'
        ) ),
    oid_uf                 INTEGER NOT NULL,
    dni_so                 CHAR(9),
    PRIMARY KEY ( dni ),
    FOREIGN KEY ( oid_uf )
        REFERENCES unidadesfamiliares,
    FOREIGN KEY ( dni_so )
        REFERENCES usuarios
);

CREATE TABLE citas (
    oid_c           INTEGER NOT NULL,
    fechacita       DATE,
    objetivo        VARCHAR2(100),
    observaciones   VARCHAR2(600),
    nombrev         VARCHAR2(50),
    oid_pc          INTEGER,
    dni             CHAR(9),
    PRIMARY KEY ( oid_c ),
    FOREIGN KEY ( nombrev )
        REFERENCES voluntarios,
    FOREIGN KEY ( oid_pc )
        REFERENCES citas,
    FOREIGN KEY ( dni )
        REFERENCES usuarios
);

CREATE TABLE ayudas (
    oid_a             INTEGER NOT NULL,
    suministradapor   VARCHAR2(50),
    concedida         CHAR(3)
        CONSTRAINT "BOOLEAN_CHK7" CHECK ( concedida IN (
            'Sí',
            'No'
        ) ),
    oid_c             INTEGER,
    PRIMARY KEY ( oid_a ),
    FOREIGN KEY ( oid_c )
        REFERENCES citas
);

CREATE TABLE comidas (
    oid_co   INTEGER NOT NULL,
    bebe     CHAR(3)
        CONSTRAINT "BOOLEAN_CHK8" CHECK ( bebe IN (
            'Sí',
            'No'
        ) ),
    niño     CHAR(3)
        CONSTRAINT "BOOLEAN_CHK9" CHECK ( niño IN (
            'Sí',
            'No'
        ) ),
    oid_a    INTEGER,
    PRIMARY KEY ( oid_co ),
    FOREIGN KEY ( oid_a )
        REFERENCES ayudas
);

CREATE TABLE ayudaseconomicas (
    oid_ae      INTEGER NOT NULL,
    cantidad    NUMBER(10, 2),
    motivo      VARCHAR2(100),
    prioridad   CHAR(3)
        CONSTRAINT "BOOLEAN_CHK10" CHECK ( prioridad IN (
            'Sí',
            'No'
        ) ),
    oid_a       INTEGER,
    PRIMARY KEY ( oid_ae ),
    FOREIGN KEY ( oid_a )
        REFERENCES ayudas
);

CREATE TABLE cursos (
    oid_cu                  INTEGER NOT NULL,
    profesor                VARCHAR2(50),
    materia                 VARCHAR2(50),
    fechacomienzo           DATE,
    fechafin                DATE,
    numerosesiones          INT,
    horasporsesion          INT,
    numeroalumnosactuales   INT,
    numeroalumnosmaximo     INT,
    lugar                   VARCHAR(30),
    oid_a                   INTEGER,
    PRIMARY KEY ( oid_cu ),
    FOREIGN KEY ( oid_a )
        REFERENCES ayudas
);

CREATE TABLE trabajos (
    oid_t               INTEGER NOT NULL,
    descripcion         VARCHAR2(300),
    empresa             VARCHAR2(20),
    salarioaproximado   INTEGER,
    oid_a               INTEGER,
    PRIMARY KEY ( oid_t ),
    FOREIGN KEY ( oid_a )
        REFERENCES ayudas
);

DROP SEQUENCE sec_uf;

CREATE SEQUENCE sec_uf INCREMENT BY 1 START WITH 1;

DROP SEQUENCE sec_c;

CREATE SEQUENCE sec_c INCREMENT BY 1 START WITH 1;

DROP SEQUENCE sec_a;

CREATE SEQUENCE sec_a INCREMENT BY 1 START WITH 1;

DROP SEQUENCE sec_co;

CREATE SEQUENCE sec_co INCREMENT BY 1 START WITH 1;

DROP SEQUENCE sec_ae;

CREATE SEQUENCE sec_ae INCREMENT BY 1 START WITH 1;

DROP SEQUENCE sec_cu;

CREATE SEQUENCE sec_cu INCREMENT BY 1 START WITH 1;

DROP SEQUENCE sec_t;

CREATE SEQUENCE sec_t INCREMENT BY 1 START WITH 1;

CREATE OR REPLACE TRIGGER secuencia_uf BEFORE
    INSERT ON unidadesfamiliares
    FOR EACH ROW
BEGIN
    SELECT
        sec_uf.NEXTVAL
    INTO :new.oid_uf
    FROM
        dual;

END;
/

CREATE OR REPLACE TRIGGER secuencia_c BEFORE
    INSERT ON citas
    FOR EACH ROW
BEGIN
    SELECT
        sec_c.NEXTVAL
    INTO :new.oid_c
    FROM
        dual;

END;
/

CREATE OR REPLACE TRIGGER secuencia_a BEFORE
    INSERT ON ayudas
    FOR EACH ROW
BEGIN
    SELECT
        sec_a.NEXTVAL
    INTO :new.oid_a
    FROM
        dual;

END;
/

CREATE OR REPLACE TRIGGER secuencia_co BEFORE
    INSERT ON comidas
    FOR EACH ROW
BEGIN
    SELECT
        sec_co.NEXTVAL
    INTO :new.oid_co
    FROM
        dual;

END;
/

CREATE OR REPLACE TRIGGER secuencia_ae BEFORE
    INSERT ON ayudaseconomicas
    FOR EACH ROW
BEGIN
    SELECT
        sec_ae.NEXTVAL
    INTO :new.oid_ae
    FROM
        dual;

END;
/

CREATE OR REPLACE TRIGGER secuencia_cu BEFORE
    INSERT ON cursos
    FOR EACH ROW
BEGIN
    SELECT
        sec_cu.NEXTVAL
    INTO :new.oid_cu
    FROM
        dual;

END;
/

CREATE OR REPLACE TRIGGER secuencia_t BEFORE
    INSERT ON trabajos
    FOR EACH ROW
BEGIN
    SELECT
        sec_t.NEXTVAL
    INTO :new.oid_t
    FROM
        dual;

END;
/