# leagueOfLegendsUniverse
lore database
Database Outline

I am designing a database to keep track of details of the League of Legends lore.

A Region has an id number and a name. It is uniquely identified by it’s id number. Every Region name is unique.
A Faction has an id number and a name. It is uniquely identified by it’s id number. Every Faction name is unique.
A Race has an id number and a name. It is uniquely identified by it’s id number. Every Race name is unique.
An Occupation has an id number and a title. It is uniquely identified by it’s id number. Every occupation title is unique.
An Alias has an id number, a name, and a Champion. It is uniquely identified by it’s id number. An Alias name is unique.
A Champion has an id number, a name, a gender, a Race, a Region and Faction of origin, and a release date. A Champion is uniquely defined by his/her id number. Ever champion name is unique.
A Champion may have 0 or 1 Faction of origin. A Champion may have 0 or 1 Region of Origin. A Champion may be 0 or 1 race. No Total Participation.
A Champion may have an allegience to 0 or more Factions. No total participation.
A Champion may have 0 or more Occupations. A Champion may have 0 or more Aliases. No total participation.
A Faction can be associated with 0 or more Champions. A Region can be associated with 0 or more Champions.
No total participation.
A Race can be associated with 0 or more Champions. No total participation.
An occupation is associated with 0 or more Champions. No total participation.
An Alias is associated with 1 Champion. Total participation.
A Champion may have a Relationship with another Champion. The Relationship has an id number and may be one of relation, romance, alliance, and/or rivalry. A Champion may have a Relationship with 0 or more Champions. No total participation.
