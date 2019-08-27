 <html>
    <head>
        <link rel="stylesheet" 
            type="text/css" 
            href="Monopoly.css">
        <link rel="stylesheet" 
            type="text/css" 
            href="Menu.css">
        <script src="Monopoly.js">
        </script>
        <link rel="icon" 
            type="image/jpg" 
            href="favicon.jpg">
    </head>
    <body>
        <div id="header">
        </div>
        <div id="game">

            <div id="middleBar">
                
                <div id="testButton">
                    click me!
                </div>
            </div>
            <div id="playersSideBar">
            </div>

            <div id="separatorLeft" class="separator">
            </div>
            <div id="boardSpace">
                <div id="board">
                    <div id="boardContent">
                        hello
                    </div>
                </div>
            </div>
            <div id="separatorRight" class="separator">
            </div>

        </div>
        <?php
        if(!isset($_COOKIE['inGame'])){
            echo'
            <div id="everything" class="screenDim">
                <div id="menu">
                    <div id="join" class="menuButton" onclick="Join()">
                        Join game
                    </div>
                    <div id="create" class="menuButton" onclick="Create()">
                        Create game
                    </div>
                </div>
            </div>';
        }
        ?>
    </body>
    <script>SetButtons();</script>
</html>