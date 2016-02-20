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
	name VARCHAR(255) NOT NULL,
	PRIMARY KEY(race_id)
)ENGINE = InnoDB;

/* * * * * * * * * * * * * * * * * * * * 
 Champions
 * * * * * * * * * * * * * * * * * * * */
CREATE TABLE lol_champions (
	champion_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
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
	FOREIGN KEY (champion_id) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
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
	romantic BIT NOT NULL, 
	ally BIT NOT NULL,
	rival BIT NOT NULL,
	CONSTRAINT `two_way` UNIQUE (champion_id1, champion_id2),
	FOREIGN KEY (champion_id1) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (champion_id2) REFERENCES lol_champions(champion_id) ON DELETE RESTRICT ON UPDATE CASCADE,
	PRIMARY KEY (champion_id1, champion_id2)
)ENGINE = InnoDB;

-- insert the following into the client table:
INSERT INTO lol_regions(name) VALUES
("Blue Flame Islands"), ("Howling Marsh"), ("Ironspike Mountains"), ("Kalamanda"), ("Kumungu"), ("Lokfar"), ("Marshes of Kaladoun"), ("Mount Targon"), ("Plague Jungles"), ("Serpentine River"), ("Shurima Desert"), 
("The Great Barrier"), ("Voodoo Lands"), ("Conqueror's Sea"), ("Guardian's Sea"), ("The Glad"), ("The Void"), ("Sablestone Mountain Range"), ("Ruddynip Valley");

INSERT INTO lol_factions(name, region_id) VALUES
("Bandle City", (SELECT region_id FROM lol_regions WHERE name = "Ruddynip Valley")), ("Bilgewater", (SELECT region_id FROM lol_regions WHERE name = "Blue Flame Islands")), ("Demacia", NULL), ("Freljord", NULL), 
("Ionia", NULL), ("Mount Targon", (SELECT region_id FROM lol_regions WHERE name = "Mount Targon")), ("Noxus", NULL), ("Piltover", NULL), ("Shadow Isles", NULL), 
("Shurima", (SELECT region_id FROM lol_regions WHERE name = "Shurima Desert")), ("Zaun", NULL), ("Independent", NULL), ("Kinkou Order", NULL); 

INSERT INTO lol_races(name) VALUES
("Darkin"), ("Gumiho"), ("Human"), ("Yordle"), ("Monkey");

INSERT INTO lol_champions(name, gender, race_id, birth_faction_id, birth_region_id, releaseDate) VALUES 
("Aatrox", "M", (SELECT race_id FROM lol_races WHERE name = "Darkin"), NULL, NULL, "2013-06-13"), ("Ahri", "F", (SELECT race_id FROM lol_races WHERE name = "Gumiho"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2011-12-14"), ("Akali", "F", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2010-06-11"), ("Kennen", "M", (SELECT race_id FROM lol_races WHERE name = "Yordle"), (SELECT faction_id FROM lol_factions WHERE name = "Bandle City"), (SELECT region_id FROM lol_regions WHERE name = "Ruddynip Valley"), "2010-04-08"), ("Shen", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2010-03-24"), ("Wukong", "M", (SELECT race_id FROM lol_races WHERE name = "Monkey"), NULL, (SELECT region_id FROM lol_regions WHERE name = "Plague Jungles"), "2011-07-26"), 
("Master Yi", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2009-02-21"),
("Jhin", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),

("Tahm Kench", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),
("Sona", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),
("Tryndamere", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),
("Zed", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01"),
("Singed", "M", (SELECT race_id FROM lol_races WHERE name = "Human"), (SELECT faction_id FROM lol_factions WHERE name = "Ionia"), NULL, "2016-02-01");

INSERT INTO lol_aliases(champion_id, alias) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), "The Darkin Blade"), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"), "The Nine Tailed Fox"), ((SELECT champion_id FROM lol_champions WHERE name = "Akali"), "The First of Shadow"), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"), "The Heart of the Tempest"), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"), "Eye of Twilight"), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"), "The Monkey King"), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"), "Kong"), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"), "Pupil"), ((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"), "The Wuku Bladesman"), 
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), "The Virtuoso"), 
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), "The Artison Killer"), 
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), "Golden Demon"); 

INSERT INTO lol_occupations(title) VALUES
("Avatar of War"), ("Huntress"), ("Popstar"), ("Member of the Kinkou"), ("Leader of the Kinkou"), ("Eye of Twilight"), ("Wuju Practitioner"), ("PROJECT member"), ("Artist"), ("Assassin"), ("Serial Killer");

INSERT INTO lol_championOccupations(champion_id, occupation_id) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), (SELECT occupation_id FROM lol_occupations WHERE title = "Avatar of War")), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"),(SELECT occupation_id FROM lol_occupations WHERE title = "Huntress")), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"),(SELECT occupation_id FROM lol_occupations WHERE title = "Popstar")), ((SELECT champion_id FROM lol_champions WHERE name = "Akali"),(SELECT occupation_id FROM lol_occupations WHERE title = "Member of the Kinkou")), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"),(SELECT occupation_id FROM lol_occupations WHERE title = "Member of the Kinkou")), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"),(SELECT occupation_id FROM lol_occupations WHERE title = "Leader of the Kinkou")), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"),(SELECT occupation_id FROM lol_occupations WHERE title = "Eye of Twilight")), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"),(SELECT occupation_id FROM lol_occupations WHERE title = "Wuju Practitioner")), ((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"),(SELECT occupation_id FROM lol_occupations WHERE title = "Wuju Practitioner")), ((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"),(SELECT occupation_id FROM lol_occupations WHERE title = "PROJECT member")), ((SELECT champion_id FROM lol_champions WHERE name = "Jhin"),(SELECT occupation_id FROM lol_occupations WHERE title = "Artist")), ((SELECT champion_id FROM lol_champions WHERE name = "Jhin"),(SELECT occupation_id FROM lol_occupations WHERE title = "Assassin")),
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"),(SELECT occupation_id FROM lol_occupations WHERE title = "Serial Killer"));

INSERT INTO lol_championFactions(champion_id, faction_id) VALUES
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"),(SELECT faction_id FROM lol_factions WHERE name = "Independent")), ((SELECT champion_id FROM lol_champions WHERE name = "Ahri"),(SELECT faction_id FROM lol_factions WHERE name = "Independent")), ((SELECT champion_id FROM lol_champions WHERE name = "Akali"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")), ((SELECT champion_id FROM lol_champions WHERE name = "Akali"),(SELECT faction_id FROM lol_factions WHERE name = "Kinkou Order")), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"),(SELECT faction_id FROM lol_factions WHERE name = "Kinkou Order")), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")), ((SELECT champion_id FROM lol_champions WHERE name = "Kennen"),(SELECT faction_id FROM lol_factions WHERE name = "Bandle City")), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")), ((SELECT champion_id FROM lol_champions WHERE name = "Shen"),(SELECT faction_id FROM lol_factions WHERE name = "Kinkou Order")), ((SELECT champion_id FROM lol_champions WHERE name = "Wukong"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")), ((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia")),
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"),(SELECT faction_id FROM lol_factions WHERE name = "Ionia"));

INSERT INTO lol_championRelationships(champion_id1, champion_id2, related, romantic, ally, rival) VALUES /*true 1*/
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), (SELECT champion_id FROM lol_champions WHERE name = "Tahm Kench"), 0, 0, 1, 0), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Aatrox"), (SELECT champion_id FROM lol_champions WHERE name = "Tryndamere"), 0, 0, 0, 1), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Ahri"), (SELECT champion_id FROM lol_champions WHERE name = "Wukong"), 0, 0, 1, 0), /*ALLIES*/
((SELECT champion_id FROM lol_champions WHERE name = "Akali"), (SELECT champion_id FROM lol_champions WHERE name = "Shen"), 0, 0, 1, 0), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Akali"), (SELECT champion_id FROM lol_champions WHERE name = "Kennen"), 0, 0, 1, 0), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Akali"), (SELECT champion_id FROM lol_champions WHERE name = "Zed"), 0, 0, 0, 1), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Kennen"), (SELECT champion_id FROM lol_champions WHERE name = "Shen"), 0, 0, 1, 0), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Kennen"), (SELECT champion_id FROM lol_champions WHERE name = "Zed"), 0, 0, 0, 1), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Kennen"), (SELECT champion_id FROM lol_champions WHERE name = "Tahm Kench"), 0, 0, 0, 1), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Shen"), (SELECT champion_id FROM lol_champions WHERE name = "Zed"), 0, 0, 0, 1), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Shen"), (SELECT champion_id FROM lol_champions WHERE name = "Jhin"), 0, 0, 0, 1), /*ENEMIES*/
((SELECT champion_id FROM lol_champions WHERE name = "Wukong"), (SELECT champion_id FROM lol_champions WHERE name = "Master Yi"), 0, 0, 1, 0), /*FRIENDS*/
((SELECT champion_id FROM lol_champions WHERE name = "Master Yi"), (SELECT champion_id FROM lol_champions WHERE name = "Singed"), 0, 0, 0, 1), /*ENEMIES*/
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), (SELECT champion_id FROM lol_champions WHERE name = "Sona"), 0, 0, 0, 1), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), (SELECT champion_id FROM lol_champions WHERE name = "Master Yi"), 0, 0, 0, 1), /*RIVALS*/
((SELECT champion_id FROM lol_champions WHERE name = "Jhin"), (SELECT champion_id FROM lol_champions WHERE name = "Zed"), 0, 0, 0, 1); /*ENEMIES*/








