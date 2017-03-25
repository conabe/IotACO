<?php

require("sessao.php");
include("template.php");


$SKIN= $_SESSION['skin'];

if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){
    }else if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
        $_SESSION['screen_width'] = $_REQUEST['width'];
        $_SESSION['screen_height'] = $_REQUEST['height'];
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        echo '<script type="text/javascript">window.location = "' 
        . $_SERVER['PHP_SELF'] 
        . '?width="+screen.width+"&height="+screen.height;</script>';
    }

if ($logado == "root") {   //-------------------If root ------------------------------
      echo " <div class='w3-container'>";
      echo "<h2><p>Funcoes Especificas de root</p></h2>";
      echo "<p>Infomation and server support: <a href='iotaco.php'>here</a></p>";
      echo "<p>Configurar <a href='users.php'>Utilizadores</a> and <a href='devices.php'>Devices</a></p>";
      echo "<p>Log de opercaoes programas <a href='logprog.php'>here</a></p>";
      echo "<p>Log Acess and Operations <a href='logoperations.php'>here</a></p>";
      echo "<p>Force Timer <a href='timer.php'>here</a></p>";
      echo "<p>Run Cockpit <a href='cockpit.php'>here</a></p>";
      echo "<p>Server Information <a href='phpinfo.php'>here</a></p>";
      echo "<p>Data analysis (temperature, erros and alarms)"
           ."<a href='rootstats.php'>New version(Device Id) </a>";
      echo " or <a href='rootstats_b.php'>Old version (Device IP)</a></p>";
      echo "<p>Change <a href='setup_user.php'>Setup User </a>";
      echo " and test <a href='home.php'>home</a></p>";
      echo " <p><a href='programar.php'>Programe</a>,<a href='temperatura.php'>"
      . "Live Temperature</a>,<a href='userstats.php'>User Statistics,</a></p>";
      echo "<p>Configure Notifications <a href='notifications.php'>here</a></p>";
      //echo "<p>Carregar Dados <a href='/carregar.php'>here</a></p>";
      echo "<p>Send Mail <a href='sendmail.php'>(mode 1)</a>"
            . " or <a href='sendmail2.php'>(mode 2)</a></p>";   
      //Enviroment information
      echo "<h2>Enviroment Information </h2>";
      echo "<p> PHP Version:".phpversion()."<br>";
      
      echo "Device=".$_SESSION['device']."<br>";
      echo "IP=".$_SESSION['ip']."<br>";
      echo "Skin=".$_SESSION['skin']."<br>";     
      
      
      if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){
        echo 'User resolution: ' . $_SESSION['screen_width'] . 'x' . $_SESSION['screen_height'];
        }
      echo "</div>";  
     }

else{    // If someone else
    header('location:device_select.php');    
    }
?>
</BODY>
</HTML>
