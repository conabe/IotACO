<?php
require("sessao.php");
include("template.php");  
require 'dbtest.php';     //database connection var: $conn

$IP_Modulos = $_SESSION['ip'];
$SKIN= $_SESSION['skin'];
?>

<div class="container">
  <h2>IoT Tecnologies By 2AC</h2>
  <p>LG Air Condittioner LG09AH </p>

  <p><a href="?pin=LGOn24H"><button class="bvermelho">Heat to 24C</button></a></p>
  <p><a href="?pin=LGOn18C"><button class="bazul">Cool to 20C</button></a></p>
  <p><a href="?pin=OFF_LG"><button class="bpreto">PowerOff IoT</button></a></p>
</div>

<div class="container">
  <p>Auxiliar Output</p>
  <p><a href='?pin=ON4'><button class="bround">+</button></a>
  <a href='?pin=OFF4'><button class="bround">-</button></a></p>
</div>

<?php
//----------------- Send command to IoT device and get somme feadback --------------------------------------------------
$operLG = htmlspecialchars($_GET["pin"]);
$lines = file("http://".$IP_Modulos."/?pin=".$operLG );
$IoT_OK= in_array('IoT Tecnologies By 2AC',$lines);
$Success_OK=in_array('Achieved',$lines);

if (strpos($lines[0], "IoT Tecnologies By 2AC") == false){
     echo '<script type="text/javascript">',' alert("The IoT device is missing!");','</script>';
     }
 if (strpos($lines[0], "Achieved") == true){
    echo '<script type="text/javascript">',' alert("Information Sended sucessully to the IoT device!");','</script>';
  }

?>

<?php
//-------------- Create a Log Operation ------------------------------------------------------------------------------------
if (strpos($lines[0], "IoT Tecnologies By 2AC") == true){ //sucess!!
            //Update table with timestamp ----------------------------------------------------------------------------------
            $sqllog = "INSERT INTO logen (divisao, sucesso, ip,operacao ) VALUES ('$logado','OK','$IP_Modulos','$operLG')";
            }
else{
            //echo "<p>Cammand fail</>>";
            $sqllog = "INSERT INTO logen (divisao, sucesso, ip,operacao ) VALUES ('$logado','FAIL','$IP_Modulos','$operLG')";
            }
$conn->query($sqllog);
//Close connection --------------------------------------------------------------------------------------------------------
$conn->close();
?>
</BODY>
</HTML>
