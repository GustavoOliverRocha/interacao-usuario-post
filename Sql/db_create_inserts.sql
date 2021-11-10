create database db_post;
use db_post;
create table tb_usuario(
	cd_usuario int not null auto_increment,
	nm_usuario varchar(30),
	nm_pessoal varchar(60),
	nm_foto varchar(80),
	senha_usuario varchar(30),
	constraint pk_usuario primary key(cd_usuario)
);
create table tb_postagem(
	cd_postagem int not null auto_increment,
	nm_conteudo text,
	tot_like int,
	fk_cd_usuario int,
	constraint pk_postagem primary key(cd_postagem),
	CONSTRAINT fk_usuario_postagem FOREIGN key(fk_cd_usuario) REFERENCES tb_usuario(cd_usuario)
);

create table interacao_post(
fk_cd_usuario int,
fk_cd_postagem int,
nr_like tinyint,
constraint fk_usuario_interacao foreign key(fk_cd_usuario) references tb_usuario(cd_usuario),
constraint fk_postagem_interacao foreign key(fk_cd_postagem) references tb_postagem(cd_postagem)
);

create table comentarios(
cd_comentario int not null auto_increment,
nm_comentario text,	
fk_cd_usuario int,
fk_cd_postagem int,
constraint pk_comentario primary key(cd_comentario),
constraint fk_usuario_coment foreign key(fk_cd_usuario) references tb_usuario(cd_usuario),
constraint fk_postagem_coment foreign key(fk_cd_postagem) references tb_postagem(cd_postagem)
);

insert into tb_usuario(nm_usuario,nm_pessoal,senha_usuario) values
	('admin','Administrador','admin'),
	('Madoka','Kaname Madoka','admin'),('Homura','Akemi Homura','admin'),('Mami','Tomoe Mami','admin'),
	('Victor','vitin','admin'),('akietrabalho','Guilherme Simões','admin'),('Kuroe','Paulo Palestra','admin'),
	('Suzune','Maria Luiza','admin'),('Orikomikuni','Karmila','admin'),('Iroha','João Dalsin','admin');

insert into tb_postagem(nm_conteudo,tot_like,fk_cd_usuario) values
('Anunciado um novo filme de Madoka: Puella Magi Madoka Magica: Mikuni Oriko no Monogatari;É isso ae galera pode comemorar',0,1),
('Fingir que n viu algo para que a pessoa nao se sinta desconfortavel e um nivel de empatia que todo mundo deveria ter',0,5),
('Ja vi gente bonita mas essa gente que ta lendo agr e linda demais',0,1),
('Antes de dormir coloque os chinelos na cama',0,7),
('Fui fingir que tava dormindo e...',0,6);

insert into comentarios(nm_comentario,fk_cd_usuario,fk_cd_postagem) values 
('Vo apaga isso pelo amor de deus',1,3),
('Pode deixa',7,3),
('Ja to assistindo',9,4),
('Dica de condicionamento físico: nunca pare de se esforçar. Alguns dizem que 8 horas de sono são suficientes. Por que não continuar? Por que não 9? Por que não 10? Lute por grandeza.',4,1),
('Da próxima vez que você estiver treinando, faça 15 flexões em vez de 10. Corra 3 milhas em vez de 2. Coma um bolo inteiro em vez de apenas uma fatia. Queime a casa do seu ex. Você consegue. Eu acredito em você.',5,1),
('Houve tantas mensagens confusas que eu não posso- ',7,1);
