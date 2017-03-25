 <?php
require("sessao.php");
include("template.php"); 


?>

 
  <div class="container">
    <h2>Quarto da Carolina</h2>

  <a href="?ip=192.168.1.51&pin=LGOn24H"><button class="bvermelho">Heat to 24C</button></a>
  <a href="?ip=192.168.1.51&pin=LGOn18C"><button class="bazul">Cool to 20C</button></a>
  <a href="?ip=192.168.1.51&pin=OFF_LG"><button class="bpreto">PowerOff IoT</button></a>

  </div>

  <div class="container">
    <h2>Quarto da Mafalda</h2>
    
  <a href="?ip=192.168.1.53&pin=LGOn24H"><button class="bvermelho">Heat to 24C</button></a>
  <a href="?ip=192.168.1.53&pin=LGOn18C"><button class="bazul">Cool to 20C</button></a>
  <a href="?ip=192.168.1.53&pin=OFF_LG"><button class="bpreto">PowerOff IoT</button></a>

  </div>

  <div class="container">
    <h2>Suite</h2>
    
  <a href="?ip=192.168.1.52&pin=LGOn24H"><button class="bvermelho">Heat to 24C</button></a>
  <a href="?ip=192.168.1.52&pin=LGOn18C"><button class="bazul">Cool to 20C</button></a>
  <a href="?ip=192.168.1.52&pin=OFF_LG"><button class="bpreto">PowerOff IoT</button></a>
  
       <p>Temp: <?php
            //$lines = file("http://192.168.1.52/t");
            echo $lines[0];
            ?>

  </div>
    
  <div class="container">
    <h2>Sala</h2>
    
  <a href="?ip=192.168.1.54&pin=LGOn24H"><button class="bvermelho">Heat to 24C</button></a>
  <a href="?ip=192.168.1.54&pin=ON4"><button class="bazul">Cool to 20C</button></a>
  <a href="?ip=192.168.1.54&pin=OFF4"><button class="bpreto">PowerOff IoT</button></a>
  
       <p>Temp: <?php
            //$lines = file("http://192.168.1.54/t");
            //echo $lines[0];
            echo $GLOBALS['temp_sala'];
            ?>
       </p>
  </div>

<?php
//----------------- Send command to IoT device and get somme feadback --------------------------------------------------
$operacao = htmlspecialchars($_GET["pin"]);
$ip= htmlspecialchars($_GET["ip"]);
echo $ip;
echo $operacao;
if ( strlen($ip) == 12){
    unset($_GET);
    header('location:cockpit.php');
    $lines = file("http://".$ip."/?pin=".$operacao );
    $IoT_OK= in_array('IoT Tecnologies By 2AC',$lines);
    $Success_OK=in_array('Achieved',$lines);
 }

?>

</BODY>
</HTML>
