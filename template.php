<!DOCTYPE html>
<html>
<title>Lote 10 Home Automation Server</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="aco_styles.css">

<nav class="w3-sidenav w3-white w3-card-2 w3-animate-left" style="display:none" id="mySidenav">
  <a href="javascript:void(0)"
  onclick="w3_close()"
  class="w3-closenav w3-xlarge">Close &times;</a>
      <a href="site2.php" >Home  </a>
      <a href="p_change.php" >Alterar Password</a>
      <a href="logout.php">Logout</a>
</nav>
    
<div id="main">

<header class="w3-container aco-color ">
  <span class="w3-opennav w3-xlarge" onclick="w3_open()" id="openNav">&#9776;</span>
  <h2>Lote 10 Home Automation Server</h2>
  <p><?php echo "Welcome: ".$_SESSION['login']."/".$_SESSION['divisao']; ?></p>
</header> 
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
