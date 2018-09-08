/*criar um banco de dados chamado bd_series */

/* cria o sequence para a tabela de usuário */
create sequence sid_usuario;

/* cria a tabela de usuário */
create table usuario(
   id int not null default nextval ('sid_usuario'),
   nome varchar(50) not null,
   sexo char(1) not null,
   email varchar(30) not null,
   status char(1) not null,
   senha text not null,
   constraint pk_usuario_id primary key (id),
   constraint unq_email unique(email),
   constraint chk_sexo check (sexo in ('M','F')),
   constraint chk_status check (status in ('A','I'))
);


/*cria a sequence da tabela genero*/
create sequence sid_genero;

/* cria a tabela genero*/
create table genero(
   id int not null default nextval('sid_genero'),
   nome varchar(30) not null,
   constraint pk_genero_id primary key (id),
   constraint unq_genero unique (nome)
);

/* cria a sequence da tabela serie*/
create sequence sid_serie;

create table serie(
   id int not null default nextval('sid_serie'),
   nome varchar(50) not null,
   temporadas int not null,
   ano_inicio int not null,
   ano_fim int,
   genero int not null,
   imagem text,
   constraint pk_serie_id primary key (id),
   constraint fk_serie_genero foreign key (genero) 
      references genero(id),
   constraint unq_serie unique(nome)
);



