<?php 
//require("sessao.php");
include("template.php");  
require 'dbtest.php'; 

?> 

<div class="w3-container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        
        <br><br>
        <table>
 
            <tr><td>Name:</td><td><input type="text" name="name"></td></tr>
            <tr><td>Username:</td><td><input type="text" name="username"></td></tr>            
            <tr><td>E-mail: </td><td><input type="text" name="email1"></td></tr>
            <tr><td> Confirm E-mail:</td><td>   <input type="text" name="email2"></td></tr>
            <tr><td>Password:</td><td><input type="password" name="password1"></td></tr>
            <tr><td>Confirm Password:</td><td><input type="password" name="password2"></td></tr>
            <tr><td></td><td></td></tr>            
        </table>
        
    <input type="submit">
</form>
    
<?php


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if ( $_GET['name'] != '' AND  $_GET['email1'] !='' AND 
         $_GET['username'] AND
         $_GET['email1'] === $_GET['email2'] AND
         $_GET['password1']!='' AND 
         $_GET['password1'] === $_GET['password2']){
      
        $password=$_GET['password1'];
        
        if(strlen($password)<6){
            echo '<br>Password must have at least 6 chars';
        }else{
            $nome=$_GET['name'];
            $divisao=$_GET['username'];
            $email=$_GET['email1'];
            $pass=$_GET['password1'];
            $key = md5(microtime().rand());
            
            $sql = "INSERT INTO newusers (divisao, pass, nome, email, rsa_key) ";
            $sql .= " VALUES ('$divisao','$pass','$nome','$email','$key')";
            if (mysqli_multi_query($conn, $sql)) {
                session_start();
                $_SESSION['subject']='User Request';
                $_SESSION['bodymail']='<html>Please press the link below to '
                        . 'validate your e-mail:<br>'
                        . 'http://lote10.dynu.com:4080/dev/sk1.php?user='
                        . $divisao.'&key='.$key.'</html>';   
                $_SESSION['sendto']=$email;
                require 'sendmail.php';
                echo '<br>Please go to your mail box and folow the link'; 
            }
            else {
                echo "Error: ". mysqli_error($conn);
            }            
        }
    }
    else{
        echo '<br>Please correct the information!';
    }
     
}
?>

</div>