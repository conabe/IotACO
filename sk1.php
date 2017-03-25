<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if ( $_GET['user'] != '' AND  $_GET['key'] !=''){
        $key=$_GET['key'];
        $user=$_GET['user'];
        
        $sql="SELECT id FROM newusers WHERE divisao='"
                . $user."' AND rsa_key='".$key."'";
                
         require 'dbtest.php';
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()){
               $sql="UPDATE newusers SET validate='"
                     .date('Y-m-d H:i:s',time())."' WHERE id='".$row['id']."'";  
               if (mysqli_multi_query($conn, $sql)){
                   echo 'Your user e-mail it is validated.<br>'
                   . 'Please whait for the admin to validade your acount';
               }
               
              }
         }else{
             echo 'User Not Found or key does not match';
         }
         
        
    } else{
        echo 'Error 501!!';
    } 

}else{
    echo 'Error 501!!';
}