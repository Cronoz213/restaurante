

CREATE TABLE IF NOT EXISTS usuarios (
  id         INT           NOT NULL AUTO_INCREMENT,
  nome       VARCHAR(100)  NOT NULL,
  email      VARCHAR(100)  NOT NULL UNIQUE,
  senha      VARCHAR(255)  NOT NULL,
  created_at TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categorias (
  id         INT           NOT NULL AUTO_INCREMENT,
  nome       VARCHAR(100)  NOT NULL,
  descricao  TEXT,
  ativo      TINYINT(1)    NOT NULL DEFAULT 1,
  created_at TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pratos (
  id           INT           NOT NULL AUTO_INCREMENT,
  categoria_id INT           NOT NULL,
  nome         VARCHAR(150)  NOT NULL,
  descricao    TEXT,
  preco        DECIMAL(8,2)  NOT NULL,
  foto         VARCHAR(255),
  disponivel   TINYINT(1)    NOT NULL DEFAULT 1,
  created_at   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT fk_pratos_categoria
    FOREIGN KEY (categoria_id) REFERENCES categorias (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mesas (
  id          INT           NOT NULL AUTO_INCREMENT,
  numero      INT           NOT NULL UNIQUE,
  capacidade  INT           NOT NULL,
  localizacao VARCHAR(100),
  status      ENUM('livre','ocupada','reservada') NOT NULL DEFAULT 'livre',
  created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reservas (
  id            INT           NOT NULL AUTO_INCREMENT,
  mesa_id       INT           NOT NULL,
  nome_cliente  VARCHAR(100)  NOT NULL,
  telefone      VARCHAR(20),
  data_reserva  DATE          NOT NULL,
  hora_reserva  TIME          NOT NULL,
  num_pessoas   INT           NOT NULL,
  observacoes   TEXT,
  status        ENUM('pendente','confirmada','cancelada') NOT NULL DEFAULT 'pendente',
  created_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT fk_reservas_mesa
    FOREIGN KEY (mesa_id) REFERENCES mesas (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO usuarios (nome, email, senha) VALUES (
  'Admin',
  'admin@restaurante.com',
  '$2y$10$VhGb6dmB9Y8gOfhRhRRrd.b6yui5JXXioGO1ECWCs8SOrBJnxyAaO'
);
