<?php 

//database connection var: $conn
require 'dbtest.php';

// session_start inicia a sessao
session_start();
// as variaveis login e senha recebem os dados digitados na pagina anterior
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $login = $_POST["login"];
  $senha = $_POST["senha"];
  }
  
//--------------------------------------------------------
$sql = "SELECT * FROM users2 WHERE divisao='$login' ";

$result = $conn->query($sql);

if( $result->num_rows > 0 ){
    $row = $result->fetch_assoc();

    $conn->close();

    if( $senha == $row["pass"] )
        {
        $_SESSION['login'] = $login;
        $_SESSION['senha'] = $senha;
        $_SESSION['ip'] = long2ip($row['ip']);
        $_SESSION['skin']=$row['skin'];
        $ip_parts=explode (".", long2ip($row['ip']));
        $_SESSION['device']=$ip_parts[3];
        
        for($i=1;$i<11;$i++){
            $dv="dv".$i;
            $_SESSION[$dv]=$row[$dv]; 
        }
        
        header('location:site2.php'); //antes era site.php

        }
    else{
	     unset ($_SESSION['login']);
	     unset ($_SESSION['senha']);
	     header('location:index.php');
	     }
    }
else{
     unset ($_SESSION['login']);
     unset ($_SESSION['senha']);
     header('location:index.php');
	 }
    
?>
