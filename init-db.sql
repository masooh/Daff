create database if not exists moviedb;
use moviedb;

CREATE TABLE IF NOT EXISTS movies (
  id          INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
  source      VARCHAR(512),
  source_path VARCHAR(2048),
  filename    VARCHAR(512) NOT NULL,
  bytes       INT,
  stored      BOOLEAN,
  local_path  VARCHAR(2048)
);


