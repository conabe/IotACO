<?php

//database connection var: $conn
require 'dbtest.php';

// Get Data from programas -----------------------------------------------------------------
$week_day=(date("w", time()));
$agora=time();
$antes =  strtotime('-15 minutes',$agora);
$sqlp = "SELECT * FROM programas WHERE days LIKE '%".$week_day."%'";
$resultp = $conn->query($sqlp);

//------------------------------ Listar-----------------------------------------------------
if ($resultp->num_rows > 0) {
    // output data of each row -------------------------------------------------------------
    while($row = $resultp->fetch_assoc()) {
          // There where things happen
          $operacao=strtotime($row["hora"]);
          
          echo '<p>Now:'.date("Y-m-d H:i:s",$agora);
          echo 'Before:'.date("Y-m-d H:i:s",$antes);
          echo 'Order:'.date("Y-m-d H:i:s",$operacao).'</p>';
          
          // Some one are in the frame
          if( $operacao < $agora and $operacao > $antes) {
              echo "<p>Estamos na hora</p>";
              //Some operation is not yet done.
              if (is_null($row["lastop"]) or $row["lastop"] >= $antes ){  //intert or 1 to make test
                  echo "<p>Temos trabalho </p>";
                  
                  // Get Data from users --------------------------------------------------------
                  $sqlu = "SELECT * FROM users2 WHERE divisao='".$row["divisao"]."'";
                  $resultu = $conn->query($sqlu);
                  $row2 = $resultu->fetch_assoc();

                  if($row['onoff']<10){
                     $apoio = "http://".long2ip($row2['ip'])."/?pin=OFF_LG";
                    }
                  else if($row['onoff']>20){
                    $apoio = "http://".long2ip($row2['ip'])."/?pin=LGOn24H";
                    }
                  else{
                    $apoio = "http://".long2ip($row2['ip'])."/?pin=LGOn18C";
                    }
                  echo $apoio;
                  
                  sleep(2);
                  $lines=file($apoio);   // Run the opereation command !!!!
                  $divisao =  $row["divisao"];
                  if(strpos($lines[0], 'IoT Tecnologies By 2AC') == true ){ //sucess!!
                  //Update table with timestamp --------------------------------------------------------------------
                           $sqlx="UPDATE programas SET lastop='".date("Y-m-d H:i:s",$agora)."' WHERE id=".$row["id"];
                           $resultx = $conn->query($sqlx);
                           $sqllog = "INSERT INTO logs (divisao, sucesso ) VALUES ('$divisao','OK')";
                           echo "<p>Sucess</>>";
                           }
                  else{
                           echo "<p>Cammand fail</>>";
                           $sqllog = "INSERT INTO logs (divisao, sucesso ) VALUES ('$divisao', 'FAIL')";
                           }


                   //Add information to the logs database
                   if (mysqli_multi_query($conn, $sqllog)) {
                       echo "<p>New records created successfully</p>";
                       }
                   else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }
                 }
              }

          
          }

    }
else {
    echo "0 results";
    }

//Close connection -------------------------------------------------------------------------------
$conn->close();
?>

