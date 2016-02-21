/* * * * * * * * * * *
  Rosa Tung
  2.17.16
  General Use Queries
 * * * * * * * * * * */

/* * * * * * * * * * * * * * * * * * * *
 view tables
 * * * * * * * * * * * * * * * * * * * */

SELECT * FROM lol_championRelationships;
SELECT * FROM lol_championFactions;
SELECT * FROM lol_championOccupations;
SELECT * FROM lol_occupations;
SELECT * FROM lol_races;
SELECT * FROM lol_aliases;
SELECT * FROM lol_champions;
SELECT * FROM lol_factions;
SELECT * FROM lol_regions;

/* * * * * * * * * * * * * * * * * * * *
 Champion Details
	names, genders, races, origin, and
	release dates
 order by alphabetical order
 * * * * * * * * * * * * * * * * * * * */
SELECT 	lol_champions.name AS "Champion",
		lol_champions.gender AS "Gender",
		lol_races.name AS "Race",
		CONCAT(IFNULL(lol_factions.name, "n/a"), ", ", IFNULL(lol_regions.name, "n/a")) AS 'Origin (Nation/Faction, Region)',
		lol_champions.releaseDate AS "Release Date"
FROM lol_champions
LEFT JOIN lol_races ON lol_champions.race_id = lol_races.race_id
LEFT JOIN lol_factions ON lol_champions.birth_faction_id = lol_factions.faction_id
lEFT JOIN lol_regions ON lol_champions.birth_region_id = lol_regions.region_id
ORDER BY lol_champions.name ASC;

/* * * * * * * * * * * * * * * * * * * *
 Display Aliases of a Champion
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * */
 
/* * * * * * * * * * * * * * * * * * * *
 Display Allegiances + # Champions per
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * */
SELECT 	lol_factions.name AS "Faction",
		IFNULL(lol_championFactions.champion_id, "0") AS "Number of Champions"
FROM lol_factions
LEFT JOIN lol_championFactions ON lol_factions.faction_id = lol_championFactions.faction_id
GROUP BY lol_factions.name
ORDER BY lol_factions.name ASC;

/* * * * * * * * * * * * * * * * * * * *
 Display Occupations + # Champions per
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * */

/* * * * * * * * * * * * * * * * * * * *
 Display Races + # Champions per 
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * */
SELECT 	lol_races.name AS "Race", 
		COUNT(lol_champions.race_id) AS "Number of Champions"
FROM lol_races 
LEFT JOIN lol_champions ON lol_champions.race_id = lol_races.race_id
GROUP BY lol_races.name
ORDER BY lol_races.name ASC;

 /* * * * * * * * * * * * * * * * * * * *
 Display Champions Names and Races
 order by: release date
 * * * * * * * * * * * * * * * * * * * */
SELECT 	lol_champions.name AS "Champion Name", 
		lol_races.name AS "Race" , 
		lol_champions.releaseDate AS "Release Date"
FROM lol_champions
LEFT JOIN lol_races ON lol_champions.race_id = lol_races.race_id  
ORDER BY releaseDate ASC;

/* * * * * * * * * * * * * * * * * * * * * *
 Display relationships of a Champion
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * * * */
 
/* * * * * * * * * * * * * * * * * * * * * *
 Display Champions in Romantic Relationships
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * * * */
 
/* * * * * * * * * * * * * * * * * * * * * *
 Display Champions who are related
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * * * */

/* * * * * * * * * * * * * * * * * * * * * *
 Display Champions who are allies
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * * * */

/* * * * * * * * * * * * * * * * * * * * * *
 Display Champions who are enemies
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * * * */


 


 
 
 
 
 
 