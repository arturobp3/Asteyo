SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*He comentado todo en lo que dudaba por el codigo. Cuando lo mires borralo.
He incluido "ENGINE=InnoDB DEFAULT CHARSET=utf8;" en todos los CREATE TABLE porque
asi lo hacia phpMyAdmin, supongo que lo de DEFAULT CHARSET=utf8 se podria poner global
o algo aasi pero no se, asi estan las cosas*/

/*En phpMyAdmin ya se puede importar sin fallos, me ha costao la vida ver los fallos porque
no te explica nada pero bueno, ya se puede, asi que supongo que la declaración de las foreign key y
todo eso será correcto, aún así te dejo los comentarios para que veas donde estaba dudando por si
acaso*/

/*---------------------------------------------------------------------------*/
/*-----------------------------TABLA USUARIOS--------------------------------*/
/*---------------------------------------------------------------------------*/

CREATE TABLE users(
	id int(32) NOT NULL,
	username varchar(32) UNIQUE NOT NULL,
	password varchar(80) NOT NULL,
	email varchar(32),
	last_connect datetime,
	rol ENUM( 'normal', 'moderador', 'administrador')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE users
	ADD PRIMARY KEY (id);
	
ALTER TABLE users
	 MODIFY id int(32) NOT NULL AUTO_INCREMENT;
	
	
/*---------------------------------------------------------------------------*/
/*--------------------------TABLA DATOS USUARIOS-----------------------------*/
/*---------------------------------------------------------------------------*/

/*¿Por qué tenemos esta tabla y la de usuarios? No pueden tener nada de esto repetido, nos sobra una tabla creo.
Si crees que nos sobra la tabla borrala y descomenta lo de la tabla users, si crees que no sobra borra lo comentado
de la tabla users
		
CREATE TABLE users_data (
	id int(32) NOT NULL,
	email varchar(32),
	last_connect datetime
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Sinceramente esto no se si esta bien del todo, sale algo parecido en internet, me parece raro añadir dos KEY a (id)
ALTER TABLE users_data
	ADD PRIMARY KEY (id),
	ADD KEY users_id (id);
	
	
ALTER TABLE users_data
	ADD CONSTRAINT users_data_ibfk_1 FOREIGN KEY (id) REFERENCES users (id);*/
	
	
	
/*---------------------------------------------------------------------------*/
/*---------------------------------TABLA MEMES-------------------------------*/
/*---------------------------------------------------------------------------*/

/*En esta tabla almacenamos todos los datos relacionados con los memes subidos por los usuarios*/


/*Soy consciente de que hay 3 ALTER TABLE seguidos, supogno que se podrán poner juntos algunos de ellos, si tal
ponlos que yo no estoy seguro jeje*/
	
CREATE TABLE memes (
	id_meme int(32) NOT NULL, 
	title varchar(100) NOT NULL,
	num_megustas int(64) NOT NULL,
	id_autor int(32) NOT NULL,
	upload_date datetime,
	link_img varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE memes
	ADD PRIMARY KEY (id_meme),
	ADD KEY id_user (id_autor);
	
	
ALTER TABLE memes
	ADD CONSTRAINT memes_ibfk_1 FOREIGN KEY (id_autor) REFERENCES users (id) ON DELETE CASCADE;
	
	
ALTER TABLE memes
	 MODIFY id_meme int(32) NOT NULL AUTO_INCREMENT;

	 
	 
/*---------------------------------------------------------------------------*/
/*---------------------------TABLA COMENTARIOS-------------------------------*/
/*---------------------------------------------------------------------------*/

	 
CREATE TABLE comments (
	id_comment int (32) NOT NULL, 
	id_autor int(32) NOT NULL,
	id_meme int(32) NOT NULL,
	texto text NOT NULL,
	c_date datetime
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE comments
	ADD PRIMARY KEY (id_comment),
	ADD KEY id_user (id_autor),
	ADD KEY id_meme (id_meme);

	
ALTER TABLE comments
	ADD CONSTRAINT comments_ibfk_1 FOREIGN KEY (id_autor) REFERENCES users (id) ON DELETE CASCADE,
	ADD CONSTRAINT comments_ibfk_2 FOREIGN KEY (id_meme) REFERENCES memes (id_meme) ON DELETE CASCADE;
	
	
ALTER TABLE comments
	 MODIFY id_comment int(32) NOT NULL AUTO_INCREMENT;

	 
/*---------------------------------------------------------------------------*/
/*------------------------------TABLA REPORTES-------------------------------*/
/*---------------------------------------------------------------------------*/

/*Yo lo he hecho en forma de relacion "is a" que se me ocurrio haciendo mi bbdd, si ves otra forma mejor
todo tuyo*/

/*POR ESTUDIAR, mirar como diferenciar ids(US_,ME_,CO_)*/ /*NO SE PUEDE PAYASO*/ /*/ /*In dè independència*/
CREATE TABLE reports (
	usr_that_reports int(32) NOT NULL,
	usr_reported int(32) NOT NULL,
	id_report int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE reports
	ADD PRIMARY KEY (id_report),
	ADD KEY that_reports (usr_that_reports),
	ADD KEY reported (usr_reported);

	
ALTER TABLE reports
	ADD CONSTRAINT reports_ibfk_1 FOREIGN KEY (usr_that_reports) REFERENCES users (id) ON DELETE CASCADE,
	ADD CONSTRAINT reports_ibfk_2 FOREIGN KEY (usr_reported) REFERENCES users (id) ON DELETE CASCADE;
	
	
ALTER TABLE reports
	 MODIFY id_report int(32) NOT NULL AUTO_INCREMENT;



/*---------------------------------------------------------------------------*/
/*------------------------TABLA REPORTES AL USUARIO--------------------------*/
/*---------------------------------------------------------------------------*/

/*El ENUM esta por ver y retocar los nombres de los reportes pero algo asi he pensado*/

CREATE TABLE usr_reports (
	id_report int(32) NOT NULL,
	cause ENUM ('Foto de perfil ofensiva', 'Nombre inapropiado', 'Bot')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE usr_reports
	ADD PRIMARY KEY (id_report),
	ADD KEY report (id_report);


ALTER TABLE usr_reports
	ADD CONSTRAINT usr_reports_igfk_1 FOREIGN KEY (id_report) REFERENCES reports(id_report) ON DELETE CASCADE;
	
	
	
/*---------------------------------------------------------------------------*/
/*--------------------------TABLA REPORTES A MEME----------------------------*/
/*---------------------------------------------------------------------------*/
	
/*Estos los he puesto juntos porque se me ocurren los mismos motivos de reporte para los dos, 
si se te ocurren distintos utiliza la tabla comentada de abajo para reportes a 
comentarios y utiliza esta para los memes, solo hay que cambiar el nombre en esta tabla, si no, borrala*/

CREATE TABLE me_reports (
	id_report int(32) NOT NULL,
	cause ENUM ('Spam', 'Ofensivo'),
	id_meme int(32)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE me_reports
	ADD PRIMARY KEY (id_report),
	ADD KEY report (id_report);


ALTER TABLE me_reports
	ADD CONSTRAINT me_igfk_1 FOREIGN KEY (id_report) REFERENCES reports(id_report) ON DELETE CASCADE,
	ADD CONSTRAINT me_igfk_2 FOREIGN KEY (id_meme) REFERENCES memes(id_meme) ON DELETE CASCADE;
	

	
/*---------------------------------------------------------------------------*/
/*------------------TABLA REPORTES A COMENTARIOS-----------------------------*/
/*---------------------------------------------------------------------------*/
	

CREATE TABLE co_reports (
	id_report int(32) NOT NULL,
	cause ENUM('Spam', 'Ofensivo'),
	id_comment int(32)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE co_reports
	ADD PRIMARY KEY (id_report),
	ADD KEY report (id_report);


ALTER TABLE co_reports
	ADD CONSTRAINT co_reports_igfk_1 FOREIGN KEY (id_report) REFERENCES reports(id_report) ON DELETE CASCADE,
	ADD CONSTRAINT co_reports_igfk_2 FOREIGN KEY (id_comment) REFERENCES comments(id_comment) ON DELETE CASCADE;

/*---------------------------------------------------------------------------*/
/*-----------------------------TABLA ETIQUETAS-------------------------------*/
/*---------------------------------------------------------------------------*/

/*He puesto NOT NULL en el numero de memes porque las etiquetas se crearan segun se vayan
subiendo memes no? Como no lo se seguro te lo comento. Y en el numero de mg porque si no tienen
ninguno será 0 no null digo yo nu se*/
CREATE TABLE hashtags (
	name varchar(32) NOT NULL,
	n_memes int(255) NOT NULL,
	n_mg int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE hashtags
	ADD PRIMARY KEY (name);

	
	
/*---------------------------------------------------------------------------*/
/*---------------------TABLA ETIQUETAS DE CADA MEME--------------------------*/
/*---------------------------------------------------------------------------*/


CREATE TABLE  hashtag_meme (
	name_hash varchar(32) NOT NULL,
	id_meme int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Aqui otra duda, las dos deberiand e ser primary y las dos son foreign, por eso he puesto todo
este rollo, pero no se si es asi correctamente*/
ALTER TABLE hashtag_meme
	ADD PRIMARY KEY (id_meme, name_hash),
	ADD KEY hashtag_name (name_hash),
	ADD KEY id_meme (id_meme);

	
ALTER TABLE hashtag_meme
	ADD CONSTRAINT hashtag_meme_ibfk_1 FOREIGN KEY (name_hash) REFERENCES hashtags (name) ON DELETE CASCADE,
	ADD CONSTRAINT hashtag_meme_ibfk_2 FOREIGN KEY (id_meme) REFERENCES memes (id_meme) ON DELETE CASCADE;
	

/*---------------------------------------------------------------------------*/
/*---------------------TABLA ETIQUETAS DE CADA MEME--------------------------*/
/*---------------------------------------------------------------------------*/
	
CREATE TABLE achievement (
	id_user int(32) NOT NULL,
	name varchar(32) NOT NULL,
	date_got datetime
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE achievement
	ADD PRIMARY KEY (name),
	ADD KEY id_user (id_user);
	
	
ALTER TABLE achievement
	ADD CONSTRAINT achievement_ibfk_1 FOREIGN KEY (id_user) REFERENCES users (id) ON DELETE CASCADE;
	


/*---------------------------------------------------------------------------*/
/*---------------------TABLA IMAGEN DEL LOGRO--------------------------------*/
/*---------------------------------------------------------------------------*/

	
CREATE TABLE achievement_img (
	name varchar(32) NOT NULL,
	link varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE achievement_img
	ADD PRIMARY KEY (name),
	ADD KEY achievement_name (name);
	
	
ALTER TABLE achievement_img
	ADD CONSTRAINT achievement_img_ibfk_1 FOREIGN KEY (name) REFERENCES achievement (name) ON DELETE CASCADE;
	
COMMIT;















	