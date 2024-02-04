INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (10, 'Reportes', 'reportes_ped');

ALTER TABLE `datos_empresa` 
ADD COLUMN `cargo` VARCHAR(250) NULL AFTER `id_archivo_logotipo`;

ALTER TABLE `datos_empresa` 
ADD COLUMN `id_cat_ocupacion_especifica` INT UNSIGNED NULL AFTER `cargo`,
ADD INDEX `fk_datos_empresa_cat_ocupacion_especifica_idx` (`id_cat_ocupacion_especifica` ASC) ;
;
ALTER TABLE `datos_empresa` 
ADD CONSTRAINT `fk_datos_empresa_cat_ocupacion_especifica`
  FOREIGN KEY (`id_cat_ocupacion_especifica`)
  REFERENCES `cat_ocupacion_especifica` (`id_cat_ocupacion_especifica`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `datos_empresa` 
ADD COLUMN `supervision` VARCHAR(250) NULL AFTER `id_cat_ocupacion_especifica`,
ADD COLUMN `cri` VARCHAR(150) NULL AFTER `supervision`,
ADD COLUMN `contratista` VARCHAR(350) NULL AFTER `cri`,
ADD COLUMN `subcontratista` VARCHAR(350) NULL AFTER `contratista`;

CREATE TABLE `cat_area_tematica` (
  `id_cat_area_tematica` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` CHAR(5) NOT NULL,
  `area_tematica` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_cat_area_tematica`));

INSERT INTO cat_area_tematica (clave,area_tematica) VALUES
	 ('1000','Producción general'),
	 ('2000','Servicios'),
	 ('3000','Administración, contabilidad y economía'),
	 ('4000','Comercialización'),
	 ('5000','Mantenimiento y reparación'),
	 ('6000','Seguridad'),
	 ('7000','Desarrollo personal y familiar'),
	 ('8000','Uso de tecnologías de la información y comunicación'),
	 ('9000','Participación social');


CREATE TABLE `estandar_competencia_grupo` (
  `i_destandar_competencia_grupos` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `duracion` VARCHAR(45) NOT NULL,
  `periodo_inicio` DATE NOT NULL,
  `periodo_fin` DATE NOT NULL,
  `agente_capacitador` VARCHAR(350) NOT NULL,
  `id_cat_area_tematica` INT(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`i_destandar_competencia_grupos`),
  INDEX `fk_ec_grupo_cat_area_tematica_idx` (`id_cat_area_tematica` ASC) ,
  CONSTRAINT `fk_ec_grupo_cat_area_tematica`
    FOREIGN KEY (`id_cat_area_tematica`)
    REFERENCES `cat_area_tematica` (`id_cat_area_tematica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

ALTER TABLE `estandar_competencia_grupo` 
ADD COLUMN `id_estandar_competencia` INT UNSIGNED NOT NULL AFTER `id_cat_area_tematica`;

ALTER TABLE `estandar_competencia_grupo` 
ADD INDEX `fk_ec_grupo_estandar_competencia_idx` (`id_estandar_competencia` ASC) ;
;
ALTER TABLE `estandar_competencia_grupo` 
ADD CONSTRAINT `fk_ec_grupo_estandar_competencia`
  FOREIGN KEY (`id_estandar_competencia`)
  REFERENCES `estandar_competencia` (`id_estandar_competencia`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `civika_ped`.`estandar_competencia_grupo` 
ADD COLUMN `clave_grupo` VARCHAR(45) NOT NULL AFTER `i_destandar_competencia_grupos`,
ADD COLUMN `nombre_grupo` VARCHAR(250) NOT NULL AFTER `clave_grupo`;

ALTER TABLE `civika_ped`.`estandar_competencia_grupo` 
CHANGE COLUMN `i_destandar_competencia_grupos` `id_estandar_competencia_grupo` INT UNSIGNED NOT NULL AUTO_INCREMENT ;

CREATE TABLE `civika_ped`.`cat_categoria_empresa` (
  `id_cat_categoria_empresa` INT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id_cat_categoria_empresa`));

INSERT INTO cat_categoria_empresa (nombre) VALUES
	 ('CRI'),
	 ('Contratista Asociada'),
	 ('Subcontratista Asociado'),
	 ('Supervisión');
	 
ALTER TABLE `civika_ped`.`datos_empresa` 
DROP FOREIGN KEY `fk_datos_empresa_cat_ocupacion_especifica`;
ALTER TABLE `civika_ped`.`datos_empresa` 
DROP COLUMN `subcontratista`,
DROP COLUMN `contratista`,
DROP COLUMN `cri`,
DROP COLUMN `supervision`,
DROP COLUMN `id_cat_ocupacion_especifica`,
ADD COLUMN `id_cat_categoria_empresa` INT(3) UNSIGNED NULL AFTER `cargo`,
ADD INDEX `fk_datos_empresa_categoria_emp_idx` (`id_cat_categoria_empresa` ASC) VISIBLE,
DROP INDEX `fk_datos_empresa_cat_ocupacion_especifica_idx` ;
;
ALTER TABLE `civika_ped`.`datos_empresa` 
ADD CONSTRAINT `fk_datos_empresa_categoria_emp`
  FOREIGN KEY (`id_cat_categoria_empresa`)
  REFERENCES `civika_ped`.`cat_categoria_empresa` (`id_cat_categoria_empresa`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `civika_ped`.`datos_empresa` 
ADD COLUMN `nombre_corto` VARCHAR(150) NULL AFTER `nombre`;

ALTER TABLE `civika_ped`.`estandar_competencia_grupo` 
ADD COLUMN `eliminado` ENUM('si', 'no') NOT NULL DEFAULT 'no' AFTER `id_estandar_competencia`;
