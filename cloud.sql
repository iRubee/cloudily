CREATE DATABASE IF NOT EXISTS `cloud`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `cloud`;

CREATE TABLE IF NOT EXISTS `users` (
    `ID_USER` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(100) NOT NULL,
    `psw` VARCHAR(255) NOT NULL,
    `ruolo_user` INT NOT NULL DEFAULT 1,
    `nome` VARCHAR(100) NOT NULL,
    `cognome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(254) NOT NULL,
    PRIMARY KEY (`ID_USER`),
    UNIQUE KEY `uq_users_username` (`username`),
    UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `cartelle` (
    `ID_CARTELLA` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `denominazione` VARCHAR(255) NOT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `data_creazione` DATE NOT NULL,
    `condivisione` TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`ID_CARTELLA`),
    KEY `idx_cartelle_user` (`id_user`),
    KEY `idx_cartelle_visibility` (`condivisione`),
    CONSTRAINT `fk_cartelle_user`
        FOREIGN KEY (`id_user`) REFERENCES `users` (`ID_USER`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `chk_cartelle_condivisione`
        CHECK (`condivisione` IN (0, 1))
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `files` (
    `ID_FILES` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `denominazione` VARCHAR(255) NOT NULL,
    `nome_file` VARCHAR(255) NOT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `id_cartella` INT UNSIGNED NULL DEFAULT NULL,
    `data_creazione` DATE NOT NULL,
    `condivisione` TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`ID_FILES`),
    KEY `idx_files_user` (`id_user`),
    KEY `idx_files_cartella` (`id_cartella`),
    KEY `idx_files_visibility` (`condivisione`),
    CONSTRAINT `fk_files_user`
        FOREIGN KEY (`id_user`) REFERENCES `users` (`ID_USER`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `fk_files_cartella`
        FOREIGN KEY (`id_cartella`) REFERENCES `cartelle` (`ID_CARTELLA`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,
    CONSTRAINT `chk_files_condivisione`
        CHECK (`condivisione` IN (0, 1))
) ENGINE=InnoDB;
