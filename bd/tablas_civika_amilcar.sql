CREATE TABLE civika_ped.entregable_ec
(
	id_entregable   INT(10) auto_increment NOT NULL,
	nombre          varchar(45)  NOT NULL,
	descripcion     varchar(100) NOT NULL,
	instrucciones   varchar(250) NOT NULL,
	tipo_entregable varchar(10)  NOT NULL,
	activo          TINYINT(1) DEFAULT 1 NOT NULL,
	CONSTRAINT entregable_ec_pk PRIMARY KEY (id_entregable)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_bin;


CREATE TABLE civika_ped.entregable_has_archivo
(
	id_entregable_archivo INT(10) auto_increment NOT NULL,
	id_entregable         INT(10) NOT NULL,
	id_archivo            BIGINT UNSIGNED NOT NULL,
	CONSTRAINT entregable_has_archivo_pk PRIMARY KEY (id_entregable_archivo),
	CONSTRAINT entregable_has_archivo_FK FOREIGN KEY (id_archivo) REFERENCES civika_ped.archivo (id_archivo),
	CONSTRAINT entregable_has_archivo_FK_1 FOREIGN KEY (id_entregable) REFERENCES civika_ped.entregable_ec (id_entregable)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_bin;


ALTER TABLE civika_ped.entregable_ec
	ADD id_estandar_competencia INT UNSIGNED NOT NULL;

CREATE TABLE civika_ped.entregable_has_instrumento
(
	id_entregable_instrumento       BIGINT auto_increment NOT NULL,
	id_entregable                   int(10) NOT NULL,
	id_ec_instrumento_has_actividad INT UNSIGNED NOT NULL,
	CONSTRAINT entregable_has_instrumento_pk PRIMARY KEY (id_entregable_instrumento),
	CONSTRAINT entregable_has_instrumento_FK FOREIGN KEY (id_entregable) REFERENCES civika_ped.entregable_ec (id_entregable),
	CONSTRAINT entregable_has_instrumento_FK_1 FOREIGN KEY (id_ec_instrumento_has_actividad) REFERENCES civika_ped.ec_instrumento_has_actividad (id_ec_instrumento_has_actividad)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_bin;



#
///////////////////////////////////////////////////////////////////////////////////////////////////////////

CREATE TABLE civika_ped.ec_entregable_alumno
(
	id_entregable_alumno BIGINT auto_increment NOT NULL,
	id_usuario           INT UNSIGNED NOT NULL,
	id_entregable        int(10) NOT NULL,
	id_cat_proceso       INT UNSIGNED NOT NULL,
	calificacion         DECIMAL(5, 2) NULL,
	fecha_carga_archivo  DATETIME NULL,
	intentos_adicionales INT NULL,
	CONSTRAINT ec_entregable_alumno_pk PRIMARY KEY (id_entregable_alumno),
	CONSTRAINT ec_entregable_alumno_FK FOREIGN KEY (id_usuario) REFERENCES civika_ped.usuario (id_usuario),
	CONSTRAINT ec_entregable_alumno_FK_1 FOREIGN KEY (id_entregable) REFERENCES civika_ped.entregable_ec (id_entregable),
	CONSTRAINT ec_entregable_alumno_FK_2 FOREIGN KEY (id_cat_proceso) REFERENCES civika_ped.cat_proceso (id_cat_proceso)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_bin;


CREATE TABLE civika_ped.entregable_alumno_comentarios
(
	id_entregable_alumno_comentario BIGINT auto_increment NOT NULL,
	comentario                      varchar(100) NOT NULL,
	fecha                           DATETIME     NOT NULL,
	quien                           enum('instructor','alumno') NOT NULL,
	id_entregable_alumno            BIGINT       NOT NULL,
	CONSTRAINT entregable_comentarios_pk PRIMARY KEY (id_entregable_alumno_comentario),
	CONSTRAINT entregable_alumno_comentarios_FK FOREIGN KEY (id_entregable_alumno) REFERENCES civika_ped.ec_entregable_alumno (id_entregable_alumno)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_bin;

CREATE TABLE civika_ped.entregable_alumno_archivo
(
	id_entregable_alumno_archivo BIGINT auto_increment NOT NULL,
	id_entregable_alumno         BIGINT NOT NULL,
	id_archivo_instrumento       BIGINT UNSIGNED NULL,
	url_video                    TEXT NULL,
	CONSTRAINT entregable_alumno_archivo_pk PRIMARY KEY (id_entregable_alumno_archivo),
	CONSTRAINT entregable_alumno_archivo_FK_1 FOREIGN KEY (id_entregable_alumno) REFERENCES civika_ped.ec_entregable_alumno (id_entregable_alumno),
	CONSTRAINT entregable_alumno_archivo_FK FOREIGN KEY (id_archivo_instrumento) REFERENCES civika_ped.archivo_instrumento (id_archivo_instrumento)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb3
COLLATE=utf8mb3_bin;

