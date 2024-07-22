/*
	@describe: scripts de base de datos para poder gestionar el reset de la constancia dc3 para el usuario y se regenere
	@author Enrique Corona
	@local DESKTOP
	@date jul/2024
	@pruebas
	@date  jul/2024
	@produccion walmart
	@date 17/mayo/2024
*/

ALTER TABLE `estandar_competencia_grupo` 
ADD COLUMN `id_instructor` INT UNSIGNED NULL AFTER `eliminado`,
ADD INDEX `fk_ec_grupo_usuario_instructor_idx` (`id_instructor` ASC) VISIBLE;
;
ALTER TABLE `estandar_competencia_grupo` 
ADD CONSTRAINT `fk_ec_grupo_usuario_instructor`
  FOREIGN KEY (`id_instructor`)
  REFERENCES `usuario` (`id_usuario`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
