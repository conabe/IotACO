<?php

// File: userstats.php
// Prepare first step from wizard to launch graph plot.
require("sessao.php");
include("template.php");  
require 'dbtest.php';  //database connection var: $conn
?>

<div class="w3-container">      
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
 
    <h2>Frame Data</h2>
    <select name="intervalo">
        <option value="12h">Ultimas 12 horas</option>
        <option value="24h">Ultimas 24 horas</option>
        <option value="48h">Ultimas 48 horas</option>
        <option value="semana">Ultima semana</option>
        <option value="2semana">Ultimas 2 semanas</option>
    </select>
 
    <h2>Analisis Type</h2>
        <input type="radio" name="tipo" value="grafico" checked> Chart
        <input type="radio" name="tipo" value="tabela"> Table
        <br><br>
    <input type="submit" value="Submit">
    <br><br>
    </form>
</div> 
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get the vars from previous page (POST Method)
    
    $iparray = array();
   
    $iparray[] = $_SESSION['device'];
    // Data in MySql Format
    // date("Y-m-d H:i:s",$agora)
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
    }
    
    $startdate = date("Y-m-d H:i:s",$antes);
    $enddate = date("Y-m-d H:i:s",strtotime('now'));
   
    $tipo =  $_POST["tipo"];
  
    $sql = "SELECT * FROM temperaturas where ( device='";
    $sql .= $iparray[0]."' OR device='0')";
    $sql .= " AND ( reg_date > '".$startdate."' AND reg_date < '".$enddate."' )";
    $sql .=" AND temp < '50' ";
  
    
    $_SESSION['sql_string'] = $sql;
    $_SESSION['iparray'] = $iparray; 
  
  ?>
    
 <div class="w3-container">  
  <?php
    if($_POST['tipo'] == 'grafico'){              //Graph
           //header('location:rootstats2.php');
           echo "<img src='rootstats2.php'>";
        }else{                                     //Table
            //header('location:rootstats3.php');
            include('rootstats3.php');
        }  
  }
 ?>
 </div>       
</body>
</html>
