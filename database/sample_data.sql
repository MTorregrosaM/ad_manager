-- Ad Manager sample data
-- Run database/schema.sql first.
-- The application currently compares passwords as plain text.
-- Change the application to password_hash/password_verify before production use.

INSERT INTO n4_adsrv_empresas
    (id, empresa, calle, numero, codigo_postal, telefono, email, web, activo)
VALUES
    (1, 'Example Games Ltd', 'Main Street', '42', '28001', '+34 900 123 456',
     'contact@example-games.test', 'https://example-games.test', 1);

INSERT INTO n4_adsrv_usuarios
    (id, empresaID, username, password, nombre, apellidos, email, activada)
VALUES
    (1, 1, 'admin', 'change-me', 'Admin', 'User', 'admin@example-games.test', 1);

INSERT INTO n4_adsrv_banners
    (id, empresaID, imagen, url, nombre, descripcion, activo, estado, eliminado,
     publicado, publicadoEmpresa, aud_usuario)
VALUES
    (1, 1, 'sample-banner.png', 'https://example-games.test/',
     'Sample banner', 'Sample banner for local development', 1, 1, 0, 0, 0, 1);

INSERT INTO n4_adsrv_estadisticas_resumen
    (empresaID, bannerID, clicks, impresiones)
VALUES
    (1, 1, 2, 12);

INSERT INTO n4_adsrv_estadisticas
    (bannerID, empresaID, foroID, topicID, fecha)
VALUES
    (1, 1, 0, 0, CURRENT_TIMESTAMP),
    (1, 1, 0, 0, DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 DAY));

-- foroID and topicID can reference an existing phpBB installation.
-- The sample uses 0 so it does not require phpBB data.
