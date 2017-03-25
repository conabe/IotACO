 <?php
 //List all devices from a user
require("sessao.php");
include("template.php"); 
include("dbtest.php");   //File contais DataBase Start $conn

//Get Screen Size
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

// Print Device List for that User----------------------------------------------
$sql = "SELECT * FROM devices WHERE (";
for($i=1;$i<11;$i++){
       $dv="dv".$i;
       $sql .= " device='".$_SESSION[$dv]."' OR"; 
    }
    
$sql .=" device='')";
//echo $sql;



$result = $conn->query($sql);

$result2=$conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
?>
<div class="w3-container">
  <h2>IoT Tecnologies By 2AC</h2>
    
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
 <?php   
    while($row = $result->fetch_assoc()) {

        echo "<input class='bazul' type='submit' name='selecionado'"
        ." value='".$row['divisao']
        ."' /><br><br>";

          }

    }
else {
    echo "0 results";
    }
$conn->close();
?>
    
</form>
  
</div>
    
 <?php

  if(isset($_POST['selecionado'])){
      
        while($row = $result2->fetch_assoc()) {
            //echo "IP".$row['ip']."SKIN".$row['skin']."DEVICE".$row['device']."<br>";
            if( $_POST["selecionado"] === $row['divisao']){
               $_SESSION['ip'] = long2ip($row["ip"]);
               $_SESSION['skin']=$row['skin'];
               $_SESSION['device']=$row['device'];
               $_SESSION['divisao']=$row['divisao'];
            }    

        }
    unset($_POST['selecionado']);   
    
    header('location:home.php');  
  }
 ?>   

</BODY>
</HTML>
