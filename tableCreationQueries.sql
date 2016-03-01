/* * * * * * * * * * * *
  Rosa Tung
  2.17.16
  Table Creation Queries
 * * * * * * * * * * * */

 /* * * * * * * * * * * * * * * * * * * *
 refresh tables 
 * * * * * * * * * * * * * * * * * * * */
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
	PK region_id 
	name is unique
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_regions ( 
	region_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(225) NOT NULL,
	CONSTRAINT `region_name` UNIQUE (name),
	PRIMARY KEY (region_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 factions
	PK faction_id 
	name is unique
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_factions ( 
	faction_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(225) NOT NULL,
	CONSTRAINT `faction_name` UNIQUE (name),
	PRIMARY KEY(faction_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 Races
	PK race_id
	name is unique
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_races (
	race_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY(race_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 Champions
	PK champion_id
	name is unique 
	FK race_id
	FK faction_id
	FK region_id 	
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_champions (
	champion_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	gender ENUM('M', 'F') NOT NULL DEFAULT "M",
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
	PK alias_id
	FK champion_id
	alias is unique
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_aliases (
	alias_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	champion_id INT UNSIGNED NOT NULL,
	alias text NOT NULL,
	CONSTRAINT `uniqueAlias` UNIQUE (alias(255)),
	FOREIGN KEY (champion_id) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY(alias_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 occupations 
	PK occupation_id
	title is unique
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_occupations (
	occupation_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	title VARCHAR(225) NOT NULL,
	CONSTRAINT `occupation_title` UNIQUE (title),
	PRIMARY KEY (occupation_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * * * * 
 champion occupations
	PK,FK champion_id
	PK,FK occupation_id
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
	PK,FK champion_id
	PK,FK faction_id
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
	PK,FK champion_id
	PK,FK champion_id
 * * * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_championRelationships (
	champion_id INT UNSIGNED NOT NULL,
	champion_id2 INT UNSIGNED NOT NULL,
	related ENUM('Y', 'N') NOT NULL,
	romantic ENUM('Y', 'N') NOT NULL, 
	ally ENUM('Y', 'N') NOT NULL,
	rival ENUM('Y', 'N') NOT NULL,
	FOREIGN KEY (champion_id) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (champion_id2) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT PRIMARY KEY (champion_id, champion_id2)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * * * 
 INSERTIONS
 * * * * * * * * * * * * * * * * * * * * * */
 
/* * * * * * * * * * * * * * * * * * * * * * 
 insert regions
	INSERT INTO lol_regions([name]) VALUES
 * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_regions(name) VALUES
(NULL), ("Blue Flame Islands"), ("Howling Marsh"), ("Ironspike Mountains"), ("Kalamanda"), ("Kumungu"), ("Lokfar"), ("Marshes of Kaladoun"), ("Mount Targon"), ("Plague Jungles"), ("Serpentine River"), ("Shurima Desert"), 
("The Great Barrier"), ("Voodoo Lands"), ("Conqueror's Sea"), ("Guardian's Sea"), ("The Glad"), ("The Void"), ("Sablestone Mountain Range"), ("Ruddynip Valley");

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 insert factions
	INSERT INTO lol_factions([name], [region_id]) VALUES
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_factions(name) VALUES
(NULL), ("Bandle City"), ("Bilgewater"), ("Demacia"), ("Freljord"), ("Ionia"), ("Mount Targon"), ("Noxus"), ("Piltover"), ("Shadow Isles"), ("Shurima"), ("Zaun"), ("Independent"), ("Kinkou Order"); 

/* * * * * * * * * * * * * * * * * * * * * * 
 insert races
	INSERT INTO lol_races([name]) VALUES
 * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_races(name) VALUES
("Darkin"), ("Gumiho"), ("Human"), ("Yordle"), ("Monkey");

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 insert champions
 INSERT INTO lol_champions([name], [gender], [race_id], [birth_faction_id], [birth_region_id], [releaseDate]) VALUES 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_champions(name, gender, race_id, birth_faction_id, birth_region_id, releaseDate) VALUES 
("Aatrox", "M", (SELECT race_id FROM lol_races WHERE name = "Darkin"), NULL, NULL, "2013-06-13"), ("Ahri", "F", (SELECT race_id FROM lol_races WHERE name = "Gumiho"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2011-12-14"), ("Akali", "F", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2010-06-11"), ("Kennen", "M", (SELECT race_id FROM lol_races WHERE name = "Yordle"), (SELECT faction_id FROM lol_factions WHERE name = "Bandle City"), (SELECT region_id FROM lol_regions WHERE name = "Ruddynip Valley"), "2010-04-08"), ("Shen", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2010-03-24"), ("Wukong", "M", (SELECT race_id FROM lol_races WHERE name = "Monkey"), NULL, (SELECT region_id FROM lol_regions WHERE name = "Plague Jungles"), "2011-07-26"), ("Master Yi", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2009-02-21"),
("Jhin", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),

("Tahm Kench", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),
("Sona", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),
("Tryndamere", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),
("Zed", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),
("Singed", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01");

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 insert aliases
 INSERT INTO lol_aliases([champion_id], [alias]) VALUES
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_aliases(champion_id, alias) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), "The Darkin Blade"), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"), "The Nine Tailed Fox"), ((SELECT champion_id FROM lol_champions WHERE name = "Akali"), "The First of Shadow"), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"), "The Heart of the Tempest"), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"), "Eye of Twilight"), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"), "The Monkey King"), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"), "Kong"), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"), "Pupil"), ((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"), "The Wuku Bladesman"), 
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), "The Virtuoso"), 
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), "The Artison Killer"), 
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), "Golden Demon"); 

/* * * * * * * * * * * * * * * * * * * * * * 
 insert occupations
 INSERT INTO lol_occupations([title]) VALUES
 * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_occupations(title) VALUES
("Avatar of War"), ("Huntress"), ("Popstar"), ("Member of the Kinkou"), ("Leader of the Kinkou"), ("Eye of Twilight"), ("Wuju Practitioner"), ("PROJECT member"), ("Artist"), ("Assassin"), ("Serial Killer");

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 insert champion occupations 
 INSERT INTO lol_championOccupations([champion_id], [occupation_id]) VALUES
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_championOccupations(champion_id, occupation_id) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), (SELECT occupation_id FROM lol_occupations WHERE title = "Avatar of War")), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"),(SELECT occupation_id FROM lol_occupations WHERE title = "Huntress")), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"),(SELECT occupation_id FROM lol_occupations WHERE title = "Popstar")), ((SELECT champion_id FROM lol_champions WHERE name = "Akali"),(SELECT occupation_id FROM lol_occupations WHERE title = "Member of the Kinkou")), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"),(SELECT occupation_id FROM lol_occupations WHERE title = "Member of the Kinkou")), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"),(SELECT occupation_id FROM lol_occupations WHERE title = "Leader of the Kinkou")), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"),(SELECT occupation_id FROM lol_occupations WHERE title = "Eye of Twilight")), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"),(SELECT occupation_id FROM lol_occupations WHERE title = "Wuju Practitioner")), ((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"),(SELECT occupation_id FROM lol_occupations WHERE title = "Wuju Practitioner")), ((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"),(SELECT occupation_id FROM lol_occupations WHERE title = "PROJECT member")), ((SELECT champion_id FROM lol_champions WHERE name = "Jhin"),(SELECT occupation_id FROM lol_occupations WHERE title = "Artist")), ((SELECT champion_id FROM lol_champions WHERE name = "Jhin"),(SELECT occupation_id FROM lol_occupations WHERE title = "Assassin")),
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"),(SELECT occupation_id FROM lol_occupations WHERE title = "Serial Killer"));

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 insert champion faction allegiances 
 INSERT INTO lol_championFactions([champion_id], [faction_id]) VALUES
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_championFactions(champion_id, faction_id) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"),(SELECT faction_id FROM lol_factions WHERE name = "Independent")), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"),(SELECT faction_id FROM lol_factions WHERE name = "Independent")), ((SELECT champion_id FROM lol_champions WHERE name = "Akali"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")), ((SELECT champion_id FROM lol_champions WHERE name = "Akali"),(SELECT faction_id FROM lol_factions WHERE name = "Kinkou Order")), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"),(SELECT faction_id FROM lol_factions WHERE name = "Kinkou Order")), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"),(SELECT faction_id FROM lol_factions WHERE name = "Bandle City")), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"),(SELECT faction_id FROM lol_factions WHERE name = "Kinkou Order")), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")), ((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")),
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia"));

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 insert champion relationships
 INSERT INTO lol_championRelationships([champion_id], [champion_id2], [related], [romantic], [ally], [rival]) VALUES
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
INSERT INTO lol_championRelationships(champion_id, champion_id2, related, romantic, ally, rival) VALUES /*true 1*/
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), (SELECT champion_id FROM lol_champions WHERE name = "Tahm Kench"), "N", "N", "Y", "N"), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), (SELECT champion_id FROM lol_champions WHERE name = "Tryndamere"), "N", "N", "N", "Y"), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Ahri"), (SELECT champion_id FROM lol_champions WHERE name = "Wukong"), "N", "N", "Y", "N"), /*ALLIES*/
((SELECT champion_id FROM lol_champions WHERE name = "Akali"), (SELECT champion_id FROM lol_champions WHERE name = "Shen"), "N", "N", "Y", "N"), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Akali"), (SELECT champion_id FROM lol_champions WHERE name = "Kennen"), "N", "N", "Y", "N"), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Akali"), (SELECT champion_id FROM lol_champions WHERE name = "Zed"), "N", "N", "N", "Y"), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Kennen"), (SELECT champion_id FROM lol_champions WHERE name = "Shen"), "N", "N", "Y", "N"), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Kennen"), (SELECT champion_id FROM lol_champions WHERE name = "Zed"), "N", "N", "N", "Y"), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Kennen"), (SELECT champion_id FROM lol_champions WHERE name = "Tahm Kench"), "N", "N", "N", "Y"), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Shen"), (SELECT champion_id FROM lol_champions WHERE name = "Zed"), "N", "N", "N", "Y"), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Shen"), (SELECT champion_id FROM lol_champions WHERE name = "Jhin"), "N", "N", "N", "Y"), /*ENEMIES*/
((SELECT champion_id FROM lol_champions WHERE name = "Wukong"), (SELECT champion_id FROM lol_champions WHERE name = "Master Yi"), "N", "N", "Y", "N"), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"), (SELECT champion_id FROM lol_champions WHERE name = "Singed"), "N", "N", "N", "Y"), /*ENEMIES*/
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), (SELECT champion_id FROM lol_champions WHERE name = "Sona"), "N", "N", "N", "Y"), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), (SELECT champion_id FROM lol_champions WHERE name = "Master Yi"), "N", "N", "N", "Y"), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), (SELECT champion_id FROM lol_champions WHERE name = "Zed"), "N", "N", "N", "Y"), /*ENEMIES*/

((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), (SELECT champion_id FROM lol_champions WHERE name = "Singed"), "Y", "Y", "N", "Y"); /*ENEMIES*/







