 <?php
require("sessao.php");
include("template.php");  

$IP_Modulos = $_SESSION['ip'];
$lines = file("http://".$IP_Modulos."/t2");
?>

<p style="font-family:verdana;font-size:250%;text-align:center;color:red">
<?php echo $lines[0]; ?>
</p>

</BODY>
</HTML>
