ALTER TABLE `civika_siiped_cpprod`.`estandar_competencia_grupo` 
ADD COLUMN `id_instructor` INT UNSIGNED NULL AFTER `eliminado`,
ADD INDEX `fk_ec_grupo_usuario_instructor_idx` (`id_instructor` ASC) VISIBLE;
;
ALTER TABLE `civika_siiped_cpprod`.`estandar_competencia_grupo` 
ADD CONSTRAINT `fk_ec_grupo_usuario_instructor`
  FOREIGN KEY (`id_instructor`)
  REFERENCES `civika_siiped_cpprod`.`usuario` (`id_usuario`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
