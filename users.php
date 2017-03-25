 <?php
// Add and delete users from the system. This Web only works from root  
require("sessao.php");
include("template.php");  
require 'dbtest.php';  //database connection var: $conn

   $divisao = $pass = $ip = "";

   function test_input($data) {  return $data; }
?>
<!-- Form Adicionar Utilizador-->
<div class="w3-container">
<h2>Adicionar Utilizador</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <p>Utilizador: <input type="text" name="divisao"></p>
  <p>Password: <input type="text" name="pass"></p>
  <p>Device IP: <input type="text" name="ip"></p>
  <p>Skin number (0-5):<input type="number" name="skin" min="0" max="5"></p>
  <p>devices:
      <?php
      for($i=1;$i<11;$i++){
          echo "<input class='c_Small' type='text' name='dv"
          .$i."'>";
      }
      ?> 
  </p><input type="submit" name="submit" value="Submit">
</form>
</div>

<?php
// Get Data --------------------------------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $divisao = test_input($_POST["divisao"]);
  $pass = test_input($_POST["pass"]);
  $ip = test_input($_POST["ip"]);
  $skin = test_input($_POST["skin"]);
  
  $sqlaux="";
  $sqlaux2="";  
  for($i=1;$i<11;$i++){
      $dv="dv".$i;
      $sqlaux2 .=" ,'".$_POST[$dv]."'";
      $sqlaux .=" ,".$dv;
  }
  
  if( (filter_var($ip, FILTER_VALIDATE_IP) == true ) and  $pass != ''  and $divisao != '' ){

      $ip1 = ip2long($ip);
      $sql = "INSERT INTO users2 (divisao, pass, ip, skin";
      $sql .= $sqlaux;
      $sql .=  ") VALUES ('$divisao','$pass', '$ip1', '$skin'";
      $sql .= $sqlaux2;
      $sql .= ")";
      

      if (mysqli_multi_query($conn, $sql)) {
         echo "<p>New records created successfully</p>";
         }
      else {
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
         }

   }
   //Delete the selected
      if ($_POST["Apagar"] == 'Delete' ){
         $sql = "DELETE FROM users2 WHERE id IN(";
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
$sql = "SELECT * FROM users2";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table id='w3-table'>";
    echo "<tr class='w3-grey'><th>Delete</th><th>ID</th><th>Utilizador</th><th>Password"
    . "</th><th>IP do Device</th><th>Skin";
            for($i=1;$i<11;$i++){
                echo "</th><th> ";
            }
    echo "</th></tr>";       
    while($row = $result->fetch_assoc()) {
          echo "<tr><td><input type='checkbox' name='".$row["id"]
                  ."' value='DEL'></td><td>".$row["id"]."</td><td>"
                  .$row["divisao"]."</td><td>". $row["pass"]."</td><td>"
                  . long2ip($row["ip"])."</td><td>".$row["skin"];
          
            for($i=1;$i<11;$i++){
                echo "</td><td>";
                $dv="dv".$i;                
                echo $row[$dv];
            }
          
          echo "</td></tr>";
          }
    echo "</table>";
         echo $sql; 
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
