 <?php
require("sessao.php");
include("template.php"); 
include("dbtest.php"); 

// define variables and set to empty values
$divisao = $pass = $ip = "";


function test_input($data) {
  return $data;
}
?>

<div class="w3-container">
<?php
// Print Data -------------------------------------------------------------------------------------
$sql = "SELECT * FROM logen";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo '<br>';
    echo "<table id=\"t01\">";
    echo "<tr><th>ID</th><th>Time Stamp</th><th>Utilizador</th><th>Sucesso</th><th>Operacao</th></tr>";
    while($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row["id"]."</td><td>".$row["reg_date"]."</td><td>".$row["divisao"];
          echo "</td><td>". $row["sucesso"]."</td><td>". $row["operacao"]."</td></tr>";
          }
    echo "</table>";
    }
else {
    echo "0 results";
    }
$conn->close();

?>
 </div>   
</BODY>
</HTML>
