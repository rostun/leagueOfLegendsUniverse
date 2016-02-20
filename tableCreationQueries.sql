/* * * * * * * * * * * *
  Rosa Tung
  2.17.16
  Table Creation Queries
 * * * * * * * * * * * */

DROP TABLE IF EXISTS `lol_championRelationships`;
DROP TABLE IF EXISTS `lol_championFactions`;
DROP TABLE IF EXISTS `lol_championOccupations`;
DROP TABLE IF EXISTS `lol_occupations`;
DROP TABLE IF EXISTS `lol_aliases`;
DROP TABLE IF EXISTS `lol_champions`;
DROP TABLE IF EXISTS `lol_races`;
DROP TABLE IF EXISTS `lol_factions`;
DROP TABLE IF EXISTS `lol_regions`;

/* * * * * * * * * * * * * * * * * * * *
 regions
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_regions ( 
	region_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(225) NOT NULL,
	CONSTRAINT `region_name` UNIQUE (name),
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
	CONSTRAINT `faction_name` UNIQUE (name),
	CONSTRAINT `is_static` FOREIGN KEY (region_id) REFERENCES lol_regions(region_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY(faction_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 Races
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_races (
	race_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	PRIMARY KEY(race_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 Champions
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_champions (
	champion_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	gender ENUM('M', 'F') NOT NULL,
	race_id INT UNSIGNED,
	birth_faction_id INT UNSIGNED, 
	birth_region_id INT UNSIGNED,
	releaseDate DATE NOT NULL,
	CONSTRAINT `champion_name` UNIQUE (name),
	FOREIGN KEY (race_id) REFERENCES lol_races(race_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT `has_city` FOREIGN KEY (birth_faction_id) REFERENCES lol_factions(faction_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT `has_region` FOREIGN KEY (birth_region_id) REFERENCES lol_regions(region_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY(champion_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 Champions Alias(es)
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_aliases (
	alias_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	champion_id INT UNSIGNED NOT NULL,
	alias text NOT NULL,
	FOREIGN KEY (champion_id) REFERENCES lol_races(race_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY(alias_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 occupations 
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_occupations (
	occupation_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	title VARCHAR(225) NOT NULL,
	CONSTRAINT `occupation_title` UNIQUE (title),
	PRIMARY KEY (occupation_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * * * * 
 champion occupations
	[champion] -> [occupation] : many to many
 * * * * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_championOccupations (
	champion_id INT UNSIGNED NOT NULL, 
	occupation_id INT UNSIGNED NOT NULL, 
	FOREIGN KEY (champion_id) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (occupation_id) REFERENCES lol_occupations(occupation_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY (champion_id, occupation_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * * * * 
 champion allegiances
	[champion] -> [faction] : many to many
 * * * * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_championFactions (
	champion_id INT UNSIGNED NOT NULL,
	faction_id INT UNSIGNED NOT NULL,
	FOREIGN KEY (champion_id) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (faction_id) REFERENCES lol_factions(faction_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY (champion_id, faction_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * * * 
 champion relationships
	[champion] -> [champion] : many to many
 * * * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_championRelationships (
	champion_id1 INT UNSIGNED NOT NULL,
	champion_id2 INT UNSIGNED NOT NULL,
	related BIT NOT NULL,
	relation text DEFAULT NULL, 
	romantic BIT NOT NULL,
	relationship text DEFAULT NULL, 
	ally BIT NOT NULL,
	rival BIT NOT NULL,
	FOREIGN KEY (champion_id1) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (champion_id2) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
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
(Aatrox, "The Darkin Blade", "M", (SELECT race_id FROM lol_races WHERE name = "Darkin"), NULL, NULL, "2013-06-13"), 
(Ahri, "The Nine Tailed Fox", "M", "Darkin", NULL, NULL, "2013-06-13"),

INSERT INTO lol_aliases(champion_id, alias) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), "The Darkin Blade"), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"), "The Nine Tailed Fox"), 

INSERT INTO lol_races(name) VALUES
("Darkin"), 

INSERT INTO lol_occupations(title) VALUES
("Avatar of War"), 

INSERT INTO lol_championOccupations(champion_id, occupation_id) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"),(SELECT occupation_id FROM lol_occupations WHERE title = "Avatar of War")), 

INSERT INTO lol_championFactions(champion_id, faction_id) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"),(SELECT faction_id FROM lol_factions WHERE name = "Independent")),

INSERT INTO lol_championRelationships(champion_id1, champion_id2, related, relation, romatic, relationship, ally, rival) VALUES /*true 1*/
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), (SELECT champion_id FROM lol_champions WHERE name = "Tahm Kench"), 0, NULL, 0, NULL, 1, 0), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), (SELECT champion_id FROM lol_champions WHERE name = "Tryndamere"), 0, NULL, 0, NULL, 0, 1), /*RIVALS*/







