/* * * * * * *
  Rosa Tung
  CS 340
  2.17.16
 * * * * * * */

DROP TABLE IF EXISTS `lol_championRelationships`;
DROP TABLE IF EXISTS `lol_championFactions`;
DROP TABLE IF EXISTS `lol_championOccupations`;
DROP TABLE IF EXISTS `lol_occupations`;
DROP TABLE IF EXISTS `lol_champions`;
DROP TABLE IF EXISTS `lol_factions`;
DROP TABLE IF EXISTS `lol_regions`;

/* * * * * * * * * * * * * * * * * * * *
 regions
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_regions ( 
	region_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(225) NOT NULL,
	PRIMARY KEY (region_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 factions
	[faction] -> [region] : many to one 
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_factions ( 
	faction_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(225) NOT NULL,
	region_id INT UNSIGNED,
	PRIMARY KEY(faction_id),
	CONSTRAINT `is_static` FOREIGN KEY (region_id) REFERENCES lol_regions(region_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 Champions
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_champions (
	champion_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	alias text NOT NULL,
	gender ENUM('M', 'F') NOT NULL,
	race VARCHAR(50) NOT NULL,
	birth_faction_id INT UNSIGNED, 
	birth_region_id INT UNSIGNED,
	releaseDate DATE NOT NULL,
	PRIMARY KEY(champion_id),
	CONSTRAINT `has_city` FOREIGN KEY (birth_faction_id) REFERENCES lol_factions(faction_id),
	CONSTRAINT `has_region` FOREIGN KEY (birth_region_id) REFERENCES lol_regions(region_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 occupations 
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_occupations (
	occupation_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	title VARCHAR(225) NOT NULL,
	PRIMARY KEY (occupation_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * * * * 
 champion occupations
	[champion] -> [occupation] : many to many
 * * * * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_championOccupations (
	champion_id INT UNSIGNED NOT NULL REFERENCES lol_champions(champion_id),
	occupation_id INT UNSIGNED NOT NULL REFERENCES lol_occupations(occupation_id),
	PRIMARY KEY (champion_id, occupation_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * * * * 
 champion allegiances
	[champion] -> [faction] : many to many
 * * * * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_championFactions (
	champion_id INT UNSIGNED NOT NULL REFERENCES lol_champions(champion_id),
	faction_id INT UNSIGNED NOT NULL REFERENCES lol_factions(faction_id),
	PRIMARY KEY (champion_id, faction_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * * * 
 champion relationships
	[champion] -> [champion] : many to many
 * * * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_championRelationships (
	champion_id1 INT NOT NULL REFERENCES lol_champions(champion_id),
	champion_id2 INT NOT NULL REFERENCES lol_champions(champion_id),
	related BIT DEFAULT NULL,
	relation text, 
	romantic BIT DEFAULT NULL,
	relationship text, 
	ally BIT DEFAULT NULL,
	rival BIT DEFAULT NULL,
	PRIMARY KEY (champion_id1, champion_id2)
)ENGINE = InnoDB;

-- insert the following into the client table:
INSERT INTO lol_regions(name) VALUES
("Blue Flame Islands"), ("Howling Marsh"), ("Ironspike Mountains"), ("Kalamanda"), ("Kumungu"), ("Lokfar"), 
("Marshes of Kaladoun"), ("Mount Targon"), ("Plague Jungles"), ("Serpentine River"), ("Shurima Desert"), ("The Great Barrier"), 
("Voodoo Lands"), ("Conqueror's Sea"), ("Guardian's Sea"), ("The Glad"), ("The Void"), ("Sablestone Mountain Range"),
("Ruddynip Valley");

INSERT INTO lol_factions(name, region_id) VALUES
("Bandle City", 19), ("Bilgewater", 1), ("Demacia", NULL), ("Freljord", NULL), ("Ionia", NULL), ("Mount Targon", 8),
("Noxus", NULL), ("Piltover", NULL), ("Shadow Isles", NULL), ("Shurima", 11), ("Zaun", NULL), ("Independent", NULL); 

INSERT INTO lol_champions(name, alias, gender, race, birth_faction_id, birth_region_id, releaseDate) VALUES 
(Aatrox, "The Darkin Blade", "M", "Darkin", NULL, NULL, "2013-06-13"), ();

INSERT INTO lol_occupations(title) VALUES
("Avatar of War"), 

INSERT INTO lol_championOccupations(champion_id, occupation_id) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"),(SELECT occupation_id FROM lol_occupations WHERE title = "Avatar of War")), 

INSERT INTO lol_championFactions(champion_id, faction_id) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"),(SELECT faction_id FROM lol_factions WHERE name = "Independent")),

INSERT INTO lol_championRelationships(champion_id1, champion_id2, related, relation, romatic, relationship, ally, rival) VALUES /*true 1*/
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), /*FRIENDS TAHM KENCH*/
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), /*RIVALS TRYNDAMERE*/







