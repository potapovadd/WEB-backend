CREATE TABLE form (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  fio varchar(150) NOT NULL DEFAULT '',
  tel varchar(12) NOT NULL DEFAULT '',
  email varchar(40) NOT NULL DEFAULT '',
  date varchar(30) NOT NULL DEFAULT '',
  gender varchar(10) NOT NULL DEFAULT '',
  bio varchar(200) NOT NULL DEFAULT '',
  checkbox BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (id)
);

CREATE TABLE form_lang (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  iduser int(10) NOT NULL DEFAULT 0,
  idlang varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);

CREATE TABLE lang (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (id)
);
