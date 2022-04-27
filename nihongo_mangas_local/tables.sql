create table users (
    id bigint AUTO_INCREMENT primary key,          
	nick VARCHAR(70) unique not null,     
	hash_password varchar(70)
);
create table uuid_table (
    usuari bigint references users(id) on delete cascade, 
    uuid char(36)
);
create table mangas (
    nom_manga varchar(30),
    img varchar(120),
    preu float,
    fecha date,
    primary key (nom_manga)
);

alter table users add calle varchar(50), tlf char(9);