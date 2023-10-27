CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(150) NOT NULL,
  `password` VARCHAR(350) NOT NULL,
  `activo` ENUM('si', 'no') NOT NULL DEFAULT 'si',
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `perfil` ENUM('root', 'admin', 'instructor', 'alumno') NULL COMMENT 'se usa para unos casos especiales nadamas',
  `password_temp` VARCHAR(350) NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_nivel_academico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_nivel_academico` (
  `id_cat_nivel_academico` INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id_cat_nivel_academico`))
ENGINE = InnoDB
COMMENT = '	';


-- -----------------------------------------------------
-- Table `cat_sector_ec`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_sector_ec` (
  `id_cat_sector_ec` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `activo` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id_cat_sector_ec`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `datos_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `datos_usuario` (
  `id_datos_usuario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `apellido_p` VARCHAR(100) NOT NULL,
  `apellido_m` VARCHAR(100) NULL,
  `genero` ENUM('m', 'f') NULL DEFAULT 'm' COMMENT 'columna de información para el genero\nm = masculino\nf = femenino\n',
  `fecha_nacimiento` DATE NULL,
  `correo` VARCHAR(250) NOT NULL,
  `celular` VARCHAR(35) NOT NULL,
  `telefono` VARCHAR(35) NULL,
  `curp` VARCHAR(18) NULL,
  `profesion` VARCHAR(250) NULL,
  `puesto` VARCHAR(250) NULL,
  `educacion` LONGTEXT NULL,
  `habilidades` LONGTEXT NULL,
  `update_datos` INT(5) NOT NULL DEFAULT 0,
  `fecha_update` DATE NULL,
  `lugar_nacimiento` VARCHAR(500) NULL,
  `nacionalidad` VARCHAR(250) NULL,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_cat_nivel_academico` INT(2) UNSIGNED NULL,
  `consentimiento_conocer` ENUM('si', 'no') NOT NULL DEFAULT 'si',
  `codigo_evaluador` VARCHAR(250) NULL,
  `es_estranjero` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `codigo_extranjero` VARCHAR(45) NULL,
  `id_cat_sector_ec` SMALLINT(3) UNSIGNED NULL,
  PRIMARY KEY (`id_datos_usuario`),
  INDEX `fk_datos_usuario_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_datos_usuario_cat_nivel_academico1_idx` (`id_cat_nivel_academico` ASC),
  INDEX `fk_datos_usuario_cat_sector_ec1_idx` (`id_cat_sector_ec` ASC),
  CONSTRAINT `fk_datos_usuario_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_usuario_cat_nivel_academico1`
    FOREIGN KEY (`id_cat_nivel_academico`)
    REFERENCES `cat_nivel_academico` (`id_cat_nivel_academico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_usuario_cat_sector_ec1`
    FOREIGN KEY (`id_cat_sector_ec`)
    REFERENCES `cat_sector_ec` (`id_cat_sector_ec`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_estado` (
  `id_cat_estado` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(3) NOT NULL,
  `abreviatura` VARCHAR(10) NOT NULL,
  `nombre_original` VARCHAR(100) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_cat_estado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_municipio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_municipio` (
  `id_cat_municipio` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `id_cat_estado` SMALLINT(2) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_cat_municipio`),
  INDEX `fk_cat_municipio_cat_estado_idx` (`id_cat_estado` ASC),
  CONSTRAINT `fk_cat_municipio_cat_estado`
    FOREIGN KEY (`id_cat_estado`)
    REFERENCES `cat_estado` (`id_cat_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_localidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_localidad` (
  `id_cat_localidad` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(35) NOT NULL,
  `nombre` VARCHAR(350) NOT NULL,
  `id_cat_municipio` INT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_cat_localidad`),
  INDEX `fk_cat_localidad_cat_municipio_idx` (`id_cat_municipio` ASC),
  CONSTRAINT `fk_cat_localidad_cat_municipio`
    FOREIGN KEY (`id_cat_municipio`)
    REFERENCES `cat_municipio` (`id_cat_municipio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `datos_domicilio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `datos_domicilio` (
  `id_datos_domicilio` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `calle` VARCHAR(100) NOT NULL,
  `numero_ext` VARCHAR(45) NOT NULL,
  `numero_int` VARCHAR(45) NULL,
  `codigo_postal` VARCHAR(45) NULL,
  `predeterminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_cat_estado` SMALLINT(2) UNSIGNED NOT NULL,
  `id_cat_municipio` INT(5) UNSIGNED NOT NULL,
  `id_cat_localidad` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_datos_domicilio`),
  INDEX `fk_datos_domicilio_cat_estado1_idx` (`id_cat_estado` ASC),
  INDEX `fk_datos_domicilio_cat_municipio1_idx` (`id_cat_municipio` ASC),
  INDEX `fk_datos_domicilio_cat_localidad1_idx` (`id_cat_localidad` ASC),
  INDEX `fk_datos_domicilio_usuario1_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_datos_domicilio_cat_estado1`
    FOREIGN KEY (`id_cat_estado`)
    REFERENCES `cat_estado` (`id_cat_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_domicilio_cat_municipio1`
    FOREIGN KEY (`id_cat_municipio`)
    REFERENCES `cat_municipio` (`id_cat_municipio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_domicilio_cat_localidad1`
    FOREIGN KEY (`id_cat_localidad`)
    REFERENCES `cat_localidad` (`id_cat_localidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_domicilio_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_comite_ec`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_comite_ec` (
  `id_cat_comite_ec` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`id_cat_comite_ec`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `archivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `archivo` (
  `id_archivo` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(500) NOT NULL,
  `ruta_directorio` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  `tipo` ENUM('sistema', 'url') NOT NULL DEFAULT 'sistema',
  PRIMARY KEY (`id_archivo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estandar_competencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estandar_competencia` (
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'tabla para el estandar de competencias, esta información sale del conocer.gob.mx\n1. https://conocer.gob.mx/renec-registro-nacional-de-estandares-de-competencia-por-sector-productivo/\n2. https://conocer.gob.mx/renec-registro-nacional-estandares-competencia/',
  `codigo` VARCHAR(45) NOT NULL,
  `nivel` SMALLINT(2) NULL,
  `titulo` VARCHAR(1000) NOT NULL,
  `calificacion_juicio` DECIMAL(5,2) NOT NULL,
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `id_cat_sector_ec` SMALLINT(3) UNSIGNED NULL,
  `id_cat_comite_ec` INT(10) UNSIGNED NULL,
  `id_archivo` BIGINT(20) UNSIGNED NULL COMMENT 'Rerencia para el banner del estandar de competencia',
  PRIMARY KEY (`id_estandar_competencia`),
  INDEX `fk_estandar_competencia_cat_sector_ec1_idx` (`id_cat_sector_ec` ASC),
  INDEX `fk_estandar_competencia_cat_comite_ec1_idx` (`id_cat_comite_ec` ASC),
  INDEX `fk_estandar_competencia_archivo1_idx` (`id_archivo` ASC),
  CONSTRAINT `fk_estandar_competencia_cat_sector_ec1`
    FOREIGN KEY (`id_cat_sector_ec`)
    REFERENCES `cat_sector_ec` (`id_cat_sector_ec`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estandar_competencia_cat_comite_ec1`
    FOREIGN KEY (`id_cat_comite_ec`)
    REFERENCES `cat_comite_ec` (`id_cat_comite_ec`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estandar_competencia_archivo1`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_expediente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_expediente` (
  `id_cat_expediente` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(85) NOT NULL,
  PRIMARY KEY (`id_cat_expediente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `datos_expediente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `datos_expediente` (
  `id_datos_expediente` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_cat_expediente` SMALLINT(2) UNSIGNED NOT NULL,
  `id_archivo` BIGINT(20) UNSIGNED NOT NULL,
  `activo` ENUM('si', 'no') NOT NULL DEFAULT 'si',
  PRIMARY KEY (`id_datos_expediente`),
  INDEX `fk_datos_expediente_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_datos_expediente_cat_expediente1_idx` (`id_cat_expediente` ASC),
  INDEX `fk_datos_expediente_archivo1_idx` (`id_archivo` ASC),
  CONSTRAINT `fk_datos_expediente_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_expediente_cat_expediente1`
    FOREIGN KEY (`id_cat_expediente`)
    REFERENCES `cat_expediente` (`id_cat_expediente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_expediente_archivo1`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_instrumento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_instrumento` (
  `id_cat_instrumento` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(85) NOT NULL,
  PRIMARY KEY (`id_cat_instrumento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_perfil`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_perfil` (
  `id_cat_perfil` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL,
  `slug` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id_cat_perfil`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_permiso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_permiso` (
  `id_cat_permiso` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL,
  `slug` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id_cat_permiso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario_has_perfil`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario_has_perfil` (
  `id_usuario_has_perfil` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cat_perfil` SMALLINT(3) UNSIGNED NOT NULL,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  INDEX `fk_usuario_has_perfil_cat_perfil1_idx` (`id_cat_perfil` ASC),
  INDEX `fk_usuario_has_perfil_usuario1_idx` (`id_usuario` ASC),
  PRIMARY KEY (`id_usuario_has_perfil`),
  CONSTRAINT `fk_usuario_has_perfil_cat_perfil1`
    FOREIGN KEY (`id_cat_perfil`)
    REFERENCES `cat_perfil` (`id_cat_perfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_perfil_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_modulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_modulo` (
  `id_cat_modulo` SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL,
  `slug` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_cat_modulo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `perfil_has_permisos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `perfil_has_permisos` (
  `id_perfil_has_permisos` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cat_perfil` SMALLINT(3) UNSIGNED NOT NULL,
  `id_cat_modulo` SMALLINT(3) UNSIGNED NOT NULL,
  `id_cat_permiso` INT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_perfil_has_permisos`),
  INDEX `fk_perfil_has_permisos_cat_permiso1_idx` (`id_cat_permiso` ASC),
  INDEX `fk_perfil_has_permisos_cat_modulo1_idx` (`id_cat_modulo` ASC),
  INDEX `fk_perfil_has_permisos_cat_perfil1_idx` (`id_cat_perfil` ASC),
  CONSTRAINT `fk_perfil_has_permisos_cat_permiso1`
    FOREIGN KEY (`id_cat_permiso`)
    REFERENCES `cat_permiso` (`id_cat_permiso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_has_permisos_cat_modulo1`
    FOREIGN KEY (`id_cat_modulo`)
    REFERENCES `cat_modulo` (`id_cat_modulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_has_permisos_cat_perfil1`
    FOREIGN KEY (`id_cat_perfil`)
    REFERENCES `cat_perfil` (`id_cat_perfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estandar_competencia_instrumento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estandar_competencia_instrumento` (
  `id_estandar_competencia_instrumento` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  `id_cat_instrumento` INT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_estandar_competencia_instrumento`),
  INDEX `fk_estandar_competencia_instrumento_estandar_competencia1_idx` (`id_estandar_competencia` ASC),
  INDEX `fk_estandar_competencia_instrumento_cat_instrumento1_idx` (`id_cat_instrumento` ASC),
  CONSTRAINT `fk_estandar_competencia_instrumento_estandar_competencia1`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estandar_competencia_instrumento_cat_instrumento1`
    FOREIGN KEY (`id_cat_instrumento`)
    REFERENCES `cat_instrumento` (`id_cat_instrumento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_instrumento_has_actividad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_instrumento_has_actividad` (
  `id_ec_instrumento_has_actividad` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `actividad` VARCHAR(1000) NOT NULL,
  `instrucciones` TINYTEXT NULL,
  `id_estandar_competencia_instrumento` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_ec_instrumento_has_actividad`),
  INDEX `fk_ec_instrumento_has_actividad_estandar_competencia_instru_idx` (`id_estandar_competencia_instrumento` ASC),
  CONSTRAINT `fk_ec_instrumento_has_actividad_estandar_competencia_instrume1`
    FOREIGN KEY (`id_estandar_competencia_instrumento`)
    REFERENCES `estandar_competencia_instrumento` (`id_estandar_competencia_instrumento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_tipo_opciones_pregunta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_tipo_opciones_pregunta` (
  `id_cat_tipo_opciones_pregunta` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_cat_tipo_opciones_pregunta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_evaluacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_evaluacion` (
  `id_cat_evaluacion` SMALLINT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_cat_evaluacion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `evaluacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `evaluacion` (
  `id_evaluacion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_creacion` DATETIME NOT NULL,
  `fecha_actualizacion` DATETIME NULL,
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `titulo` VARCHAR(150) NULL,
  `tiempo` INT(5) NULL,
  `intentos` INT(2) NULL,
  `id_cat_evaluacion` SMALLINT(2) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_evaluacion`),
  INDEX `fk_evaluacion_cat_evaluacion1_idx` (`id_cat_evaluacion` ASC),
  CONSTRAINT `fk_evaluacion_cat_evaluacion1`
    FOREIGN KEY (`id_cat_evaluacion`)
    REFERENCES `cat_evaluacion` (`id_cat_evaluacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_pregunta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_pregunta` (
  `id_banco_pregunta` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta` TEXT NOT NULL,
  `id_cat_tipo_opciones_pregunta` INT(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_banco_pregunta`),
  INDEX `fk_banco_pregunta_cat_tipo_opciones_pregunta1_idx` (`id_cat_tipo_opciones_pregunta` ASC),
  CONSTRAINT `fk_banco_pregunta_cat_tipo_opciones_pregunta1`
    FOREIGN KEY (`id_cat_tipo_opciones_pregunta`)
    REFERENCES `cat_tipo_opciones_pregunta` (`id_cat_tipo_opciones_pregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `opcion_pregunta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `opcion_pregunta` (
  `id_opcion_pregunta` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(250) NOT NULL,
  `tipo_respuesta` ENUM('correcta', 'incorrecta') NOT NULL DEFAULT 'incorrecta',
  `consecutivo` SMALLINT(2) NULL,
  `orden_pregunta` SMALLINT(2) NULL,
  `pregunta_relacional` ENUM('izquierda', 'derecha') NULL,
  `id_banco_pregunta` INT(10) UNSIGNED NOT NULL,
  `id_archivo` BIGINT(20) UNSIGNED NULL,
  PRIMARY KEY (`id_opcion_pregunta`),
  INDEX `fk_opcion_pregunta_banco_pregunta1_idx` (`id_banco_pregunta` ASC),
  INDEX `fk_opcion_pregunta_archivo1_idx` (`id_archivo` ASC),
  CONSTRAINT `fk_opcion_pregunta_banco_pregunta1`
    FOREIGN KEY (`id_banco_pregunta`)
    REFERENCES `banco_pregunta` (`id_banco_pregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_opcion_pregunta_archivo1`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `evaluacion_has_preguntas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `evaluacion_has_preguntas` (
  `id_evaluacion_has_preguntas` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_evaluacion` INT(10) UNSIGNED NOT NULL,
  `id_banco_pregunta` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_evaluacion_has_preguntas`),
  INDEX `fk_evaluacion_has_preguntas_evaluacion1_idx` (`id_evaluacion` ASC),
  INDEX `fk_evaluacion_has_preguntas_banco_pregunta1_idx` (`id_banco_pregunta` ASC),
  CONSTRAINT `fk_evaluacion_has_preguntas_evaluacion1`
    FOREIGN KEY (`id_evaluacion`)
    REFERENCES `evaluacion` (`id_evaluacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluacion_has_preguntas_banco_pregunta1`
    FOREIGN KEY (`id_banco_pregunta`)
    REFERENCES `banco_pregunta` (`id_banco_pregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estandar_competencia_has_evaluacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estandar_competencia_has_evaluacion` (
  `id_estandar_competencia_has_evaluacion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_evaluacion` INT(10) UNSIGNED NOT NULL,
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  `liberada` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `fecha_liberacion` DATETIME NULL,
  PRIMARY KEY (`id_estandar_competencia_has_evaluacion`),
  INDEX `fk_estandar_competencia_has_evaluacion_evaluacion1_idx` (`id_evaluacion` ASC),
  INDEX `fk_estandar_competencia_has_evaluacion_estandar_competencia_idx` (`id_estandar_competencia` ASC),
  CONSTRAINT `fk_estandar_competencia_has_evaluacion_evaluacion1`
    FOREIGN KEY (`id_evaluacion`)
    REFERENCES `evaluacion` (`id_evaluacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estandar_competencia_has_evaluacion_estandar_competencia1`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_instrumento_actividad_evaluacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_instrumento_actividad_evaluacion` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_evaluacion` INT(10) UNSIGNED NOT NULL,
  `id_ec_instrumento_has_actividad` INT(10) UNSIGNED NOT NULL,
  `liberada` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `fecha_liberacion` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ec_instrumento_actividad_evaluacion_evaluacion1_idx` (`id_evaluacion` ASC),
  INDEX `fk_ec_instrumento_actividad_evaluacion_ec_instrumento_has_a_idx` (`id_ec_instrumento_has_actividad` ASC),
  CONSTRAINT `fk_ec_instrumento_actividad_evaluacion_evaluacion1`
    FOREIGN KEY (`id_evaluacion`)
    REFERENCES `evaluacion` (`id_evaluacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_instrumento_actividad_evaluacion_ec_instrumento_has_act1`
    FOREIGN KEY (`id_ec_instrumento_has_actividad`)
    REFERENCES `ec_instrumento_has_actividad` (`id_ec_instrumento_has_actividad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario_has_evaluacion_realizada`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario_has_evaluacion_realizada` (
  `id_usuario_has_evaluacion_realizada` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_estandar_competencia` INT(10) UNSIGNED NULL,
  `id_estandar_competencia_has_evaluacion` INT(10) UNSIGNED NULL,
  `enviada` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `calificacion` DECIMAL(5,2) NULL,
  `fecha_iniciada` DATETIME NOT NULL,
  `fecha_enviada` DATETIME NULL,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `decision_candidato` ENUM('tomar_capacitacion', 'tomar_alineacion', 'tomar_proceso', 'otro') NOT NULL DEFAULT 'tomar_capacitacion',
  `descripcion_candidato_otro` VARCHAR(500) NULL,
  `id_ec_instrumento_actividad_evaluacion` INT(10) UNSIGNED NULL,
  PRIMARY KEY (`id_usuario_has_evaluacion_realizada`),
  INDEX `fk_estandar_competencia_has_evaluacion_estandar_competencia_idx` (`id_estandar_competencia` ASC),
  INDEX `fk_usuario_has_evaluacion_realizada_estandar_competencia_ha_idx` (`id_estandar_competencia_has_evaluacion` ASC),
  INDEX `fk_usuario_has_evaluacion_realizada_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_usuario_has_evaluacion_realizada_ec_instrumento_activida_idx` (`id_ec_instrumento_actividad_evaluacion` ASC),
  CONSTRAINT `fk_estandar_competencia_has_evaluacion_estandar_competencia10`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_evaluacion_realizada_estandar_competencia_has_1`
    FOREIGN KEY (`id_estandar_competencia_has_evaluacion`)
    REFERENCES `estandar_competencia_has_evaluacion` (`id_estandar_competencia_has_evaluacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_evaluacion_realizada_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_evaluacion_realizada_ec_instrumento_actividad_1`
    FOREIGN KEY (`id_ec_instrumento_actividad_evaluacion`)
    REFERENCES `ec_instrumento_actividad_evaluacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `evaluacion_respuestas_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `evaluacion_respuestas_usuario` (
  `id_evaluacion_respuestas_usuario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario_has_evaluacion_realizada` INT(10) UNSIGNED NOT NULL,
  `id_banco_pregunta` INT(10) UNSIGNED NULL,
  `id_opcion_respuesta` INT(10) UNSIGNED NULL,
  `orden_relacion_respuesta` INT(2) NULL,
  PRIMARY KEY (`id_evaluacion_respuestas_usuario`),
  INDEX `fk_evaluacion_respuestas_usuario_banco_pregunta1_idx` (`id_banco_pregunta` ASC),
  INDEX `fk_evaluacion_respuestas_usuario_opcion_pregunta1_idx` (`id_opcion_respuesta` ASC),
  INDEX `fk_evaluacion_respuestas_usuario_usuario_has_evaluacion_rea_idx` (`id_usuario_has_evaluacion_realizada` ASC),
  CONSTRAINT `fk_evaluacion_respuestas_usuario_banco_pregunta1`
    FOREIGN KEY (`id_banco_pregunta`)
    REFERENCES `banco_pregunta` (`id_banco_pregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluacion_respuestas_usuario_opcion_pregunta1`
    FOREIGN KEY (`id_opcion_respuesta`)
    REFERENCES `opcion_pregunta` (`id_opcion_pregunta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evaluacion_respuestas_usuario_usuario_has_evaluacion_reali1`
    FOREIGN KEY (`id_usuario_has_evaluacion_realizada`)
    REFERENCES `usuario_has_evaluacion_realizada` (`id_usuario_has_evaluacion_realizada`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estandar_competencia_convocatoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estandar_competencia_convocatoria` (
  `id_estandar_competencia_convocatoria` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  `titulo` VARCHAR(250) NOT NULL,
  `programacion_inicio` DATE NOT NULL,
  `programacion_fin` DATE NOT NULL,
  `alineacion_inicio` DATE NOT NULL,
  `alineacion_fin` DATE NOT NULL,
  `evaluacion_inicio` DATE NOT NULL,
  `evaluacion_fin` DATE NOT NULL,
  `certificado_inicio` DATE NOT NULL,
  `certificado_fin` DATE NOT NULL,
  `proposito` TEXT NULL,
  `descripcion` TEXT NULL,
  `id_cat_sector_ec` SMALLINT(3) UNSIGNED NOT NULL,
  `sector_descripcion` TEXT NULL,
  `perfil` TEXT NULL,
  `duracion_descripcion` TEXT NULL,
  `costo_alineacion` DECIMAL(8,2) NULL,
  `costo_evaluacion` DECIMAL(8,2) NULL,
  `costo_certificado` DECIMAL(8,2) NULL,
  `costo` DECIMAL(8,2) NULL,
  `publicada` ENUM('si', 'no') NOT NULL,
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `id_usuario` INT(10) UNSIGNED NULL COMMENT 'Llave foranea para hacer relación cuando la convocatoria es dada de alta por un evaluador',
  PRIMARY KEY (`id_estandar_competencia_convocatoria`),
  INDEX `fk_estandar_competencia_convocatoria_estandar_competencia1_idx` (`id_estandar_competencia` ASC),
  INDEX `fk_estandar_competencia_convocatoria_cat_sector_ec1_idx` (`id_cat_sector_ec` ASC),
  INDEX `fk_estandar_competencia_convocatoria_usuario1_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_estandar_competencia_convocatoria_estandar_competencia1`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estandar_competencia_convocatoria_cat_sector_ec1`
    FOREIGN KEY (`id_cat_sector_ec`)
    REFERENCES `cat_sector_ec` (`id_cat_sector_ec`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estandar_competencia_convocatoria_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario_has_estandar_competencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario_has_estandar_competencia` (
  `id_usuario_has_estandar_competencia` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  `id_usuario` INT(10) UNSIGNED NOT NULL COMMENT 'es la referencia de que se asigno un usuario al estandar de competencia (puede ser candidato o instructor)',
  `id_usuario_evaluador` INT(10) UNSIGNED NULL COMMENT 'es el usuario instructor que va a tener asignado a un candidato',
  `id_archivo_ped` BIGINT(20) UNSIGNED NULL,
  `fecha_registro` DATE NULL,
  `fecha_evidencia_ati` DATETIME NULL,
  `lugar_presentacion_resultados` ENUM('civika', 'otro') NULL,
  `descripcion_presentacion_resultados` VARCHAR(500) NULL,
  `fecha_presentacion_resultados` DATETIME NULL,
  `mejores_practicas` TINYTEXT NULL,
  `areas_oportunidad` TINYTEXT NULL,
  `criterio_no_cubiertos` TINYTEXT NULL,
  `recomendaciones` TINYTEXT NULL,
  `jucio_evaluacion` ENUM('competente', 'no_competente') NULL,
  `observaciones_candidato` TINYTEXT NULL,
  `carta_compromiso` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `intentos_adicionales` INT(2) NOT NULL DEFAULT 0,
  `id_estandar_competencia_convocatoria` INT(10) UNSIGNED NULL,
  PRIMARY KEY (`id_usuario_has_estandar_competencia`),
  INDEX `fk_usuario_has_estandar_competencia_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_usuario_has_estandar_competencia_estandar_competencia1_idx` (`id_estandar_competencia` ASC),
  INDEX `fk_usuario_has_estandar_competencia_usuario2_idx` (`id_usuario_evaluador` ASC),
  INDEX `fk_usuario_has_estandar_competencia_archivo1_idx` (`id_archivo_ped` ASC),
  INDEX `fk_usuario_has_estandar_competencia_estandar_competencia_co_idx` (`id_estandar_competencia_convocatoria` ASC),
  CONSTRAINT `fk_usuario_has_estandar_competencia_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_estandar_competencia_estandar_competencia1`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_estandar_competencia_usuario2`
    FOREIGN KEY (`id_usuario_evaluador`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_estandar_competencia_archivo1`
    FOREIGN KEY (`id_archivo_ped`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_estandar_competencia_estandar_competencia_conv1`
    FOREIGN KEY (`id_estandar_competencia_convocatoria`)
    REFERENCES `estandar_competencia_convocatoria` (`id_estandar_competencia_convocatoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_proceso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_proceso` (
  `id_cat_proceso` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_cat_proceso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_instrumento_alumno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_instrumento_alumno` (
  `id_ec_instrumento_alumno` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_ec_instrumento_has_actividad` INT(10) UNSIGNED NOT NULL,
  `id_cat_proceso` INT(3) UNSIGNED NOT NULL,
  `calificacion` DECIMAL(5,2) NULL,
  `fecha_carga_archivo` DATETIME NULL,
  `intentos_adicionales` INT(2) NULL COMMENT 'para guardar los intentos adicionales del candidato para realizar su evaluacion del instrumento',
  PRIMARY KEY (`id_ec_instrumento_alumno`),
  INDEX `fk_ec_instrumento_alumno_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_ec_instrumento_alumno_ec_instrumento_has_actividad1_idx` (`id_ec_instrumento_has_actividad` ASC),
  INDEX `fk_ec_instrumento_alumno_cat_proceso1_idx` (`id_cat_proceso` ASC),
  CONSTRAINT `fk_ec_instrumento_alumno_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_instrumento_alumno_ec_instrumento_has_actividad1`
    FOREIGN KEY (`id_ec_instrumento_has_actividad`)
    REFERENCES `ec_instrumento_has_actividad` (`id_ec_instrumento_has_actividad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_instrumento_alumno_cat_proceso1`
    FOREIGN KEY (`id_cat_proceso`)
    REFERENCES `cat_proceso` (`id_cat_proceso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_instrumento_alumno_has_comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_instrumento_alumno_has_comentario` (
  `id_ec_instrumento_alumno_has_comentario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comentario` TEXT NULL,
  `fecha` DATETIME NULL,
  `quien` ENUM('instructor', 'alumno') NOT NULL DEFAULT 'instructor',
  `id_ec_instrumento_alumno` BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_ec_instrumento_alumno_has_comentario`),
  INDEX `fk_ec_instrumento_alumno_has_comentario_ec_instrumento_alum_idx` (`id_ec_instrumento_alumno` ASC),
  CONSTRAINT `fk_ec_instrumento_alumno_has_comentario_ec_instrumento_alumno1`
    FOREIGN KEY (`id_ec_instrumento_alumno`)
    REFERENCES `ec_instrumento_alumno` (`id_ec_instrumento_alumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `notificacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `notificacion` (
  `id_notificacion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `asunto` VARCHAR(1000) NOT NULL,
  `mensaje` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id_notificacion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario_has_notificacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario_has_notificacion` (
  `id_usuario_has_notificacion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha_leida` DATETIME NULL,
  `id_notificacion` INT(10) UNSIGNED NOT NULL,
  `id_usuario_envia` INT(10) UNSIGNED NULL,
  `id_usuario_recibe` INT(10) UNSIGNED NULL,
  `estado` ENUM('enviada', 'borrador', 'eliminada_usr', 'eliminada_def') NOT NULL DEFAULT 'borrador',
  PRIMARY KEY (`id_usuario_has_notificacion`),
  INDEX `fk_usuario_has_notificacion_notificacion1_idx` (`id_notificacion` ASC),
  INDEX `fk_usuario_has_notificacion_usuario1_idx` (`id_usuario_envia` ASC),
  INDEX `fk_usuario_has_notificacion_usuario2_idx` (`id_usuario_recibe` ASC),
  CONSTRAINT `fk_usuario_has_notificacion_notificacion1`
    FOREIGN KEY (`id_notificacion`)
    REFERENCES `notificacion` (`id_notificacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_notificacion_usuario1`
    FOREIGN KEY (`id_usuario_envia`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_notificacion_usuario2`
    FOREIGN KEY (`id_usuario_recibe`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `notificacion_has_archivos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `notificacion_has_archivos` (
  `id_notificacion_has_archivos` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_notificacion` INT(10) UNSIGNED NOT NULL,
  `id_archivo` BIGINT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_notificacion_has_archivos`),
  INDEX `fk_notificacion_has_archivos_notificacion1_idx` (`id_notificacion` ASC),
  INDEX `fk_notificacion_has_archivo_archivo_idx` (`id_archivo` ASC),
  CONSTRAINT `fk_notificacion_has_archivos_notificacion1`
    FOREIGN KEY (`id_notificacion`)
    REFERENCES `notificacion` (`id_notificacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notificacion_has_archivo_archivo`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_expediente_ped`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_expediente_ped` (
  `id_cat_expediente_ped` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id_cat_expediente_ped`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_usuario_has_expediente_ped`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_usuario_has_expediente_ped` (
  `id_ec_usuario_has_expediente_ped` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_archivo` BIGINT(20) UNSIGNED NOT NULL,
  `id_cat_expediente_ped` INT(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_ec_usuario_has_expediente_ped`),
  INDEX `fk_ec_usuario_has_expediente_ped_estandar_competencia1_idx` (`id_estandar_competencia` ASC),
  INDEX `fk_ec_usuario_has_expediente_ped_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_ec_usuario_has_expediente_ped_archivo1_idx` (`id_archivo` ASC),
  INDEX `fk_ec_usuario_has_expediente_ped_cat_expediente_ped1_idx` (`id_cat_expediente_ped` ASC),
  CONSTRAINT `fk_ec_usuario_has_expediente_ped_estandar_competencia1`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_usuario_has_expediente_ped_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_usuario_has_expediente_ped_archivo1`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_usuario_has_expediente_ped_cat_expediente_ped1`
    FOREIGN KEY (`id_cat_expediente_ped`)
    REFERENCES `cat_expediente_ped` (`id_cat_expediente_ped`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estandar_competencia_has_requerimientos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estandar_competencia_has_requerimientos` (
  `id_estandar_competencia_has_requerimientos` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cantidad` INT(5) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_estandar_competencia_has_requerimientos`),
  INDEX `fk_estandar_competencia_has_requerimientos_estandar_compete_idx` (`id_estandar_competencia` ASC),
  CONSTRAINT `fk_estandar_competencia_has_requerimientos_estandar_competenc1`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_preguntas_encuesta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_preguntas_encuesta` (
  `id_cat_preguntas_encuesta` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta` VARCHAR(750) NOT NULL,
  `eliminado` ENUM('no', 'si') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id_cat_preguntas_encuesta`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario_has_encuesta_satisfaccion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario_has_encuesta_satisfaccion` (
  `id_usuario_has_encuesta_satisfaccion` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario_has_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  `fecha_envio` DATETIME NOT NULL,
  `observaciones` TINYTEXT NOT NULL,
  PRIMARY KEY (`id_usuario_has_encuesta_satisfaccion`),
  INDEX `fk_usuario_has_encuesta_satisfaccion_usuario_has_estandar_c_idx` (`id_usuario_has_estandar_competencia` ASC),
  CONSTRAINT `fk_usuario_has_encuesta_satisfaccion_usuario_has_estandar_com1`
    FOREIGN KEY (`id_usuario_has_estandar_competencia`)
    REFERENCES `usuario_has_estandar_competencia` (`id_usuario_has_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario_has_respuesta_encuesta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario_has_respuesta_encuesta` (
  `id_usuario_has_respuesta_encuesta` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cat_preguntas_encuesta` INT(3) UNSIGNED NOT NULL,
  `id_usuario_has_encuesta_satisfaccion` INT UNSIGNED NOT NULL,
  `respuesta` INT(1) NOT NULL,
  PRIMARY KEY (`id_usuario_has_respuesta_encuesta`),
  INDEX `fk_usuario_has_encuesta_satisfacion_cat_preguntas_encuesta1_idx` (`id_cat_preguntas_encuesta` ASC),
  INDEX `fk_usuario_has_respuesta_encuesta_usuario_has_encuesta_sati_idx` (`id_usuario_has_encuesta_satisfaccion` ASC),
  CONSTRAINT `fk_usuario_has_encuesta_satisfacion_cat_preguntas_encuesta1`
    FOREIGN KEY (`id_cat_preguntas_encuesta`)
    REFERENCES `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_respuesta_encuesta_usuario_has_encuesta_satisf1`
    FOREIGN KEY (`id_usuario_has_encuesta_satisfaccion`)
    REFERENCES `usuario_has_encuesta_satisfaccion` (`id_usuario_has_encuesta_satisfaccion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cat_msg_bienvenida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cat_msg_bienvenida` (
  `id_cat_msg_bienvenida` INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NOT NULL,
  PRIMARY KEY (`id_cat_msg_bienvenida`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_instrumento_actividad_has_archivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_instrumento_actividad_has_archivo` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_ec_instrumento_has_actividad` INT(10) UNSIGNED NOT NULL,
  `id_archivo` BIGINT(20) UNSIGNED NULL,
  `url_video` VARCHAR(2000) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ec_instrumento_actividad_has_archivo_ec_instrumento_has__idx` (`id_ec_instrumento_has_actividad` ASC),
  INDEX `fk_ec_instrumento_actividad_has_archivo_archivo1_idx` (`id_archivo` ASC),
  CONSTRAINT `fk_ec_instrumento_actividad_has_archivo_ec_instrumento_has_ac1`
    FOREIGN KEY (`id_ec_instrumento_has_actividad`)
    REFERENCES `ec_instrumento_has_actividad` (`id_ec_instrumento_has_actividad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_instrumento_actividad_has_archivo_archivo1`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `archivo_instrumento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `archivo_instrumento` (
  `id_archivo_instrumento` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(500) NOT NULL,
  `ruta_directorio` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id_archivo_instrumento`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_instrumento_alumno_evidencias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_instrumento_alumno_evidencias` (
  `id_ec_instrumento_alumno_evidencias` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_ec_instrumento_alumno` BIGINT(20) UNSIGNED NOT NULL,
  `id_archivo_instrumento` BIGINT(20) UNSIGNED NULL,
  `url_video` TEXT NULL,
  PRIMARY KEY (`id_ec_instrumento_alumno_evidencias`),
  INDEX `fk_ec_instrumento_alumno_evidencias_ec_instrumento_alumno1_idx` (`id_ec_instrumento_alumno` ASC),
  INDEX `fk_ec_instrumento_alumno_evidencias_archivo_instrumento1_idx` (`id_archivo_instrumento` ASC),
  CONSTRAINT `fk_ec_instrumento_alumno_evidencias_ec_instrumento_alumno1`
    FOREIGN KEY (`id_ec_instrumento_alumno`)
    REFERENCES `ec_instrumento_alumno` (`id_ec_instrumento_alumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_instrumento_alumno_evidencias_archivo_instrumento1`
    FOREIGN KEY (`id_archivo_instrumento`)
    REFERENCES `archivo_instrumento` (`id_archivo_instrumento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario_has_ec_progreso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario_has_ec_progreso` (
  `id_usuario_has_ec_progreso` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario_has_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  `numero_paso` INT(2) NOT NULL DEFAULT 1,
  `fecha` DATETIME NULL,
  PRIMARY KEY (`id_usuario_has_ec_progreso`),
  INDEX `fk_usuario_has_ec_progreso_usuario_has_estandar_competencia_idx` (`id_usuario_has_estandar_competencia` ASC),
  CONSTRAINT `fk_usuario_has_ec_progreso_usuario_has_estandar_competencia1`
    FOREIGN KEY (`id_usuario_has_estandar_competencia`)
    REFERENCES `usuario_has_estandar_competencia` (`id_usuario_has_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `config_correo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `config_correo` (
  `id_config_correo` INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `smtp_secure` VARCHAR(45) NOT NULL,
  `host` VARCHAR(250) NOT NULL,
  `port` VARCHAR(6) NOT NULL,
  `usuario` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `name` VARCHAR(45) NULL,
  `activo` ENUM('si', 'no') NOT NULL DEFAULT 'si',
  PRIMARY KEY (`id_config_correo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `datos_empresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `datos_empresa` (
  `id_datos_empresa` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(500) NOT NULL,
  `rfc` VARCHAR(15) NOT NULL,
  `domicilio_fiscal` VARCHAR(500) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  `representante_legal` VARCHAR(250) NOT NULL,
  `representante_trabajadores` VARCHAR(250) NOT NULL,
  `vigente` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_archivo_logotipo` BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_datos_empresa`),
  INDEX `fk_datos_empresa_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_datos_empresa_archivo1_idx` (`id_archivo_logotipo` ASC),
  CONSTRAINT `fk_datos_empresa_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_datos_empresa_archivo1`
    FOREIGN KEY (`id_archivo_logotipo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entregable_ec`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `entregable_ec` (
  `id_entregable` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(100) NOT NULL,
  `instrucciones` TEXT NOT NULL,
  `tipo_entregable` VARCHAR(45) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `liberado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_entregable`),
  INDEX `fk_entregable_ec_estandar_competencia1_idx` (`id_estandar_competencia` ASC),
  CONSTRAINT `fk_entregable_ec_estandar_competencia1`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entregable_has_archivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `entregable_has_archivo` (
  `id_entregable_archivo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entregable` INT(10) UNSIGNED NOT NULL,
  `id_archivo` BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_entregable_archivo`),
  INDEX `fk_entregable_has_archivo_entregable_ec1_idx` (`id_entregable` ASC),
  INDEX `fk_entregable_has_archivo_archivo1_idx` (`id_archivo` ASC),
  CONSTRAINT `fk_entregable_has_archivo_entregable_ec1`
    FOREIGN KEY (`id_entregable`)
    REFERENCES `entregable_ec` (`id_entregable`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entregable_has_archivo_archivo1`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entregable_has_instrumento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `entregable_has_instrumento` (
  `id_entregable_instrumento` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entregable` INT(10) UNSIGNED NOT NULL,
  `id_ec_instrumento_has_actividad` INT(10) UNSIGNED NOT NULL,
  `liberado` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_entregable_instrumento`),
  INDEX `fk_entregable_has_instrumento_entregable_ec1_idx` (`id_entregable` ASC),
  INDEX `fk_entregable_has_instrumento_ec_instrumento_has_actividad1_idx` (`id_ec_instrumento_has_actividad` ASC),
  CONSTRAINT `fk_entregable_has_instrumento_entregable_ec1`
    FOREIGN KEY (`id_entregable`)
    REFERENCES `entregable_ec` (`id_entregable`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entregable_has_instrumento_ec_instrumento_has_actividad1`
    FOREIGN KEY (`id_ec_instrumento_has_actividad`)
    REFERENCES `ec_instrumento_has_actividad` (`id_ec_instrumento_has_actividad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_entregable_alumno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_entregable_alumno` (
  `id_entregable_alumno` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_entregable` INT(10) UNSIGNED NOT NULL,
  `id_cat_proceso` INT(3) UNSIGNED NOT NULL,
  `calificacion` DECIMAL(5,2) NULL,
  `fecha_carga_archivo` DATETIME NULL,
  `intentos_adicionales` INT NULL,
  PRIMARY KEY (`id_entregable_alumno`),
  INDEX `fk_ec_entregable_alumno_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_ec_entregable_alumno_entregable_ec1_idx` (`id_entregable` ASC),
  INDEX `fk_ec_entregable_alumno_cat_proceso1_idx` (`id_cat_proceso` ASC),
  CONSTRAINT `fk_ec_entregable_alumno_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_entregable_alumno_entregable_ec1`
    FOREIGN KEY (`id_entregable`)
    REFERENCES `entregable_ec` (`id_entregable`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_entregable_alumno_cat_proceso1`
    FOREIGN KEY (`id_cat_proceso`)
    REFERENCES `cat_proceso` (`id_cat_proceso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entregable_alumno_comentarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `entregable_alumno_comentarios` (
  `id_entregable_alumno_comentario` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comentario` VARCHAR(100) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `quien` ENUM('instructor', 'alumno') NOT NULL,
  `id_entregable_alumno` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_entregable_alumno_comentario`),
  INDEX `fk_entregable_alumno_comentarios_ec_entregable_alumno1_idx` (`id_entregable_alumno` ASC),
  CONSTRAINT `fk_entregable_alumno_comentarios_ec_entregable_alumno1`
    FOREIGN KEY (`id_entregable_alumno`)
    REFERENCES `ec_entregable_alumno` (`id_entregable_alumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entregable_alumno_archivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `entregable_alumno_archivo` (
  `id_entregable_alumno_archivo` BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entregable_alumno` INT(10) UNSIGNED NOT NULL,
  `id_archivo_instrumento` BIGINT(20) UNSIGNED NOT NULL,
  `url_video` TEXT NULL,
  PRIMARY KEY (`id_entregable_alumno_archivo`),
  INDEX `fk_entregable_alumno_archivo_ec_entregable_alumno1_idx` (`id_entregable_alumno` ASC),
  INDEX `fk_entregable_alumno_archivo_archivo_instrumento1_idx` (`id_archivo_instrumento` ASC),
  CONSTRAINT `fk_entregable_alumno_archivo_ec_entregable_alumno1`
    FOREIGN KEY (`id_entregable_alumno`)
    REFERENCES `ec_entregable_alumno` (`id_entregable_alumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entregable_alumno_archivo_archivo_instrumento1`
    FOREIGN KEY (`id_archivo_instrumento`)
    REFERENCES `archivo_instrumento` (`id_archivo_instrumento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `formulario_abierto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `formulario_abierto` (
  `id_formulario_abierto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_formulario` VARCHAR(45) NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_formulario_abierto`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pregunta_formulario_abierto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pregunta_formulario_abierto` (
  `id_cat_pregunta_formulario_abierto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta_formulario_abierto` VARCHAR(750) NOT NULL,
  `id_formulario_abierto` INT(10) UNSIGNED NOT NULL,
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `liberada` ENUM('si', 'no') NULL DEFAULT 'no',
  PRIMARY KEY (`id_cat_pregunta_formulario_abierto`),
  INDEX `fk_pregunta_formulario_abierto_formulario_abierto1_idx` (`id_formulario_abierto` ASC),
  CONSTRAINT `fk_pregunta_formulario_abierto_formulario_abierto1`
    FOREIGN KEY (`id_formulario_abierto`)
    REFERENCES `formulario_abierto` (`id_formulario_abierto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entregable_has_formulario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `entregable_has_formulario` (
  `id_entregable_formulario` BIGINT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entregable` INT(10) UNSIGNED NOT NULL,
  `id_formulario_abierto` INT(10) UNSIGNED NOT NULL,
  `liberado` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_entregable_formulario`),
  INDEX `fk_entregable_has_formulario_entregable_ec1_idx` (`id_entregable` ASC),
  INDEX `fk_entregable_has_formulario_formulario_abierto1_idx` (`id_formulario_abierto` ASC),
  CONSTRAINT `fk_entregable_has_formulario_entregable_ec1`
    FOREIGN KEY (`id_entregable`)
    REFERENCES `entregable_ec` (`id_entregable`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entregable_has_formulario_formulario_abierto1`
    FOREIGN KEY (`id_formulario_abierto`)
    REFERENCES `formulario_abierto` (`id_formulario_abierto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entregable_formulario_has_alumno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `entregable_formulario_has_alumno` (
  `id_entregable_formulario_has_alumno` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entregable_formulario` BIGINT(20) UNSIGNED NOT NULL,
  `id_usuario` INT(10) UNSIGNED NOT NULL,
  `id_cat_proceso` INT(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_entregable_formulario_has_alumno`),
  INDEX `fk_entregable_formulario_has_alumno_entregable_has_formular_idx` (`id_entregable_formulario` ASC),
  INDEX `fk_entregable_formulario_has_alumno_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_entregable_formulario_has_alumno_cat_proceso1_idx` (`id_cat_proceso` ASC),
  CONSTRAINT `fk_entregable_formulario_has_alumno_entregable_has_formulario1`
    FOREIGN KEY (`id_entregable_formulario`)
    REFERENCES `entregable_has_formulario` (`id_entregable_formulario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entregable_formulario_has_alumno_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entregable_formulario_has_alumno_cat_proceso1`
    FOREIGN KEY (`id_cat_proceso`)
    REFERENCES `cat_proceso` (`id_cat_proceso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `respuesta_pregunta_formulario_abierto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `respuesta_pregunta_formulario_abierto` (
  `id_respuesta_pregunta_formulario_abierto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `respuesta_pregunta_formulario_abierto` TEXT NOT NULL,
  `id_cat_pregunta_formulario_abierto` INT(10) UNSIGNED NOT NULL,
  `id_entregable_formulario_alumno` BIGINT(20) UNSIGNED NOT NULL,
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id_respuesta_pregunta_formulario_abierto`),
  INDEX `fk_respuesta_pregunta_formulario_abierto_pregunta_formulari_idx` (`id_cat_pregunta_formulario_abierto` ASC),
  INDEX `fk_respuesta_pregunta_formulario_abierto_entregable_formula_idx` (`id_entregable_formulario_alumno` ASC),
  CONSTRAINT `fk_respuesta_pregunta_formulario_abierto_pregunta_formulario_1`
    FOREIGN KEY (`id_cat_pregunta_formulario_abierto`)
    REFERENCES `pregunta_formulario_abierto` (`id_cat_pregunta_formulario_abierto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_pregunta_formulario_abierto_entregable_formulari1`
    FOREIGN KEY (`id_entregable_formulario_alumno`)
    REFERENCES `entregable_formulario_has_alumno` (`id_entregable_formulario_has_alumno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `entregable_has_evaluacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `entregable_has_evaluacion` (
  `id_entregable_has_evaluacion` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entregable` INT(10) UNSIGNED NOT NULL,
  `id_evaluacion` INT(10) UNSIGNED NOT NULL,
  `liberada` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `fecha_liberacion` DATETIME NOT NULL,
  PRIMARY KEY (`id_entregable_has_evaluacion`),
  INDEX `fk_entregable_has_evaluacion_entregable_ec1_idx` (`id_entregable` ASC),
  INDEX `fk_entregable_has_evaluacion_evaluacion1_idx` (`id_evaluacion` ASC),
  CONSTRAINT `fk_entregable_has_evaluacion_entregable_ec1`
    FOREIGN KEY (`id_entregable`)
    REFERENCES `entregable_ec` (`id_entregable`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entregable_has_evaluacion_evaluacion1`
    FOREIGN KEY (`id_evaluacion`)
    REFERENCES `evaluacion` (`id_evaluacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_curso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_curso` (
  `id_ec_curso` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_curso` VARCHAR(45) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `que_aprenderas` TEXT NOT NULL,
  `id_archivo` BIGINT(20) UNSIGNED NOT NULL,
  `publicado` ENUM('no', 'si') NOT NULL DEFAULT 'no',
  `fecha_publicado` DATETIME NOT NULL,
  `eliminado` ENUM('no', 'si') NOT NULL,
  `id_estandar_competencia` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_ec_curso`),
  INDEX `fk_ec_curso_archivo1_idx` (`id_archivo` ASC),
  INDEX `fk_ec_curso_estandar_competencia1_idx` (`id_estandar_competencia` ASC),
  CONSTRAINT `fk_ec_curso_archivo1`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_curso_estandar_competencia1`
    FOREIGN KEY (`id_estandar_competencia`)
    REFERENCES `estandar_competencia` (`id_estandar_competencia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_curso_modulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_curso_modulo` (
  `id_ec_curso_modulo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` TEXT NOT NULL,
  `objetivo_general` TEXT NOT NULL,
  `objetivos_especificos` TEXT NOT NULL,
  `eliminado` ENUM('no', 'si') NOT NULL DEFAULT 'no',
  `id_evaluacion` INT(10) UNSIGNED NULL,
  `id_ec_curso` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_ec_curso_modulo`),
  INDEX `fk_ec_curso_modulo_evaluacion1_idx` (`id_evaluacion` ASC),
  INDEX `fk_ec_curso_modulo_ec_curso1_idx` (`id_ec_curso` ASC),
  CONSTRAINT `fk_ec_curso_modulo_evaluacion1`
    FOREIGN KEY (`id_evaluacion`)
    REFERENCES `evaluacion` (`id_evaluacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_curso_modulo_ec_curso1`
    FOREIGN KEY (`id_ec_curso`)
    REFERENCES `ec_curso` (`id_ec_curso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ec_curso_modulo_temario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ec_curso_modulo_temario` (
  `id_ec_curso_modulo_temario` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tema` VARCHAR(250) NOT NULL,
  `instrucciones` TEXT NOT NULL,
  `contenido_curso` TEXT NOT NULL,
  `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no',
  `id_archivo` BIGINT(20) UNSIGNED NOT NULL,
  `id_ec_curso_modulo` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_ec_curso_modulo_temario`),
  INDEX `fk_ec_curso_modulo_temario_archivo1_idx` (`id_archivo` ASC),
  INDEX `fk_ec_curso_modulo_temario_ec_curso_modulo1_idx` (`id_ec_curso_modulo` ASC),
  CONSTRAINT `fk_ec_curso_modulo_temario_archivo1`
    FOREIGN KEY (`id_archivo`)
    REFERENCES `archivo` (`id_archivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ec_curso_modulo_temario_ec_curso_modulo1`
    FOREIGN KEY (`id_ec_curso_modulo`)
    REFERENCES `ec_curso_modulo` (`id_ec_curso_modulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`, `activo`, `eliminado`, `perfil`, `password_temp`) VALUES (1, 'jl_salazar', '316f00d66c019640cb2d632e1ac28b39da579779', 'si', DEFAULT, 'root', NULL);
INSERT INTO `usuario` (`id_usuario`, `usuario`, `password`, `activo`, `eliminado`, `perfil`, `password_temp`) VALUES (2, 'ecoronar', '316f00d66c019640cb2d632e1ac28b39da579779', 'si', DEFAULT, 'root', NULL);




-- -----------------------------------------------------
-- Data for table `cat_nivel_academico`
-- -----------------------------------------------------

INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (1, 'Primaria');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (2, 'Secundaria');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (3, 'Bachillerato');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (4, 'Estudios Técnicos');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (5, 'Licenciatura');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (6, 'Maestría');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (7, 'Doctorado');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (8, 'Posgrado');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (9, 'Concluidos');
INSERT INTO `cat_nivel_academico` (`id_cat_nivel_academico`, `nombre`) VALUES (10, 'Truncos');




-- -----------------------------------------------------
-- Data for table `cat_sector_ec`
-- -----------------------------------------------------

INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (1, 'Administración Pública', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (2, 'Agrícola y Pecuario', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (3, 'Agua', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (4, 'Automotriz', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (5, 'Comercio', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (7, 'Construcción', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (8, 'Cultural', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (9, 'Deportivo', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (10, 'Educación y Formación de Personas', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (11, 'Energía eléctrica', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (12, 'Financiero', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (13, 'Funciones del Sistema Nacional de Competencias', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (14, 'Laboral', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (15, 'Logística', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (17, 'Máquilas y Manufactura', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (16, 'Minería', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (18, 'Petróleo y Gas', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (19, 'Prendas de Vestir, Textil, Cuero y Calzado', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (20, 'Procesamiento de alimentos', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (21, 'Químico', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (22, 'Seguridad Nacional', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (23, 'Seguridad Pública', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (24, 'Servicios Profesionales y Técnicos', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (25, 'Social', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (26, 'Sociedades Cooperativas', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (27, 'Tecnologías de la Información', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (28, 'Transporte ', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (29, 'Turismo ', 1);
INSERT INTO `cat_sector_ec` (`id_cat_sector_ec`, `nombre`, `activo`) VALUES (6, 'Comercio exterior', 1);




-- -----------------------------------------------------
-- Data for table `cat_expediente`
-- -----------------------------------------------------

INSERT INTO `cat_expediente` (`id_cat_expediente`, `nombre`) VALUES (1, 'Foto de perfil');
INSERT INTO `cat_expediente` (`id_cat_expediente`, `nombre`) VALUES (2, 'Foto de certificados');
INSERT INTO `cat_expediente` (`id_cat_expediente`, `nombre`) VALUES (3, 'INE anverso');
INSERT INTO `cat_expediente` (`id_cat_expediente`, `nombre`) VALUES (4, 'INE reverso');
INSERT INTO `cat_expediente` (`id_cat_expediente`, `nombre`) VALUES (5, 'Cédula profesional anverso');
INSERT INTO `cat_expediente` (`id_cat_expediente`, `nombre`) VALUES (6, 'Cédula profesional reverso');
INSERT INTO `cat_expediente` (`id_cat_expediente`, `nombre`) VALUES (7, 'CURP');
INSERT INTO `cat_expediente` (`id_cat_expediente`, `nombre`) VALUES (8, 'Firma digital');




-- -----------------------------------------------------
-- Data for table `cat_instrumento`
-- -----------------------------------------------------

INSERT INTO `cat_instrumento` (`id_cat_instrumento`, `nombre`) VALUES (1, 'Guía de observación');
INSERT INTO `cat_instrumento` (`id_cat_instrumento`, `nombre`) VALUES (2, 'Lista de cotejo');
INSERT INTO `cat_instrumento` (`id_cat_instrumento`, `nombre`) VALUES (3, 'Cuestionario');




-- -----------------------------------------------------
-- Data for table `cat_perfil`
-- -----------------------------------------------------

INSERT INTO `cat_perfil` (`id_cat_perfil`, `nombre`, `slug`) VALUES (1, 'Super administrador', 'root');
INSERT INTO `cat_perfil` (`id_cat_perfil`, `nombre`, `slug`) VALUES (2, 'Administrador', 'admin');
INSERT INTO `cat_perfil` (`id_cat_perfil`, `nombre`, `slug`) VALUES (3, 'Evaluador', 'instructor');
INSERT INTO `cat_perfil` (`id_cat_perfil`, `nombre`, `slug`) VALUES (4, 'Candidato/Alumno', 'alumno');




-- -----------------------------------------------------
-- Data for table `cat_permiso`
-- -----------------------------------------------------

INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (1, 'Todos', 'todos');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (2, 'Consultar registros', 'consultar');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (3, 'Agregar registro', 'agregar');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (4, 'Modificar registro', 'modificar');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (5, 'Eliminar registro', 'eliminar');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (6, 'Deseliminar registro', 'deseliminar');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (7, 'Activar registro', 'activar');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (8, 'Desactivar', 'desactivar');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (9, 'Usuarios administradores', 'admin');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (10, 'Usuarios evaluadores', 'instructor');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (11, 'Usuarios Candidatos/Alumnos', 'alumno');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (12, 'Actualizar contraseña', 'update_pass');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (13, 'Cerrar operación o Liberar', 'cerrar_liberar');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (14, 'Comentarios', 'comentario');
INSERT INTO `cat_permiso` (`id_cat_permiso`, `nombre`, `slug`) VALUES (15, 'Respuestas', 'respuesta');




-- -----------------------------------------------------
-- Data for table `usuario_has_perfil`
-- -----------------------------------------------------

INSERT INTO `usuario_has_perfil` (`id_usuario_has_perfil`, `id_cat_perfil`, `id_usuario`) VALUES (DEFAULT, 1, 1);
INSERT INTO `usuario_has_perfil` (`id_usuario_has_perfil`, `id_cat_perfil`, `id_usuario`) VALUES (DEFAULT, 1, 2);




-- -----------------------------------------------------
-- Data for table `cat_modulo`
-- -----------------------------------------------------

INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (1, 'Todos', 'todos');
INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (2, 'Usuarios', 'usuarios');
INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (3, 'Estándar de competencias', 'estandar_competencia');
INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (4, 'Ténicas e instrumentos', 'tecnicas_instrumentos');
INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (5, 'Evaluaciones', 'evaluacion');
INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (6, 'Perfiles y permisos', 'perfil_permiso');
INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (7, 'Catalogos', 'catalogos');
INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (8, 'Preguntas de evaluación', 'preguntas_evaluacion');
INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (9, 'Módulos de capacitación', 'ec_curso');




-- -----------------------------------------------------
-- Data for table `perfil_has_permisos`
-- -----------------------------------------------------

INSERT INTO `perfil_has_permisos` (`id_perfil_has_permisos`, `id_cat_perfil`, `id_cat_modulo`, `id_cat_permiso`) VALUES (1, 1, 1, 1);




-- -----------------------------------------------------
-- Data for table `cat_tipo_opciones_pregunta`
-- -----------------------------------------------------

INSERT INTO `cat_tipo_opciones_pregunta` (`id_cat_tipo_opciones_pregunta`, `nombre`) VALUES (1, 'Verdadero/falso');
INSERT INTO `cat_tipo_opciones_pregunta` (`id_cat_tipo_opciones_pregunta`, `nombre`) VALUES (2, 'Única opcion');
INSERT INTO `cat_tipo_opciones_pregunta` (`id_cat_tipo_opciones_pregunta`, `nombre`) VALUES (3, 'Opción multiple');
INSERT INTO `cat_tipo_opciones_pregunta` (`id_cat_tipo_opciones_pregunta`, `nombre`) VALUES (4, 'Imagenes (única opción)');
INSERT INTO `cat_tipo_opciones_pregunta` (`id_cat_tipo_opciones_pregunta`, `nombre`) VALUES (5, 'Imágenes (opción multiple)');
INSERT INTO `cat_tipo_opciones_pregunta` (`id_cat_tipo_opciones_pregunta`, `nombre`) VALUES (6, 'Secuenciales');
INSERT INTO `cat_tipo_opciones_pregunta` (`id_cat_tipo_opciones_pregunta`, `nombre`) VALUES (7, 'Relacionales');




-- -----------------------------------------------------
-- Data for table `cat_evaluacion`
-- -----------------------------------------------------

INSERT INTO `cat_evaluacion` (`id_cat_evaluacion`, `nombre`) VALUES (1, 'Diagnóstica');
INSERT INTO `cat_evaluacion` (`id_cat_evaluacion`, `nombre`) VALUES (2, 'Cuestionario de instrumento');
INSERT INTO `cat_evaluacion` (`id_cat_evaluacion`, `nombre`) VALUES (3, 'Entregable');
INSERT INTO `cat_evaluacion` (`id_cat_evaluacion`, `nombre`) VALUES (4, 'Módulo');




-- -----------------------------------------------------
-- Data for table `cat_proceso`
-- -----------------------------------------------------

INSERT INTO `cat_proceso` (`id_cat_proceso`, `nombre`) VALUES (1, 'En captura');
INSERT INTO `cat_proceso` (`id_cat_proceso`, `nombre`) VALUES (2, 'Enviada');
INSERT INTO `cat_proceso` (`id_cat_proceso`, `nombre`) VALUES (3, 'Observaciones');
INSERT INTO `cat_proceso` (`id_cat_proceso`, `nombre`) VALUES (4, 'Finalizada');




-- -----------------------------------------------------
-- Data for table `cat_expediente_ped`
-- -----------------------------------------------------

INSERT INTO `cat_expediente_ped` (`id_cat_expediente_ped`, `nombre`) VALUES (1, 'Ficha registro');
INSERT INTO `cat_expediente_ped` (`id_cat_expediente_ped`, `nombre`) VALUES (2, 'Instrumento de evaluación de competencia');
INSERT INTO `cat_expediente_ped` (`id_cat_expediente_ped`, `nombre`) VALUES (3, 'Certificado de competencia laboral en la EC');




-- -----------------------------------------------------
-- Data for table `cat_preguntas_encuesta`
-- -----------------------------------------------------

INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (1, '¿La presentación del Estándar de Competencia y la aplicación del diagnóstico, lo realizaron sin costo para usted?', 'no');
INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (2, '¿Le proporcionaron la información suficiente y necesaria para iniciar su proceso de evaluación?', 'no');
INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (3, '¿Durante el proceso de evaluación le dieron trato digno y respetuoso?', 'no');
INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (4, '¿Le realizaron la evaluación sin que la ECE/CE/EI/SEDE lo condicionarán a tomar un curso de capacitación?', 'no');
INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (5, '¿Le presentaron y acordaron con Usted el Plan de Evaluación?', 'no');
INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (6, '¿Recibió retroalimentación de los resultados de su evaluación?', 'no');
INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (7, '¿El evaluador atendió todas sus dudas?', 'no');
INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (8, '¿Le entregaron el certificado de acuerdo al compromiso establecido?', 'no');
INSERT INTO `cat_preguntas_encuesta` (`id_cat_preguntas_encuesta`, `pregunta`, `eliminado`) VALUES (9, '¿Cómo fue la calidad ofrecida de forma general del proceso de evaluacióncertificación, desde el inicio hasta el término?', 'no');




-- -----------------------------------------------------
-- Data for table `cat_msg_bienvenida`
-- -----------------------------------------------------

INSERT INTO `cat_msg_bienvenida` (`id_cat_msg_bienvenida`, `nombre`) VALUES (1, '¡Bienvenido a este proceso de capacitación remoto con fines de certificación!<br><br>Antes\n de comenzar debes tener presente que la estructura general de esta \nplataforma consistirá en 4 apartados sustanciales para el desarrollo de \ncada tema y/o elemento de competencia:<br><br>Capsula informativa. Se trata de una capsula pregrabada a través de la cual recibirás el curso de capacitación remoto.<br>Indicaciones.\n En este apartado podrás revisar de manera clara y objetiva los \nCRITERIOS NECESARIOS con los que deberá contar tu actividad sujeta a \nevaluación, también llamada evidencia.<br>Documento de apoyo. Estos \ndocumentos pueden ser simplemente un ejemplo o apoyo visual para el \ndesarrollo de tu evidencia o, incluso, se puede tratar de un formato \ndescargable que podrás requisitar para dar cumplimiento a la misma.<br>Carga\n de la actividad. Finalmente en este apartado, deberás realizar la carga\n de tu evidencia sujeta a evaluación. Recuerda que esta deberá ser solo \nde tu autoría. &nbsp;<br><br>Para todo esto, contarás con un TUTOR, mismo que\n tendrá la misión de orientarte y responder a todas las dudas que puedan\n surgirte en este proceso de capacitación con fines de certificación. <br><br>Considera\n que cualquier OMISIÓN de los criterios solicitados en las \n\"INDICACIONES\" de cada actividad sujeta a evaluación podría significar \nel juicio de TODAVIA NO COMPETENTE en este Estándar,&nbsp; por lo que te \ninvitamos a tomar muy en serio este proceso de certificación. (Ver \nDerechos y Obligaciones de los usuarios).<br><br>Atentamente &nbsp;<br>Cívika, la casa de Capital Humano de Gama Alta. <br>¡Comencemos!');




-- -----------------------------------------------------
-- Data for table `config_correo`
-- -----------------------------------------------------

INSERT INTO `config_correo` (`id_config_correo`, `smtp_secure`, `host`, `port`, `usuario`, `password`, `name`, `activo`) VALUES (1, 'ssl', 'smtp.hostinger.com', '465', 'contacto@enriquecr.com', 'Pa$$word0192', 'Enrique Corona Developer', 'si');



INSERT INTO `perfil_has_permisos` (`id_cat_perfil`, `id_cat_modulo`, `id_cat_permiso`) VALUES
(1, 1, 1),
(2, 2, 2),
(2, 2, 3),
(2, 2, 4),
(2, 2, 5),
(2, 2, 9),
(2, 2, 10),
(2, 2, 11),
(2, 2, 12),
(2, 2, 13),
(2, 3, 2),
(2, 3, 3),
(2, 3, 4),
(2, 3, 5),
(2, 3, 14),
(2, 3, 15),
(2, 3, 13),
(2, 4, 2),
(2, 4, 3),
(2, 4, 4),
(2, 4, 5),
(2, 4, 13),
(2, 4, 14),
(2, 4, 15),
(2, 5, 2),
(2, 5, 3),
(2, 5, 4),
(2, 5, 5),
(2, 5, 13),
(2, 5, 14),
(2, 5, 15),
(2, 7, 2),
(2, 8, 2),
(2, 8, 3),
(2, 8, 4),
(2, 8, 5),
(2, 8, 13),
(2, 7, 3),
(2, 7, 4),
(2, 7, 5),
(2, 8, 14),
(2, 8, 15),
(3, 2, 2),
(3, 2, 11),
(3, 2, 3),
(3, 2, 4),
(3, 2, 5),
(3, 3, 2),
(3, 3, 14),
(3, 3, 15),
(3, 3, 13),
(3, 2, 12),
(3, 4, 2),
(3, 4, 14),
(3, 4, 15),
(3, 5, 2),
(3, 5, 14),
(3, 5, 15),
(3, 7, 2),
(3, 8, 2),
(3, 8, 14),
(3, 8, 15),
(4, 3, 2),
(4, 3, 14),
(4, 3, 15),
(4, 4, 2),
(4, 4, 14),
(4, 4, 15),
(4, 5, 2),
(4, 5, 14),
(4, 5, 15),
(4, 7, 2),
(4, 8, 2),
(4, 8, 14),
(4, 8, 15),
(4, 8, 3),
(2, 3, 11),
(2, 3, 10),
(3, 3, 11),
(3, 4, 3),
(3, 4, 4),
(3, 4, 5),
(3, 5, 3),
(3, 5, 4),
(3, 5, 5),
(3, 8, 3),
(3, 5, 13);