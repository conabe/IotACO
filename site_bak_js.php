<!DOCTYPE html>
<html>
<title>Lote 10 Home Automation Server</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<!-- <link rel="stylesheet" href="w3.css"> -->
<body>

<nav class="w3-sidenav w3-white w3-card-2 w3-animate-left" style="display:none" id="mySidenav">
  <a href="javascript:void(0)"
  onclick="w3_close()"
  class="w3-closenav w3-xlarge">Close &times;</a>
      <a href="site2.php" target="iframe_a">Home </a>
      <a href="programar.php" target="iframe_a">Inserir Programacao</a>
      <a href="temperatura.php" target="iframe_a">Temperatura</a>
      <a href="userstats.php" target="iframe_a">Historico Temperatura</a>
      <a href="p_change.php" target="iframe_a">Alterar Password</a>
      <a href="logout.php">Logout</a>
</nav>

<?php
/*Confirma se existe sessao iniciada*/
session_start();

if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
{
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:index.php');
    }

$logado = $_SESSION['login'];
$IP_Modulos = $_SESSION['ip'];

 if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){
    }else if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
    $_SESSION['screen_width'] = $_REQUEST['width'];
    $_SESSION['screen_height'] = $_REQUEST['height'];
    header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
    echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';
    }




?>

<div id="main">

<header class="w3-container w3-blue-grey">
  <span class="w3-opennav w3-xlarge" onclick="w3_open()" id="openNav">&#9776;</span>
  <h2>Lote 10 Home Automation Server</h2>
  <p><?php echo "Welcome: ".$logado; ?></p>
  
  </header>
<div class="w3-container">
<!-- Code from frame external ------------------------------------------------------------------------->

<iframe height="500px" width="100%" frameborder="no" src="site2.php" name="iframe_a">

</iframe>

<!-- End Code from frame external --------------------------------------------------------------------->
</div>


</div>

<script>
function w3_open() {
  if(screen.width > 360 ){
    document.getElementById("main").style.marginLeft = "30%";
    document.getElementById("mySidenav").style.width = "30%";
    }else{
    document.getElementById("main").style.marginLeft = "100%";
    document.getElementById("mySidenav").style.width = "100%";      
    }
  document.getElementById("mySidenav").style.display = "block";
  document.getElementById("openNav").style.display = 'none';  
}
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidenav").style.display = "none";
  document.getElementById("openNav").style.display = "inline-block";
}
</script>

</body>
</html>

