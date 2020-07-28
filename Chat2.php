<html>
    <head>
        <title>Chat P2</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="stylesheet.css" />
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/2.2.3/jquery.min.js"></script>
        
    </head>
    <body>
        <h3>CP2</h3>




        <form >
            Message:<input type="text" id="message">
            <p><input type="button" value="Senden" onclick="senden()"></p>
            <p><input type="button" value="Clear" onclick="myClear()"></p>

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
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }
            }

            function takePosition(position) {
                lat =  position.coords.latitude;
                long = position.coords.longitude;
            }


            onload = (function () {
                //startajax();
                getLocation();
                setInterval(function(){ startajax(); }, 5000);
            });


            function startajax () {	
                console.log("Start Ajax");
                $.ajax({
                    url: ('HandleMessage.php'),
                    data: { 'message': sendString,
                            'clearCommand': clearCommand,
                            'whoAmI': "CP2",
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
                        if (element.name == "CP2") {
                            output += '<p class=\"ich\">ICH: ' + element.message + '</p>';
                        } else {
                            output += '<p class=\"remote\">CP1: ' + element.message + '</p>';
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