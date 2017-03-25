<!--------------------------------------------------------------------------------------------------------------------
*   rootstats.php
*   Root Statistics -> Generate
*   Ver 1.0
*   Date: 23.01.2017
*
*
*
-------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html>
<head>
 <TITLE>Lote 10 - Home Automation Server</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<!-- <link rel="stylesheet" href="w3.css"> --> 
</head>
<body>
    
<div class="w3-container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 <h2>Date Frame</h2>
  
 <p><select name="intervalo">
    <option value="12h">Ultimas 12 horas</option>
    <option value="24h">Ultimas 24 horas</option>
    <option value="48h">Ultimas 48 horas</option>
    <option value="semana">Ultima semana</option>
    <option value="2semana">Ultimas 2 semanas</option>
    <option value="custom">Custom Dates</option>    
  </select></p>
    
    Start date: <input type="datetime-local" name="startdate"><br>
    End date_: <input type="datetime-local" name="enddate"><br>
  
  <h2>Device List</h2> 
<?php  
  //database connection var: $conn
  require 'dbtest.php';
  $sql1 = "SELECT DISTINCT ip FROM temperaturas";
  $result1 = $conn->query($sql1);

    if ($result1->num_rows > 0) {
        // output data of each row
        $flag=1;
        echo "<table class='w3-table-all'>";
        echo "<tr class='w3-green'><th>Select</th><th>Device</th><th>Room</th></tr>";
        while($row = $result1->fetch_assoc()) {
          echo "<tr><td><input type='checkbox' name='IP".$flag;
          echo "' value='".long2ip($row["ip"])."'></td><td>";
          echo long2ip($row["ip"])."</td><td> </td></tr>";
          $flag++;
         }
        echo "</table>";
        }
    $conn->close();
  
?>  
 
  
  <h2>Insert IP's from devices to analysis</h2>
  <input type="radio" name="tipo" value="grafico" checked> Chart
  <input type="radio" name="tipo" value="tabela"> Table
  <br><br>
  <input type="submit" value="Submit">
  
</form>
</div>
    
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get the vars from previous page (POST Method)
        
 
  $iparray=array();

  $j=0;
  for( $i=1; $i <= $flag; $i++ ){
      $pos ="IP";
      $pos .= $i;
      if(filter_var($_POST[$pos], FILTER_VALIDATE_IP)){ 
        $iparray[] = ip2long($_POST[$pos]); 
        $j++;
      }
    }


    // Data in MySql Format 
    // date("Y-m-d H:i:s",$agora)
    $enddate = date("Y-m-d H:i:s",strtotime('now'));
    if($_POST['intervalo'] == '12h'){
        $antes=strtotime('-12 hours'); 
    }else if($_POST['intervalo'] == '24h'){
        $antes=strtotime('-1 day');
    }else if($_POST['intervalo'] == '48h'){
        $antes=strtotime('-2 day');
    }else if($_POST['intervalo'] == 'semana'){
        $antes=strtotime('-1 week'); 
    }else if($_POST['intervalo'] == '2semana'){
        $antes=strtotime('-2 week');
    }else if($_POST['intervalo'] == 'custom'){
        $antes=strtotime($_POST["startdate"]);
        $enddate = date("Y-m-d H:i:s",strtotime($_POST["enddate"]));
        
    }
    
    $startdate = date("Y-m-d H:i:s",$antes);
    $tipo =  $_POST["tipo"]; 
  
  $sql = "SELECT * FROM temperaturas where (";

  for($i=0 ; $i <= $j ; $i++ ){
      $sql .= sprintf(" ip='%d' ",$iparray[$i]);
      if($i < $j) {
          $sql .=" OR";
      } 
  }

  $sql .= " ) AND ( reg_date > '".$startdate."' AND reg_date < '".$enddate."' )";
  
  $_SESSION['sql_string'] = $sql;
  $_SESSION['iparray'] = $iparray;

  if($_POST['tipo'] == 'grafico'){              //Graph
          header('location:rootstats2_b.php');
    }else{                                      //Table
        header('location:rootstats3_b.php');
    } 
  }
 ?>
</body>
</html>

