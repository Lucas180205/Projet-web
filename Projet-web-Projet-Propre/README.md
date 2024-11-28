Regarder si votre base de donnée est bien reliée,

A ajouter à votre base de donnée pour les tests : 
INSERT INTO bank(id,name,dir,description) VALUES (1,"fruit","fruits","c'est des fruits");
INSERT INTO bank(id,name,dir,description) VALUES (2,"animal","animaux","c'est des animaux");
INSERT INTO image(id,bankId,name) VALUES (1,1,"pomme.jpg");
INSERT INTO image(id,bankId,name) VALUES (2,1,"cerise.jpg");
INSERT INTO image(id,bankId,name) VALUES (3,1,"fraise.jpg");
INSERT INTO image(id,bankId,name) VALUES (4,2,"renard.jpg");
INSERT INTO image(id,bankId,name) VALUES (5,2,"tigre.jpg");
INSERT INTO catalog(id,userAccoundId,name,description) VALUES (1,#depends de vous souvent 1,"fruits","album de fruits");
INSERT INTO catalog(id,userAccoundId,name,description) VALUES (2,#depends de vous souvent 1 ,"animaux","album d'animaux");
INSERT INTO catalog(id,userAccoundId,name,description) VALUES (3,#depends de vous souvent1 ,"rouge","album de trucs rouges");
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (1,1,1,1);
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (2,1,2,2);
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (3,1,3,3);
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (4,2,4,1);
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (5,2,5,2);
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (6,3,1,1);
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (7,3,2,2);
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (8,3,3,3);
INSERT INTO catalogimage(id,catalogId,imageId,position) VALUES (9,3,4,4);
