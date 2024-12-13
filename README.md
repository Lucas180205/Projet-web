Regarder si votre base de donnée est bien reliée,

A ajouter à votre base de donnée pour les tests : 
veuillez vider votre bdd avant d'implémenter

INSERT INTO bank(id,name,dir,description) VALUES (1,"fruit","fruits","c'est des fruits");
INSERT INTO bank(id,name,dir,description) VALUES (2,"animal","animaux","c'est des animaux");
INSERT INTO bank(id,name,dir,description) VALUES (3,"voiture","voitures","c'est des voiture");
INSERT INTO bank(id,name,dir,description) VALUES (4,"fleurs","fleurs","c'est des fleurs");

INSERT INTO image(id,bankId,name) VALUES (1,1,"cerise.jpg");
INSERT INTO image(id,bankId,name) VALUES (2,1,"fruit1.jpg");
INSERT INTO image(id,bankId,name) VALUES (3,1,"fruit2.jpg");
INSERT INTO image(id,bankId,name) VALUES (4,1,"fruit3.jpg");
INSERT INTO image(id,bankId,name) VALUES (5,1,"mangue.jpg");
INSERT INTO image(id,bankId,name) VALUES (6,1,"pasteque.jpg");
INSERT INTO image(id,bankId,name) VALUES (7,1,"peche.jpg");
INSERT INTO image(id,bankId,name) VALUES (8,1,"poire.jpg");
INSERT INTO image(id,bankId,name) VALUES (9,1,"pomme.jpg");

INSERT INTO image(id,bankId,name) VALUES (10,2,"blob.jpg");
INSERT INTO image(id,bankId,name) VALUES (12,2,"guepard.jpg");
INSERT INTO image(id,bankId,name) VALUES (13,2,"panda.jpg");
INSERT INTO image(id,bankId,name) VALUES (14,2,"souris.jpg");
INSERT INTO image(id,bankId,name) VALUES (15,2,"squirel.jpg");
INSERT INTO image(id,bankId,name) VALUES (16,2,"tigre.jpg");
INSERT INTO image(id,bankId,name) VALUES (17,2,"zebre.jpg");


INSERT INTO image(id,bankId,name) VALUES (19,3,"voiture1.jpg");
INSERT INTO image(id,bankId,name) VALUES (20,3,"voiture2.jpg");
INSERT INTO image(id,bankId,name) VALUES (21,3,"voiture3.jpg");
INSERT INTO image(id,bankId,name) VALUES (22,3,"voiture4.jpg");

INSERT INTO image(id,bankId,name) VALUES (23,4,"fleurs1.jpg");
INSERT INTO image(id,bankId,name) VALUES (24,4,"fleurs2.jpg");
INSERT INTO image(id,bankId,name) VALUES (26,4,"fleurs4.jpg");
INSERT INTO image(id,bankId,name) VALUES (27,4,"fleurs5.jpg");
INSERT INTO image(id,bankId,name) VALUES (28,4,"fleurs6.jpg");
INSERT INTO image(id,bankId,name) VALUES (29,4,"fleurs7.jpg");
INSERT INTO image(id,bankId,name) VALUES (30,4,"fleurs8.jpg");




