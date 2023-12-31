INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (10, 'Reportes', 'reportes_ped');

ALTER TABLE `datos_empresa` 
ADD COLUMN `cargo` VARCHAR(250) NULL AFTER `id_archivo_logotipo`;

ALTER TABLE `datos_empresa` 
ADD COLUMN `id_cat_ocupacion_especifica` INT UNSIGNED NULL AFTER `cargo`,
ADD INDEX `fk_datos_empresa_cat_ocupacion_especifica_idx` (`id_cat_ocupacion_especifica` ASC) VISIBLE;
;
ALTER TABLE `datos_empresa` 
ADD CONSTRAINT `fk_datos_empresa_cat_ocupacion_especifica`
  FOREIGN KEY (`id_cat_ocupacion_especifica`)
  REFERENCES `cat_ocupacion_especifica` (`id_cat_ocupacion_especifica`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `civika_ped`.`datos_empresa` 
ADD COLUMN `supervision` VARCHAR(250) NULL AFTER `id_cat_ocupacion_especifica`,
ADD COLUMN `cri` VARCHAR(150) NULL AFTER `supervision`,
ADD COLUMN `contratista` VARCHAR(350) NULL AFTER `cri`,
ADD COLUMN `subcontratista` VARCHAR(350) NULL AFTER `contratista`;
