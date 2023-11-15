ALTER TABLE `ec_curso_modulo` 
ADD COLUMN `liberado` ENUM('si', 'no') NOT NULL DEFAULT 'no' COMMENT 'columna que determina si el modulo se libera para el candidato y sea visible para ellos' AFTER `id_ec_curso`;
