<!DOCTYPE html>
<html>
<title>Lote 10 Home Automation Server</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css"-->
<link rel="stylesheet" href="aco_styles.css">
<body>

   
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

<ul class="topnav">
  <li><a class="active" href="site2.php" target="iframe_a">Home</a></li> 
  <li><a href="programar.php" target="iframe_a">Inserir Programacao</a></li>
  <li><a href="temperatura.php" target="iframe_a">Temperatura</a></li>
  <li><a href="userstats.php" target="iframe_a">Historico Temperatura</a></li>  
  <li><a href="p_change.php" target="iframe_a">Alterar Password</a></li>  
  <li class="right"><a href="logout.php">Logout</a></li>
    <p color: white ><?php echo "Welcome: ".$logado; ?></p>
</ul>
    
<div style="padding:0 16px;">
    
  
<iframe  height="520px" width="100%" frameborder="no" src="site2.php" name="iframe_a">

</iframe>

<!-- End Code from frame external --height="500px"------------------------------------------------------------------->
</div>



</body>
</html>

