CREATE TABLE megustas (
    id_user INT(32),
    id_meme INT(32)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE megustas
	ADD PRIMARY KEY (id_meme, id_user);
	
	
ALTER TABLE megustas
	ADD CONSTRAINT mg_ibfk_1 FOREIGN KEY (id_meme) REFERENCES memes (id_meme) ON DELETE CASCADE,
    ADD CONSTRAINT mg_ibfk_2 FOREIGN KEY (id_user) REFERENCES users (id) ON DELETE CASCADE;