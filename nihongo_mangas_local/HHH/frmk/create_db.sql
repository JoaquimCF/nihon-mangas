use project;

DROP TABLE if exists api_keys;
DROP TABLE if exists usuaris;

CREATE TABLE usuaris(
	id bigint AUTO_INCREMENT primary key,          
	nick VARCHAR(70) unique not null,     
	hash_password varchar(70)
);

CREATE TABLE api_keys (
	usuari bigint references usuaris(id) on delete cascade,          
	api_key char(36)     
);

INSERT INTO usuaris (nick, hash_password) VALUES ('xavi','$2y$10$gwSk88U3TFvacFxkOzz7/.vMO1qw1.lnKADWu8NWVlIAeK9uM8rc6');
INSERT INTO usuaris (nick, hash_password) VALUES ('xquesada','$2y$10$gwSk88U3TFvacFxkOzz7/.vMO1qw1.lnKADWu8NWVlIAeK9uM8rc6');
INSERT INTO usuaris (nick, hash_password) VALUES ('xaviq','$2y$10$gwSk88U3TFvacFxkOzz7/.vMO1qw1.lnKADWu8NWVlIAeK9uM8rc6');

INSERT INTO api_keys (usuari, api_key) VALUES (1, '5ccd4065-11bc-4d19-9794-e4f71576eb38');
INSERT INTO api_keys (usuari, api_key) VALUES (1, '8239da18-8411-47f6-a93f-e551e51a8755');
INSERT INTO api_keys (usuari, api_key) VALUES (2, 'ce42545c-d068-4276-8e68-09f9242c3464');