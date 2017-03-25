 <?php
require("sessao.php");
include("template.php"); 
    $SKIN= $_SESSION['skin'];


    if( $SKIN == 1) {         header('location:skin01.php'); }
    else if($SKIN == 2){      header('location:skin02.php'); }
    else if($SKIN == 3){      header('location:skin03.php'); }      
    else if($SKIN == 4){      header('location:skin04.php'); }        
    else if($SKIN == 5){      header('location:skin05.php'); }           
    else {                    header('location:skin00.php'); }
?>
</BODY>
</HTML> 
