 <?php
require("sessao.php");
include("template.php");  
require 'dbtest.php';

$IP_Modulos = $_SESSION['ip'];

     $operLG = htmlspecialchars($_GET["pin"]);
     //echo "http://".$IP_Modulos."/?pin=".$operLG ;
     $lines = file("http://".$IP_Modulos."/?pin=".$operLG );
     // echo the webpage to the frame
     $arrlength=count($lines);
     for($x = 0; $x < $arrlength; $x++) {
            echo $lines[$x];
            }

    
//-------------- Create a Log Operation -----------------------------------------------
if (strpos($lines[0], "IoT Tecnologies By 2AC") == true){ //sucess!!
                  //Update table with timestamp --------------------------------------------------------------------
                           $sqllog = "INSERT INTO logen (divisao, sucesso, ip,operacao ) VALUES ('$logado','OK','$IP_Modulos','$operLG' )";
                           }
                  else{
                           //echo "<p>Cammand fail</>>";
                            $sqllog = "INSERT INTO logen (divisao, sucesso, ip,operacao ) VALUES ('$logado','FAIL','$IP_Modulos','$operLG' )";
                           }
                  $conn->query($sqllog);
//Close connection -------------------------------------------------------------------------------------------------
$conn->close();
?>
</BODY>
</HTML>
