<?php

require_once "DataBaseAPI.php";

if(isset($_POST["INeed"])){
    switch ($_POST["INeed"]){

        case "NewLobby":
            $lobbyID = createLobby();
            createHost($lobbyID);
            echo $lobbyID;
        break;

        case "JoinLobby":
            if(isset($_POST["LobbyID"])){
                createPlayer($_POST["LobbyID"]);
                echo numOfPlayers($_POST["LobbyID"])-1;
            }
        break;

        case "Players":
            if(isset($_POST["LobbyID"])){
                echo json_encode(getPlayerList($_POST["LobbyID"]));
            }
        break;

        case "Lobbies":
            $LobbyList=listOfLobbies();
            for($i=0;sizeof($LobbyList)>$i;$i++){
                $numOfP=numOfPlayers($LobbyList[$i]["idLobby"]);
                $LobbyList[$i][sizeof($LobbyList)+1]=$numOfP;
                $LobbyList[$i]["activePlayers"]=$numOfP;
            }
            echo json_encode($LobbyList);
        break;

        case "LeaveLobby":
            if(isset($_POST["PlayerID"])&&isset($_POST["LobbyID"])){
                RemovePlayer($_POST["PlayerID"],$_POST["LobbyID"]);
                
            }
        break;

        case "StartGame":
        if(isset($_POST["LobbyID"])){
            createGame($_POST["LobbyID"]);
            update("Lobby","idLobby",$_POST["LobbyID"],"GameActive","1");
        break;
    }
}
?>



