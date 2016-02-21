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
 Display Champions Names and Races
 order by: release date
 * * * * * * * * * * * * * * * * * * * */

SELECT 	lol_champions.name AS "Champion Name", 
		lol_races.name AS "Race" , 
		lol_champions.releaseDate AS "Release Date"
FROM lol_champions
INNER JOIN lol_races ON lol_champions.race_id = lol_races.race_id  
ORDER BY releaseDate ASC;

/* * * * * * * * * * * * * * * * * * * *
 Display Races + # Champions per Race
 order by: alphabetical order
 * * * * * * * * * * * * * * * * * * * */
SELECT 	lol_races.name AS "Race", 
		COUNT(lol_champions.race_id) AS "Number of Champions"
FROM lol_races 
INNER JOIN lol_champions ON lol_champions.race_id = lol_races.race_id
GROUP BY lol_races.name;
 
/* * * * * * * * * * * * * * * * * * * *
 Champions with [occupation]
 * * * * * * * * * * * * * * * * * * * */

/* * * * * * * * * * * * * * * * * * * *
 Champion Romantic Connections 
 * * * * * * * * * * * * * * * * * * * */

 /* * * * * * * * * * * * * * * * * * * *
 Champion not loyal to starting faction
 * * * * * * * * * * * * * * * * * * * */
