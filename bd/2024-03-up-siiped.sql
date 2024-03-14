ALTER TABLE `civika_ped_cpprod`.`estandar_competencia` 
ADD COLUMN `calificacion_min_conocer` DECIMAL(6,2) NULL AFTER `calificacion_juicio`,
ADD COLUMN `calificacion_max_conocer` DECIMAL(6,2) NULL AFTER `calificacion_min_conocer`,
ADD COLUMN `calificacion_min_wm` DECIMAL(6,2) NULL AFTER `calificacion_max_conocer`,
ADD COLUMN `calificacion_max_wm` DECIMAL(6,2) NULL AFTER `calificacion_min_wm`;

ALTER TABLE `civika_ped_cpprod`.`entregable_ec` 
ADD COLUMN `entregable_wm` ENUM('si', 'no') NOT NULL DEFAULT 'no' AFTER `id_estandar_competencia`;
