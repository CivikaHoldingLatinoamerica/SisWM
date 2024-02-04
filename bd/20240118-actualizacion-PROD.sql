ALTER TABLE `civika_ped`.`usuario` 
ADD COLUMN `id_usuario_registro` INT UNSIGNED NULL AFTER `password_temp`,
ADD INDEX `fk_usuario_registro_save_idx` (`id_usuario_registro` ASC);
;
ALTER TABLE `civika_ped`.`usuario` 
ADD CONSTRAINT `fk_usuario_registro_save`
  FOREIGN KEY (`id_usuario_registro`)
  REFERENCES `civika_ped`.`usuario` (`id_usuario`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

INSERT INTO cat_perfil (id_cat_perfil,nombre,slug) VALUES
	 (5,'RRHH Empresa','admin_emp');