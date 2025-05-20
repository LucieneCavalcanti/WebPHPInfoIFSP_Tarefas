create database bdProjeto
use bdProjeto

create table tbusuarios(
id int not null primary key auto_increment,
nome varchar(200) not null,
email varchar(200) not null,
senha varchar(20) not null,
datacadastro datetime default now(),
status int default 1 -- 0 inativo, 1 ativo
)

insert into tbusuarios (nome,email,senha)
values('Administrador','adm@adm','123')

select * from tbusuarios