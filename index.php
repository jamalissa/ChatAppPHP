<html>
    <head>
        <title>Chat P11</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="stylesheet.css" />
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/2.2.3/jquery.min.js"></script>
        
    </head>
	<style type="text/css">
    p.entspannt { color:green; }
    p.kritisch { color:red; }
     span.dsa { color:blue; }
</style>
    <body>
        <h3>CP1</h3>
<?php

$nr =habib;
$x=dsa;
//echo "<span class=$x>\"LAt\":$nr </span>,\"bra\"$x";

?>



        <form >
            Message:<input type="text" id="message">
            <p><input type="button" value="Senden" onclick="senden()"></p>
            <p><input type="button" value="Clear" onclick="myClear()"></p>
             
        </form>
        
        <form action="http://jamalhosting6-com.stackstaging.com/Chat2.php" method="get" target="_blank">
         <button type="submit">Chat2</button>
          </form>
      
 
           
      
        <!-- Ajax-Anfrage hier direkt in der .php -->
        <script>

        var sendString = "noMessage";
        var clearCommand="";
        var long = "8";
        var lat = "50";



            function senden(){
                var inputString= document.getElementById('message').value;
                if(inputString!= ""){
                    sendString = document.getElementById('message').value;
                    window.document.forms[0].reset();
                    sendString = encodeURI(sendString);
                    startajax();
                    
                }
            }

















            function myClear(){
                
                clearCommand = "clear";
                //window.document.forms[0].reset();
                startajax();
            }


            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(takePosition);
                } else { 
                    document.getElementById("messageContent").innerHTML = "Geolocation is not supported by this browser.";
                }
            }

            function takePosition(position) {
                lat =  position.coords.latitude;
                long = position.coords.longitude;
            }














            
            onload = (function () {
                //startajax();
                getLocation();
                setInterval(function(){ startajax(); }, 1000);
            });


            function startajax () {	
                console.log("Start Ajax");
                $.ajax({
                    url: ('HandleMessage.php'),
                    data: { 'message': sendString,
                            'clearCommand': clearCommand,
                            'whoAmI': "CP1",
                            'long':long,
                            'lat': lat,
                        },
                    type: 'GET',
                    timeout: 1000,
                    dataType: 'json',
                    error: errorOccured,
                    success: sowMessage
                    
                }) 
            }


            function sowMessage (data) {	
                console.log(data);
                var output = "";
                data.forEach(element => {
                        if (element.name == "CP1") {
                            output += '<p class=\"ich\">ICH: ' + element.message + '</p>';
                        } else {
                            output += '<p class=\"remote\">CP2: ' + element.message + '</p>';
                        }
                    });
                document.getElementById("messageContent").innerHTML = output;
                sendString = "noMessage";
                clearCommand="";
                
            }

            function errorOccured () {
                document.getElementById("messageContent").innerHTML = "Fehler: Es konnten keine Daten empfangen werden";
            }
            



            
        </script>
        <div id="messageContent"><!--Hier kommen die Messages hin--></div>
    </body>
</html>