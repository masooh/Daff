create database if not exists moviedb;
use moviedb;

create table if not exists movies (
	id int not null auto_increment primary key,
	source_path varchar(2048),
	filename varchar(512) not null,	
	bytes int
);
