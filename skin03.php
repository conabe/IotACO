 <?php
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

?>

<form action="skin03.php" method="post">
    
<div class="container">
   
    <p>LG Air Condittioner LG09AH (remote)</p>
    <br>
    <input class="bazul w3-red" type="submit" name="LGOn24H" value="Aquecendo " />
    <br><br>
    <input class="bazul w3-blue-grey" type="submit" name="LGOn18C" value="Arrecendo "/>
    <br><br>
    <input class="bazul w3-black" type="submit" name="OFF_LG" value="Desligando "/><br>
    <?php 
        echo "TEMP: ".$row['temp']."<br>";
        echo "<p style='font-size: 10px;'>";
        echo "Date: ".$row['reg_date']."</p>";
    ?>
    </div>

<div class="container">
    <p>Devices Statistics</p>
    <input class="bazul w3-blue-grey" type="submit" name="HIST" value="Historico "/>
    <br><br>
    <input class="bazul w3-black" type="submit" name="PROG" value="Programacao "/><br> 
</div>      
<div class="container">
    <p>Auxiliar Output</p>
    <input class="bround" type="submit" name="ON4" value="+ " />
    <input class="bround" type="submit" name="OFF4" value="-"/><br>
</div>    
  
</form>
  


   
<?php

$str='NOP';

 if(isset($_POST['LGOn24H'])){
        //echo "Aquecendo a 24C";
        $str = 'LGOn24H';
        $onoff=1;                             // 1-> ON Heat +24C LG System AC
    }else if(isset($_POST['LGOn18C'])){
        //echo "Arrefecendo a 18C";
        $str ='LGOn18C'; 
        $onoff=2;                            // 2-> ON Cool +20C LG System AC
    }else if(isset($_POST['OFF_LG'])){
        //echo "Desligando";
        $str = 'OFF_LG';
          $onoff=0;                          // 0-> OFF LG System AC   
    }else if(isset($_POST['ON4'])){
        //echo "Ligando Auxiliar";
        $str = 'ON4';
        $onoff=14;                            // 14 -> ON D4   
    }else if(isset($_POST['OFF4'])){
        //echo "Desligando Auxiliar";
        $str = 'OFF4';
        $onoff=24;                            // 24 --> OFF D4 
    }else if(isset($_POST['PROG'])){
        //echo "Historico de Temperatura";
        header('location:programar.php');
    }else if(isset($_POST['HIST'])){
        //echo "Inserir Programacao";
        header('location:userstats.php');
    }
    
  if( $str != 'NOP'){
    $week_day=(date("w", time()));
    $agora=date("Y-m-d H:i:s",time());
    $sql = "INSERT INTO programas (onoff, days, hora, divisao, ip, device) ";
    $sql .= "VALUES ('$onoff','$week_day', '$agora', 'recado', '$ip1', '$ip_parts[3]')";
     
    if (mysqli_multi_query($conn, $sql)) {
            echo '<script type="text/javascript">',' alert("Information recorded to IoT device!");','</script>';
        }else {
            echo '<script type="text/javascript">',' alert("Error");','</script>';
    }
    
  }  
   $conn->close();         
?>
    


</BODY>
</HTML>
