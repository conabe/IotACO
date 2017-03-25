<HTML>
<HEAD>
 <TITLE>Programar Horario</TITLE>
 <link rel="stylesheet" type="text/css" href="aco_styles.css">
</HEAD>

<title>SISTEMA WEB</title>
</head>
<?php
/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode simplesmente não fazer o login e digitar na barra de endereço do seu navegador o caminho para a página principal do site (sistema), burlando assim a obrigação de fazer um login, com isso se ele não estiver feito o login não será criado a session, então ao verificar que a session não existe a página redireciona o mesmo para a index.php.*/
session_start();

if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
{
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:index.php');
    }

$logado = $_SESSION['login'];

$IP_Modulos = $_SESSION['ip'];


?>
<body>

<h2>Lote 10 - Home Automation Server<BR>
<font color="#0000FF"><?php echo" Welcome: $logado";?></font>
</h2>

<form action="/logout.php">
    <button type="submit">LOGOUT</button>
</form>



<hr align="left">
<?php


if ($logado == "root") {
      echo "<p>Configurar Dados <a href='/dados.php'>here</a></p>";
      //echo "<p>Carregar Dados <a href='/carregar.php'>here</a></p>";
      }
      
else {
     $operLG = htmlspecialchars($_GET["pin"]);
     echo "http://".$IP_Modulos."/?pin=".$operLG ;
     $lines = file("http://".$IP_Modulos."/?pin=".$operLG );
     $arrlength=count($lines);

     for($x = 0; $x < $arrlength; $x++) {
            echo "<br>";
            echo $lines[$x];
            }
 }
?>
<hr align="left">
<p>Adicionar Programacao <a href='/programar.php'>here</a></p>
<p>Alterar password <a href='/p_change.php'>here</a></p>
</body>
</html>
