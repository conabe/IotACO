<?php
//------------------------------------------------------------------------------------------------------------------------------
// Load Temperature to database and return scheduled operation
// Identify targeb by device  number as split of ip adress.
// Ex: Ip=192.168.1.52 -> Device=52
//
//------------------------------------------------------------------------------------------------------------------------------
// Get vars from web client.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $temperatura = floatval ($_GET["temp"]);
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
 if( $id == 1 ){ //Insert just 1 time for the cycle.
     $sql = "INSERT INTO temperaturas (temp, ip, device) VALUES ('$temperatura', '$ip1','$device')";
     $conn->query($sql);
     }


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

                  if($row['onoff'] == 0){           // 0-> OFF LG System AC
                     echo   "?pin=OFF_LG";
                    }
                  else if($row['onoff'] == 1){      // 1-> ON Heat +24C LG System AC
                    echo "?pin=LGOn24H";
                    }
                  else if($row['onoff'] == 2){      // 2-> ON Cool +20C LG System AC
                    echo "?pin=LGOn18C";
                    }

                  $divisao =  $row["divisao"];
                  if($divisao == 'recado'){
                   //Delete if is a 'recado'  
                       $sqlx = "DELETE FROM programas WHERE id=".$row["id"];
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
//Close connection -------------------------------------------------------------------------------
$conn->close();
  }
else { echo "SECUR FAIL"; }
}


