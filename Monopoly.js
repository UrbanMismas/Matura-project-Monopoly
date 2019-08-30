let Location = "Home";
let LobbyID;
let PlayerID;

Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}

function SetButtons(){
    var something = document.getElementById('testButton');

    something.style.cursor = 'pointer';

    something.onmouseover = function() {
        this.style.backgroundColor = 'red';
    };
    something.onmouseout = function() {
        this.style.backgroundColor = 'green';
    };

}

function Join(){

    Location="LobbyList"

    let xhr = new XMLHttpRequest();

    xhr.open('GET', 'JoinGame.php', true);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("menu").innerHTML = this.responseText;
            
            SetLobbyList();
        }
    };
    xhr.send(null);
    
}

function SetLobbyList(){
    RefreshLobbies();
}


function RefreshLobbies(){
    if(Location=="LobbyList"){
        let xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var lobbies = document.getElementById('Lobbies');
            lobbies.innerHTML="";
            //lobbies.innerHTML=this.responseText;

            var obj = JSON.parse(this.responseText);

            for(let i=0; i<obj.length;i++){
                var newEntry=document.createElement("div");
                newEntry.className="lobbyListElement";

                var entryText=document.createElement("div");
                entryText.className="LobbyName";
                entryText.innerHTML=obj[i]["LobbyName"];

                var Host=document.createElement("div");
                Host.className="Host";
                Host.innerHTML="Hosted by: " + obj[i]["playerName"];

                var Join=document.createElement("div");
                Join.className="Button JoinButton";
                Join.id=obj[i]["idLobby"];
                if(obj[i]["GameActive"]==1){
                    Join.innerHTML="Spectate";
                    Join.onclick= OnClickSpectate;
                }else{
                    Join.innerHTML="Join";
                    Join.onclick= OnClickJoin;
                }

                newEntry.appendChild(entryText);
                newEntry.appendChild(Host);
                newEntry.appendChild(Join);
                lobbies.appendChild(newEntry);
                /*
                Avatar.src="images/"+obj[i]["Avatar"];
                Avatar.className="Avatar";
                var entryText=document.createElement("div");
                entryText.innerHTML=obj[i]["playerName"];
                entryText.className="MenuPlayerName";
                newEntry.appendChild(Avatar);
                newEntry.appendChild(entryText);
                playerList.appendChild(newEntry);
                */
            
            }
            setTimeout(RefreshLobbies, 5000);
        };
        xhr.open('POST', 'ServerAPI.php');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("INeed=Lobbies");
    }
}

function OnClickJoin(){
	LobbyID=this.id;
    LoadLobbyOnScreen();

    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
        PlayerID=this.responseText;
        SetLobby();
    };
    xhr.open('POST', 'ServerAPI.php');
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("INeed=JoinLobby&LobbyID="+LobbyID);
}

function Create(){

    LoadLobbyOnScreen();

    let xhr = new XMLHttpRequest();
    xhr.onload = function() {
        LobbyID=this.responseText;
        PlayerID=0;
        SetLobby();
    };
    xhr.open('POST', 'ServerAPI.php');
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("INeed=NewLobby");
}


function LoadLobbyOnScreen(){
    let xhr = new XMLHttpRequest();

    xhr.open('GET', 'Lobby.php', true);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("menu").innerHTML = this.responseText;
            SetMenu();
        }
    };
    xhr.send(null);
}

function SetMenu(){
    
}

function SetLobby(){
    
    Location="Lobby"
    RefreshPlayers();
}

function RefreshPlayers(){
    if(Location=="Lobby"){
        let xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var playerList = document.getElementById('players');
            playerList.innerHTML="";
            //playerList.innerHTML=this.responseText;

            var obj = JSON.parse(this.responseText);

            for(let i=0; i<obj.length;i++){
                var newEntry=document.createElement("div");
                newEntry.className="playerListElement";

                var Avatar=document.createElement("img");
                Avatar.src="images/"+obj[i]["Avatar"];
                Avatar.className="Avatar";
                
                var entryText=document.createElement("div");
                entryText.innerHTML=obj[i]["playerName"];
                entryText.className="MenuPlayerName";


                newEntry.appendChild(Avatar);
                newEntry.appendChild(entryText);
                playerList.appendChild(newEntry);
            }

            setTimeout(RefreshPlayers, 5000);
        };

        xhr.open('POST', 'ServerAPI.php');
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("INeed=Players&LobbyID="+LobbyID);
    }

}

function GoHome(){

    let xhr = new XMLHttpRequest();

    xhr.open('GET', 'Home.php', true);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("menu").innerHTML = this.responseText;
            SetMenu();
        }
    };
    xhr.send(null);

    if(Location=="Lobby"){
        
        let _xhr = new XMLHttpRequest();
        _xhr.open('POST', 'ServerAPI.php');
        _xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        _xhr.send("INeed=LeaveLobby&PlayerID="+PlayerID+'&LobbyID='+LobbyID);
    }

    Location="Home";
}

function StartGame(){
    document.getElementById("everything").remove();
    let _xhr = new XMLHttpRequest();
    _xhr.open('POST', 'ServerAPI.php');
    _xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    _xhr.send("INeed=StartGame&LobbyID="+LobbyID);
}