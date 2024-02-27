ALTER TABLE `civika_ped_cpprod`.`datos_usuario` 
ADD COLUMN `rfc` CHAR(13) NULL COMMENT 'campo que almacenara el rfc del usuario, de momento solo aplicara a los rrhh de empresa' AFTER `id_cat_ocupacion_especifica`;
