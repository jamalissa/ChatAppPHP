<?php
    header('Content-Type: application/json; charset=utf-8');
    $fname='message.txt';
    if(isset($_GET['message']) || isset($_GET["clearCommand"])){
       $long = $_GET['long'];
       $lat = $_GET['lat'];
       $userInformation = "$long;$lat";
        
    
        // speichern der Eingabe in externe Datei
        if (isset($_GET["message"])){
            if ($_GET["message"] != "noMessage"){
                $message = urldecode($_GET["message"]);
                if (isset ($_GET['whoAmI']) ){
                    $WhoAmI = $_GET['whoAmI'];
                }    else 
                    $WhoAmI = "nobody";
                    
                $output = $WhoAmI.";$message;".$userInformation."\n";
        
                $fname = "message.txt"; 
                $handle = fopen($fname, "a");
                if ($handle) { 
                    if (flock($handle, LOCK_EX)) { // exklusive Sperre
                        fputs($handle, $output); 
                        flock($handle, LOCK_UN); // Gib Sperre frei
                        fclose($handle); 
                    }
                }
            } 
        } 
        if (isset($_GET["clearCommand"])){
            if ($_GET["clearCommand"]=="clear"){
                $fname = "message.txt"; 
                $handle = fopen($fname, "w");
                if ($handle) 
                    fclose($handle);
           }
        }
    } 

        $handle = fopen($fname, 'r');
        if($handle != FALSE) {
            // leeres messages array -> hier stehen alle messages drin
            $messages = array();
            while(!feof($handle)) {
                $zeile =fgets($handle);
                if (strcmp ('', $zeile)!=0){
                    $arrayOfData = explode(';', $zeile);
                    // erstellen eines message-arrays für jede message
                    $message = array(
                        "name"=>$arrayOfData[0],
                        "message"=>$arrayOfData[1],
                        "long"=>$arrayOfData[2],
                        "lat"=>  $arrayOfData[3],
                       
                    );
                    // füge message dem mesages-array hinzu
                    array_push($messages,$message);
                }
            }   
            $json = json_encode($messages);
            //return $json;
            print($json);
        }
        fclose($handle);
    
            
?>