<!-- 
// Add and delete users from the system. This Web only works from root 
//
-->
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
<!-- Form Adicionar Utilizador-->
<div class="w3-container">
<h2>Adicionar Devices</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <p>Device: <input type="text" name="divisao"></p>
  <p>Device IP: <input type="text" name="ip"></p>
  <p>Skin number (0-5):<input type="number" name="skin" min="0" max="5"></p>
  <input type="submit" name="submit" value="Submit">
</form>

</div>
<?php
// Get Data --------------------------------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $divisao = test_input($_POST["divisao"]);
  $ip = test_input($_POST["ip"]);
  $skin = test_input($_POST["skin"]);
  
  if( (filter_var($ip, FILTER_VALIDATE_IP) == true ) and  $ip != ''  and $divisao != '' ){
      
      $ip_parts=explode (".", $ip);
      $ip1 = ip2long($ip);
      $sql = "INSERT INTO devices (divisao, ip, device, skin) VALUES ('$divisao', '$ip1','$ip_parts[3]','$skin')";

      if (mysqli_multi_query($conn, $sql)) {
         echo "<p>New records created successfully</p>";
         }
      else {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
         }
   }
   //Delete the selected
      if ($_POST["Apagar"] == 'Delete' ){
         $sql = "DELETE FROM devices WHERE id IN(";
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
<div class="w3-container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<?php
// Print Data -------------------------------------------------------------------------------------
$sql = "SELECT * FROM devices";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table id='w3-table'>";
    echo "<tr class='w3-grey'><th>Delete</th><th>ID</th><th>Utilizador</th><th>IP do Device</th><th>Device #</th><th>Skin</th></tr>";
    while($row = $result->fetch_assoc()) {
          echo "<tr><td><input type='checkbox' name='".$row["id"]."' value='DEL'></td><td>".$row["id"]."</td><td>".$row["divisao"]."</td><td>". long2ip($row["ip"])."</td><td>".$row["device"]."</td><td>".$row["skin"]."</td></tr>";
          }
    echo "</table>";
    }
else {
    echo "0 results";
    }
$conn->close();
?>
<p><input type="submit" name="Apagar" value="Delete"></p>
</div>

</BODY>
</HTML>
