<?php

/* 
 * Start the session and get the user name forward this point.
 */
 /* Se nao existir sessao criada volta para o index.php*/
session_start(); // Test if seesion is OK
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
{
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:index.php');
    }
$logado = $_SESSION['login'];    

 