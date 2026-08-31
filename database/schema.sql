-- Ad Manager database schema
-- MySQL 8+ / MariaDB 10.4+

CREATE TABLE IF NOT EXISTS n4_adsrv_empresas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    empresa VARCHAR(255) NOT NULL,
    calle VARCHAR(255) NULL,
    numero VARCHAR(20) NULL,
    codigo_postal VARCHAR(10) NULL,
    telefono VARCHAR(30) NULL,
    email VARCHAR(255) NULL,
    web VARCHAR(255) NULL,
    fecha_alta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    aud_fecha DATETIME NULL,
    aud_usuario INT UNSIGNED NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    KEY idx_empresas_activo (activo),
    KEY idx_empresas_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS n4_adsrv_usuarios (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    empresaID INT UNSIGNED NOT NULL,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    apellidos VARCHAR(255) NULL,
    telefono VARCHAR(30) NULL,
    email VARCHAR(255) NULL,
    fecha_alta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_ult_acceso DATETIME NULL,
    activada TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    UNIQUE KEY uq_usuarios_username (username),
    KEY idx_usuarios_empresa (empresaID),
    CONSTRAINT fk_usuarios_empresa
        FOREIGN KEY (empresaID) REFERENCES n4_adsrv_empresas (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS n4_adsrv_banners (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    empresaID INT UNSIGNED NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    url VARCHAR(500) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    eliminado TINYINT(1) NOT NULL DEFAULT 0,
    fecha_alta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_baja DATETIME NULL,
    aud_fecha DATETIME NULL,
    aud_usuario INT UNSIGNED NULL,
    aud_accion VARCHAR(500) NULL,
    publicado TINYINT(1) NOT NULL DEFAULT 0,
    publicadoEmpresa TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_banners_empresa (empresaID),
    KEY idx_banners_rotation (activo, estado, eliminado, publicado, publicadoEmpresa),
    CONSTRAINT fk_banners_empresa
        FOREIGN KEY (empresaID) REFERENCES n4_adsrv_empresas (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_banners_aud_usuario
        FOREIGN KEY (aud_usuario) REFERENCES n4_adsrv_usuarios (id)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS n4_adsrv_estadisticas_resumen (
    empresaID INT UNSIGNED NOT NULL,
    bannerID INT UNSIGNED NOT NULL,
    clicks INT UNSIGNED NOT NULL DEFAULT 0,
    impresiones INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (empresaID, bannerID),
    CONSTRAINT fk_resumen_empresa
        FOREIGN KEY (empresaID) REFERENCES n4_adsrv_empresas (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_resumen_banner
        FOREIGN KEY (bannerID) REFERENCES n4_adsrv_banners (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS n4_adsrv_estadisticas (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    bannerID INT UNSIGNED NOT NULL,
    empresaID INT UNSIGNED NOT NULL,
    foroID INT NOT NULL DEFAULT 0,
    topicID INT NOT NULL DEFAULT 0,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_stats_empresa_fecha (empresaID, fecha),
    KEY idx_stats_banner_fecha (bannerID, fecha),
    KEY idx_stats_foro (foroID),
    CONSTRAINT fk_stats_empresa
        FOREIGN KEY (empresaID) REFERENCES n4_adsrv_empresas (id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_stats_banner
        FOREIGN KEY (bannerID) REFERENCES n4_adsrv_banners (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- The reporting code also joins phpbb_forums(forum_id, forum_name).
-- That table belongs to the existing phpBB installation and is not created here.
