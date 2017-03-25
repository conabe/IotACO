 <?php
require("sessao.php");
include("template.php"); 
include("dbtest.php"); //Uses database
//
// define variables and set to empty values
$pass1 = $pass2 = $zpass = "";
$pass_antiga= $_SESSION['senha'];
$logado = $_SESSION['login'];

?>
<!-- Form Adicionar Utilizador-->
<div class="w3-container">
<h2>Change Password</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Password Antiga: <input type="password" name="pass_antiga">
  <br><br>
  Nova Password: <input type="password" name="pass1">
  <br><br>
  Repetir Password: <input type="password" name="pass2">
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>
</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $zpass = $_POST["pass_antiga"];
  $pass1 = $_POST["pass1"];
  $pass2 = $_POST["pass2"];

  if( $zpass == $pass_antiga and $pass1=$pass2 ){

      $sql = "UPDATE users2 SET pass='$pass1' WHERE divisao='$logado'";

      if ($conn->query($sql) === TRUE) {
         echo "<p>Record updated successfully</p>";
         }
      else {
         echo "Error updating record: " . $conn->error;
         }
   }
}

$conn->close();
?>


</BODY>
</HTML>
