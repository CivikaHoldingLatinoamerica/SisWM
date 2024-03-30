/*
	@describe: scripts de base de datos para poder emitir credenciales conforme a requerimientos del usuario de walmart
			 se considera de igual manera que estos cambios se vean reflejados en el sistema de yo soy lider y en el SIIPED de civika
			 sistemas similares pero en distinto dominio y reglas operativas distintas
	@author Enrique Corona
	@local
	@date 22/mar/2024
	@pruebas
	@date 30/mar/2024
	@produccion
	@date N/A
*/

ALTER TABLE `estandar_competencia` 
ADD COLUMN `calificacion_min_conocer` DECIMAL(6,2) NULL AFTER `calificacion_juicio`,
ADD COLUMN `calificacion_max_conocer` DECIMAL(6,2) NULL AFTER `calificacion_min_conocer`,
ADD COLUMN `calificacion_min_wm` DECIMAL(6,2) NULL AFTER `calificacion_max_conocer`,
ADD COLUMN `calificacion_max_wm` DECIMAL(6,2) NULL AFTER `calificacion_min_wm`;

ALTER TABLE `entregable_ec` 
ADD COLUMN `entregable_wm` ENUM('si', 'no') NOT NULL DEFAULT 'no' AFTER `id_estandar_competencia`;

CREATE TABLE `cat_calibracion_desempeno` (
  `id_cat_calibracion_desempeno` INT(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_cat_calibracion_desempeno`))
ENGINE = InnoDB;

ALTER TABLE `usuario_has_estandar_competencia` 
ADD COLUMN `id_cat_calibracion_desempeno` INT(3) UNSIGNED NULL COMMENT 'columna de información que almacenara la calibracion de desepeño que se utilizara para la credencialización' AFTER `id_estandar_competencia_grupo`,
ADD INDEX `fk_usuario_has_estandar_competencia_calibracion_desem_idx` (`id_cat_calibracion_desempeno` ASC);
;
ALTER TABLE `usuario_has_estandar_competencia` 
ADD CONSTRAINT `fk_usuario_has_estandar_competencia_calibracion_desem`
  FOREIGN KEY (`id_cat_calibracion_desempeno`)
  REFERENCES `cat_calibracion_desempeno` (`id_cat_calibracion_desempeno`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

INSERT INTO cat_calibracion_desempeno (nombre) VALUES
	('Aún no calificado'),
	('Calificado'),
	('Optimo'),
	('Alto potencial'),
	('Alto desempeño');
	
	
ALTER TABLE `usuario` 
ADD COLUMN `id_archivo_qr` BIGINT(20) UNSIGNED NULL COMMENT 'llave foranea para identificar el codigo qr del usuario para el sistema' AFTER `id_usuario_registro`,
ADD INDEX `fk_usuario_archivo_qr_idx` (`id_archivo_qr` ASC);
;
ALTER TABLE `usuario` 
ADD CONSTRAINT `fk_usuario_archivo_qr`
  FOREIGN KEY (`id_archivo_qr`)
  REFERENCES `archivo` (`id_archivo`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `usuario_has_estandar_competencia` 
ADD COLUMN `fecha_emision_certificado` DATE NULL COMMENT 'columna que almacenara la fecha de cuando se emitio el certificado, para adicionar o contar un año a partir de aqui para la vigencia de la credencial' AFTER `intentos_adicionales`;
