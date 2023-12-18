INSERT INTO `cat_modulo` (`id_cat_modulo`, `nombre`, `slug`) VALUES (10, 'Reportes', 'reportes_ped');

ALTER TABLE `datos_empresa` 
ADD COLUMN `cargo` VARCHAR(250) NULL AFTER `id_archivo_logotipo`;
