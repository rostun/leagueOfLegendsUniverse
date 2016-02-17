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
	gender ENUM('M', 'F'),
	race VARCHAR(50),
	birth_faction_id INT UNSIGNED, 
	birth_region_id INT UNSIGNED,
	date_released DATE NOT NULL,
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
 

