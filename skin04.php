 <?php
require("sessao.php");
include("template.php");  
require 'dbtest.php';  //database connection var: $conn

$logado = $_SESSION['login'];
$IP_Modulos = $_SESSION['ip'];
$device_adr="'http://".$IP_Modulos."/t'";
$conn->close();
?>

<div class="container">
  <h2>IoT Tecnologies By 2AC</h2>
    
<form action="skin04.php" method="post">
    <p>LG Air Condittioner LG09AH </p>
    <br>
    <input class="bvermelho" type="submit" name="LGOn24H" value="Aquecendo " />
    <br><br>
    <input class="bazul" type="submit" name="LGOn18C" value="Arrecendo "/>
    <br><br>
    <input class="bpreto" type="submit" name="OFF_LG" value="Desligando "/><br>
  
    <p>Auxiliar Output</p>
    <input class="bround" type="submit" name="ON4" value="+ " />
    <input class="bround" type="submit" name="OFF4" value="-"/><br><br>
    
    <div class="w3-progress-container">
        <div id="temperatura" class="w3-progressbar w3-green" style="width:0%"></div>
    </div>

    
</form>
  
</div>

   
<?php

$str='NOP';

 if(isset($_POST['LGOn24H'])){
        //echo "Aquecendo a 24C";
        $str = 'LGOn24H';
    }else if(isset($_POST['LGOn18C'])){
        //echo "Arrefecendo a 18C";
        $str ='LGOn18C'; 
    }else if(isset($_POST['OFF_LG'])){
        //echo "Desligando";
        $str = 'OFF_LG';
    }else if(isset($_POST['ON4'])){
        //echo "Ligando Auxiliar";
        $str = 'ON4';
    }else if(isset($_POST['OFF4'])){
        //echo "Desligando Auxiliar";
        $str = 'OFF4';
    }
    
  if( $str != 'NOP'){
    
    $lines = file("http://".$IP_Modulos."/?pin=".$str );
    $IoT_OK= in_array('IoT Tecnologies By 2AC',$lines);
    $Success_OK=in_array('Achieved',$lines);

    if (strpos($lines[0], "IoT Tecnologies By 2AC") == false){
        echo '<script type="text/javascript">',' alert("The IoT device is missing!");','</script>';
     }
    if (strpos($lines[0], "Achieved") == true){
        echo '<script type="text/javascript">',' alert("Information Sended sucessully to the IoT device!");','</script>';
    }   
  }  
    
    
?>
    


</BODY>
<script>
var myVar = setInterval(myTimer, 3000);

function myTimer() {
    var width = httpGet(<?php echo $device_adr; ?>);
    var elem = document.getElementById("temperatura");  
    elem.innerHTML = width;
    elem.style.width = 2.5 * width + '%'; 
}

  function httpGet(theUrl)
  {
    var xmlHttp = null;

    xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false );
    xmlHttp.send( null );
    return xmlHttp.responseText;
  }
  
</script>
</HTML>
