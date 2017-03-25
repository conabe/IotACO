 <?php
//Send the information direct to the device
//Works on local Netowork Only 
require("sessao.php");
include("template.php");  
require 'dbtest.php';  //database connection var: $conn

$IP_Modulos = $_SESSION['ip'];

//Find Last temp in database:
$ip_parts = explode (".", $IP_Modulos);


$sql= "select * from temperaturas where device='";
$sql .= $ip_parts[3];
$sql .= "' order by reg_date desc limit 1";

require 'dbtest.php';            //Get acesso to MySql DB
$result = $conn->query($sql);    //Runs Query 

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    }
$conn->close();

?>

<form action="skin02.php" method="post">
    
<div class="container">
   
    <p>LG Air Condittioner LG09AH (remote)</p>
    <br>
    <input class="bazul w3-red" type="submit" name="LGOn24H" value="Aquecendo " />
    <br><br>
    <input class="bazul w3-blue-grey" type="submit" name="LGOn18C" value="Arrecendo "/>
    <br><br>
    <input class="bazul w3-black" type="submit" name="OFF_LG" value="Desligando "/><br>
    </div>
<div class="container">
    <p>Auxiliar Output</p>
    <input class="bround" type="submit" name="ON4" value="+ " />
    <input class="bround" type="submit" name="OFF4" value="-"/><br>
    <?php 
        echo "TEMP: ".$row['temp']."<br>";
        echo "<p style='font-size: 10px;'>";
        echo "Date: ".$row['reg_date']."</p>" 
    ;?>
    </div>
<div class="container">
    <p>Devices Statistics</p>
    <input class="bazul w3-blue-grey" type="submit" name="HIST" value="Historico "/>
    <br><br>
    <input class="bazul w3-black" type="submit" name="PROG" value="Programacao "/><br> 

 </div>   
</form>

   
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
    }else if(isset($_POST['PROG'])){
        //echo "Historico de Temperatura";
        header('location:programar.php');
    }else if(isset($_POST['HIST'])){
        //echo "Inserir Programacao";
        header('location:userstats.php');
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
</HTML>
