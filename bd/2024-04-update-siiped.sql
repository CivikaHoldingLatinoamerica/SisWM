/*
	@describe: scripts de base de datos para poder emitir credenciales conforme a requerimientos del usuario de walmart
			 se considera de igual manera que estos cambios se vean reflejados en el sistema de yo soy lider y en el SIIPED de civika
			 sistemas similares pero en distinto dominio y reglas operativas distintas
	@author Enrique Corona
	@local DESKTOP
	@date 23/abr/2024
	@pruebas 14/may/2024
	@date 
	@produccion walmart
	@date 
	@production siiped
	@date 
*/

ALTER TABLE `usuario_has_estandar_competencia` 
ADD COLUMN `id_archivo_dc3` BIGINT UNSIGNED NULL AFTER `id_cat_calibracion_desempeno`,
ADD COLUMN `id_archivo_dc3_qr` BIGINT UNSIGNED NULL AFTER `id_archivo_dc3`,
ADD INDEX `fk_usuario_has_estandar_competencia_archivodc3_idx` (`id_archivo_dc3` ASC) ,
ADD INDEX `fk_usuario_has_ec_archivo_dc3qr_idx` (`id_archivo_dc3_qr` ASC) ;
;
ALTER TABLE `usuario_has_estandar_competencia` 
ADD CONSTRAINT `fk_usuario_has_estandar_competencia_archivodc3`
  FOREIGN KEY (`id_archivo_dc3`)
  REFERENCES `archivo` (`id_archivo`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuario_has_ec_archivo_dc3qr`
  FOREIGN KEY (`id_archivo_dc3_qr`)
  REFERENCES `archivo` (`id_archivo`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `usuario_has_estandar_competencia` 
ADD COLUMN `id_archivo_ped_wm` BIGINT UNSIGNED NULL AFTER `id_archivo_dc3_qr`,
ADD INDEX `fk_usr_has_ec_archivo_ped_wm_idx` (`id_archivo_ped_wm` ASC);
;
ALTER TABLE `usuario_has_estandar_competencia` 
ADD CONSTRAINT `fk_usr_has_ec_archivo_ped_wm`
  FOREIGN KEY (`id_archivo_ped_wm`)
  REFERENCES `archivo` (`id_archivo`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
