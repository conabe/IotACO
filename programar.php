<?php
// Load new schedulle to data base (by user)
// 10.Fev.2017 -> Add Device to table
//
//
require("sessao.php");
include("template.php");  
    
$logado = $_SESSION['login'];
$device = $_SESSION['device'];
$ip1 = ip2long( $_SESSION['ip'] );
//echo long2ip($ip1);
//database connection var: $conn
require 'dbtest.php';

function add_labels($data) {
  $aux = "x".$data;
  $data2="";
  
  if(strpos( $aux,'0')!=false){ $data2.='Dom, '; }
  if(strpos( $aux,'1')!=false){ $data2.='Seg, '; }
  if(strpos( $aux,'2')!=false){ $data2.='Tec, '; }
  if(strpos( $aux,'3')!=false){ $data2.='Qua, '; }
  if(strpos( $aux,'4')!=false){ $data2.='Qui, '; }
  if(strpos( $aux,'5')!=false){ $data2.='Sex, '; }
  if(strpos( $aux,'6')!=false){ $data2.='Sab, '; }
  
  return $data2;
}

function add_onoff($data){ //Add labels for Operation

if ($data == 0){ 
    return $data."-Turn Off";
  }else if ($data == 1 ){ 
    return $data."-Heat 24C"; 
  }
  else if ($data == 2 ){ 
    return $data."-Cool 18CC"; 
  }
return $data."-something wrong!!";

}
?>

<!-- Form Adicionar Programacao-->
<div class="w3-container">
<h2>Adicionar Programacao</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <p><input type="radio" name="onoff" value="Desligar" checked> Desligar
  <input type="radio" name="onoff" value="Aquecer"> Aquecer
  <input type="radio" name="onoff" value="Arrefecer"> Arrefecer  </p>
  <p>
  <input type="checkbox" name="wd1" value="0"> Dom
  <input type="checkbox" name="wd2" value="1"> Seg
  <input type="checkbox" name="wd3" value="2"> Ter
  <input type="checkbox" name="wd4" value="3"> Qua
  <input type="checkbox" name="wd5" value="4"> Qui
  <input type="checkbox" name="wd6" value="5"> Sex
  <input type="checkbox" name="wd7" value="6"> Sab
  </p>
  <?php
  if($logado == 'root'){
      echo "Ip:<input type='text' placeholder='xxx.xxx.xxx.xxx' name='IP'>";
  }
  ?>


  <p>Hora:<input type="time" name="usr_time"></p>
  <input type="submit" name="submit" value="Submit">

</form>
</div>

<?php
// Add Valus   -----------------------------------------------------------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if( $_POST["onoff"] == "Desligar" ){ $onoff = 0;}         // 0-> OFF LG System AC
  else if ( $_POST["onoff"] == "Aquecer" ){ $onoff = 1;}    // 1-> ON Heat +24C LG System AC
  else if ( $_POST["onoff"] == "Arrefecer" ){ $onoff = 2;}  // 2-> ON Cool +20C LG System AC
  
  //Insert a new one
  $dias=$_POST["wd1"].$_POST["wd2"].$_POST["wd3"].$_POST["wd4"].$_POST["wd5"].$_POST["wd6"].$_POST["wd7"];
  $hora = $_POST["usr_time"];
  
  //If root
  if($logado == 'root'){
    $ip_parts = explode (".", $_POST["IP"]);
    $device=$ip_parts[3];
    $ip1 = ip2long( $_POST["IP"] );
  }

  if( $dias != '' and  preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $hora) == true ){
      $sql = "INSERT INTO programas (onoff, days, hora, divisao, ip, device) ";
      $sql .= "VALUES ('$onoff','$dias', '$hora', '$logado', '$ip1', '$device')";

      if (mysqli_multi_query($conn, $sql)) {
         echo "<p>New records created successfully</p>";
         }
      else {
           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
           }
      }
   //Delete the selected
   
   if ($_POST["Apagar"] == 'Delete' ){
         $sql = "DELETE FROM programas WHERE id IN(";
         $flag=0;
         // key where value equals "apple"
         while ($List_to_delete = current($_POST)) {
               if ($List_to_delete == 'DEL') {
               if ($flag > 0) $sql.=",";
               $sql.=key($_POST);
               $flag++;
               }
         next($_POST);
         }
         $sql.=")";
         if (mysqli_multi_query($conn, $sql)) {
            echo "<p>Records deleted successfully</p>";
            }
         else {
           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
           }

   }
}
?>

<!-- Print Data -->
<div class="w3-container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<?php
if($logado == 'root'){ $sql = "SELECT * FROM programas"; }
else{ $sql = "SELECT * FROM programas WHERE device='".$device
        ."' AND divisao !='enviado'"; }


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table class='w3-table'>";
    echo "<tr class='w3-grey'>";
    echo "<th>Delete</th><th>Operacao</th><th>Hora</th><th>Dias"
        ."</th><th>Device</th></tr>";
    while($row = $result->fetch_assoc()) {
          echo "<tr><td><input type='checkbox' name='".$row["id"]
              ."' value='DEL'></td><td>";
          echo add_onoff($row["onoff"]);
          echo "</td><td>". $row["hora"]."</td><td>". add_labels($row["days"]);
          echo "</td><td>". $row["device"]."</td></tr>";
          }
    echo "</table>";
    }
else {
    echo "0 results";
    }
$conn->close();
?>

 <p><input type="submit" name="Apagar" value="Delete"></p>
</form>
</div>

</BODY>
</HTML>
