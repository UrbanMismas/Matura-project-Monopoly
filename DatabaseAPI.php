<?php

function createLobby (){
    $database = new SQLite3("Monopoly.db");
    $sql = 'INSERT INTO Lobby (idRules,LobbyName)
    VALUES (0,"New Lobby");';
    $database->exec($sql);
    $sql = 'SELECT idLobby FROM Lobby ORDER BY idLobby DESC LIMIT 1;';
    $lobbyID = $database->query($sql)->fetchArray();
    return $lobbyID["idLobby"];
}

function createHost ($lobbyID){
    $database = new SQLite3("Monopoly.db");
    $statement = $database->prepare('INSERT INTO PlayerList (idPlayer, idLobby, Host, playerName, Avatar)
    VALUES (:PlayerNumber, :lobbyID, 1, "New Player","NoAvatar.png");');
    $statement->bindValue(':lobbyID', $lobbyID);
    $statement->bindValue(':PlayerNumber', numOfPlayers($lobbyID));
    $statement->execute();
}

function createPlayer ($lobbyID){
    $database = new SQLite3("Monopoly.db");
    $statement = $database->prepare('INSERT INTO PlayerList (idPlayer, idLobby, playerName, Avatar)
    VALUES (:PlayerNumber, :lobbyID, "New Player","NoAvatar.png");');
    $statement->bindValue(':lobbyID', $lobbyID);
    $statement->bindValue(':PlayerNumber', numOfPlayers($lobbyID));
    $statement->execute();
}

function getPlayerList ($lobbyID){
    $database = new SQLite3("Monopoly.db");
    $sql = 'SELECT *
            FROM PlayerList 
            WHERE idLobby;';
    
    $statement = $database->prepare('SELECT *
    FROM PlayerList 
    WHERE idLobby = :lobbyID;');

    $statement->bindValue(':lobbyID', $lobbyID);
    $n=$statement->execute();

    $players=array();
    $player=$n->fetchArray();
    while(isset($player) && $player!=false){
        $players[]=$player;
        $player=$n->fetchArray();

    }
    return $players;
}

function numOfPlayers ($lobbyID){
    $database = new SQLite3("Monopoly.db");
            
    $statement = $database->prepare('SELECT COUNT (idLobby)
    FROM PlayerList 
    WHERE idLobby = :lobbyID
    GROUP BY idLobby;');

    $statement->bindValue(':lobbyID', $lobbyID);
    $n=$statement->execute()->fetchArray()[0];

    if($n==NULL)
        $n=0;
    return $n;
}

function listOfLobbies(){
    $database = new SQLite3("Monopoly.db");
            
    $statement = $database->prepare('SELECT Lobby.idLobby, Lobby.LobbyName, Lobby.EntryPassword, PlayerList.playerName, Rules.RuleType, Rules.MaxPlayers
    FROM Lobby INNER JOIN PlayerList ON (Lobby.idLobby=PlayerList.idLobby) 
    INNER JOIN Rules ON (Lobby.idRules=Rules.idRules)
    WHERE PlayerList.Host = 1 ; ');

    $n=$statement->execute();

    $lobbies=array();
    $lobby=$n->fetchArray();
    while(isset($lobby) && $lobby!=false){
        $lobbies[]=$lobby;
        $lobby=$n->fetchArray();
    }
    return $lobbies;
}


?>