<?php 
require("sessao.php");
include("template.php");  

?> 
  
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
  $sql1 = "SELECT DISTINCT temperaturas.device, devices.divisao FROM temperaturas"
          . " JOIN devices ON temperaturas.device=devices.device";
  $result1 = $conn->query($sql1);

    if ($result1->num_rows > 0) {
        // output data of each row
        $flag=1;
        echo "<table>";
        echo "<tr><th>Select</th><th>Device</th><th>Room</th></tr>";
        while($row = $result1->fetch_assoc()) {
          echo "<tr><td><input type='checkbox' name='DEVICE".$flag;
          echo "' value='".$row["device"]."'></td><td>";
          echo $row["device"]."</td><td>";
          echo $row["divisao"]." </td></tr>";
          $flag++;
         }
        echo "</table>";
        }
    $conn->close();
  
?>  
 
  
  <h2>Analysis Type</h2>
  <input type="radio" name="tipo" value="grafico" checked> Chart Temperature
  <input type="radio" name="tipo" value="tabela"> Table Temperatures
  <input type="radio" name="tipo" value="estatistica"> Statistics Temperatures
  <br>
  <input type="radio" name="tipo" value="alarme"> Alarms
  <input type="radio" name="tipo" value="erro"> Errors  
  <br>
  
  <h2>Order by data</h2>
   <p><select name="order">
    <option value="ASC">Ascendente</option>
    <option value="DESC">Descendente</option>
  </select></p>
  
  <input type="submit" value="Submit">
  <br>
  <br>
  
</form>
</div>
    
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get the vars from previous page (POST Method)
        
 
  $iparray=array();

  $j=0;
  for( $i=1; $i <= $flag; $i++ ){
      $pos ="DEVICE";
      $pos .= $i;
      if($_POST[$pos] != '' ){ 
        $iparray[] = $_POST[$pos]; 
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
  
   if($tipo == 'estatistica'){             //Statistics
   $sql = "SELECT device, AVG(temp), MIN(temp),MAX(temp) from temperaturas WHERE (";    
   }

  for($i=0 ; $i <= $j ; $i++ ){
      $sql .= sprintf(" device='%d' ",$iparray[$i]);
      if($i < $j) {
          $sql .=" OR";
      } 
  }

  $sql .= " ) AND ( reg_date > '".$startdate."' AND reg_date < '".$enddate."' )";
  
  if($tipo != 'alarme' AND $tipo != 'erro' ){
      $sql .=" AND temp < '50' ";
  }else if($tipo == 'erro'){
      $sql .=" AND temp > '90' AND temp < '100' ";
  }else if($tipo == 'alarme'){
      $sql .=" AND temp > '100' ";
  }
  
   if($_POST['tipo'] == 'estatistica'){           //Statistics
   $sql .= " group by device";    
   }
   
    if($_POST['order'] == 'ASC'){
        $sql .=" ORDER BY reg_date ASC"; 
    }else if($_POST['order'] == 'DESC'){
        $sql .=" ORDER BY reg_date DESC";
    }   
  
  $_SESSION['sql_string'] = $sql;
  $_SESSION['iparray'] = $iparray;

  if($tipo == 'grafico'){                       //Graph
        //header('location:rootstats2.php');
        echo "<img src='rootstats2.php'>";
    }else if($tipo == 'tabela'){                //Table
        //header('location:rootstats3.php');
        include('rootstats3.php');
    }else if($tipo == 'estatistica'){
        //header('location:rootstats4.php');      //Statistics 
        include('rootstats4.php');
    }else if($tipo == 'alarme' OR $tipo == 'erro' ){
        //header('location:rootstats3.php');      //Table
        include('rootstats4.php');
    } else{
        echo "Something goes wrong!";
    }
  }
 ?>
</body>
</html>

