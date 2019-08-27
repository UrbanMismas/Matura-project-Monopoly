<?php

$database = new SQLite3("Monopoly.db");


/*
$sql = 'CREATE TABLE Rules(
idRules INTEGER PRIMARY KEY
)';
$database->exec($sql);
*/

/*
$sql = 'CREATE TABLE Lobby(
idLobby INTEGER PRIMARY KEY,
lobbyGET TEXT,
idRules INTEGER,
FOREIGN KEY(idRules) REFERENCES Rules(idRules)
)';
$database->exec($sql);
*/

/*
$sql = 'CREATE TABLE "Player" (
	"idPlayer"	INTEGER,
	"playerName"	TEXT,
	"Avatar"	TEXT,
	"idLobby"	INTEGER,
	PRIMARY KEY("idPlayer","idLobby"),
	FOREIGN KEY("idLobby") REFERENCES "Lobby"("idLobby")
);';
$database->exec($sql);
*/

/*
$sql = 'INSERT INTO Rules
VALUES (0)';
$database->exec($sql);
*/

?>