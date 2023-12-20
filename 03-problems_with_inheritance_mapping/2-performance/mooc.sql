CREATE DATABASE mooc;
USE mooc;

CREATE TABLE steps (
	id CHAR(36) NOT NULL,
	title VARCHAR(255) NOT NULL,
	duration INT NOT NULL,
	type VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE steps_video (
	id CHAR(36) NOT NULL,
	url VARCHAR(255) NOT NULL,
	FOREIGN KEY (id) REFERENCES steps(id) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE steps_exercise (
	id CHAR(36) NOT NULL,
	content VARCHAR(255) NOT NULL,
	FOREIGN KEY (id) REFERENCES steps(id) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE steps_quiz (
	id CHAR(36) NOT NULL,
	questions TEXT NOT NULL,
	FOREIGN KEY (id) REFERENCES steps(id) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

CREATE TABLE steps_inline (
	id CHAR(36) NOT NULL,
	type VARCHAR(255) NOT NULL,
	title VARCHAR(255) NOT NULL,
	duration INT NOT NULL,
	url VARCHAR(255),
	content VARCHAR(255),
	questions text,
	PRIMARY KEY (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
