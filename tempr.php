<?php
//------------------------------------------------------------------------------------------------------------------------------
// Load Temperature to database and return scheduled operation
// How to test: http://lote10.dynu.com:4080/dev/tempr.php?temp=4&id=112&device=58&chave=kjfsdklas
//
//
//------------------------------------------------------------------------------------------------------------------------------
// Get vars from web client.
if ($_SERVER["REQUEST_METHOD"] == "GET") {

  $temperatura = floatval ($_GET["temp"]);
  $humidade = floatval ($_GET["hum"]);  
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
     $ip = $_SERVER['HTTP_CLIENT_IP'];
     } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
     $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     } else {
     $ip = $_SERVER['REMOTE_ADDR'];
     }
  $ip1=ip2long($ip);
  $id=$_GET['id'];
  $chave=$_GET['chave'];
  $device=$_GET['device'];
if ($chave == "kjfsdklas" ){
//--------------------------------------------------------
//database connection var: $conn
 require 'dbtest.php';
//echo $ip."  ".$id."  ".$chave;
 if(( $id == 1) or ($id==112) ){ //Insert just 1 time for the cycle.
     if($id==112){ 
         $temp_aux = $temperatura + 100;        
     }else{
         $temp_aux = $temperatura;
     }
     
     $sql = "INSERT INTO temperaturas (temp ,hum , ip, device) "
             . "VALUES ('$temp_aux', '$humidade', '$ip1','$device')";
     //echo $sql;
     $conn->query($sql);
     }
//Send Alarm by e-mail - If is a alarm "112"
     if($id==112){
         
        $week_day=(date("w", time()));
        $agora=date("H:i:s",time());
        
        $sqlp = "SELECT email FROM rules WHERE dias LIKE '%".$week_day
                ."%' AND device='".$device
                ."' AND hora1 < '".$agora
                ."' AND hora2 > '".$agora
                ."' AND rule='".$temperatura."'";
        //echo $sqlp ;
        $resultp = $conn->query($sqlp);
        
        if ($resultp->num_rows > 0) {
            session_start();
            while($row = $resultp->fetch_assoc()) {
                $_SESSION['sendto']=$row["email"];
                $_SESSION['subject']="Alarm #".$temperatura." from device ".$device;
                $_SESSION['bodymail']="Alarm #".$temperatura." from device "
                    .$device."<br> Send by server: ".$_SERVER['SERVER_NAME']
                    ."<br>Received on server at  ".date("Y-m-d H:i:s",time());
                require 'sendmail.php';
                
            }
            
        }else{
                echo "N_DB"; //Alarm not authorised on DB
            }        
     }
     
 if($id != 112){ //Chek for "recados" to send if is not alarm "112" 
// Get Data from programas -----------------------------------------------------------------
$week_day=(date("w", time()));
$agora=time();
$antes =  strtotime('-15 minutes',$agora);
$sqlp = "SELECT * FROM programas WHERE days LIKE '%".$week_day."%' AND device='".$device."'";
$resultp = $conn->query($sqlp);


//------------------------------ Listar-----------------------------------------------------
if ($resultp->num_rows > 0) {
    // output data of each row -------------------------------------------------------------
    while($row = $resultp->fetch_assoc()) {
          // There where things happen
          $operacao=strtotime($row["hora"]);

          //echo '<p>Now:'.date("Y-m-d H:i:s",$agora);
          //echo 'Before:'.date("Y-m-d H:i:s",$antes);
          //echo 'Order:'.date("Y-m-d H:i:s",$operacao).'</p>';

          // Some one are in the frame
          if( $operacao < $agora and $operacao > $antes) {
              //echo "<p>Estamos na hora</p>";
              //Some operation is not yet done.
              if (is_null($row["lastop"]) or $row["lastop"] >= $antes ){
                  //echo "<p>Temos trabalho </p>";
                  $aux= intval($row['onoff']);                 
                  
                  if($aux == 0){           // 0-> OFF LG System AC
                     echo "?pin=OFF_LG";
                    }
                  else if($aux == 1){      // 1-> ON Heat +24C LG System AC
                    echo "?pin=LGOn24H";
                    }
                  else if($aux == 2){      // 2-> ON Cool +20C LG System AC
                    echo "?pin=LGOn18C";
                    }
                  else if( ($aux> 10) AND  ($aux < 20)){      // 1x-> OFF
                    echo "?pin=ON";
                    echo $aux-10;
                    }                    
                  else if( ($aux > 20) AND  ($aux < 30)){      // 2x-> OFF
                    echo "?pin=OFF";
                    echo $aux-20;
                    }                     
                    
                  if($row['divisao'] == 'recado'){
                    //Delete if is a 'recado'  
                    //$sqlx = "DELETE FROM programas WHERE id=".$row["id"];
                    //Update table with timestamp,  
                        $sqlx="UPDATE programas SET lastop='".date("Y-m-d H:i:s",$agora);
                        $sqlx .="', divisao='enviado', days='' WHERE id=".$row["id"];                      
                      
                  }else{
                   //Update table with timestamp 
                        $sqlx="UPDATE programas SET lastop='".date("Y-m-d H:i:s",$agora);
                        $sqlx .="' WHERE id=".$row["id"];
                  }
                  $resultx = $conn->query($sqlx);

                 }
              }


          }

    }
 }   
//Close connection -------------------------------------------------------------------------------
$conn->close();
  }
else { echo "SECUR FAIL"; }
}


