<?php
    require("sessao.php");
    include("template.php"); 
?>
    
<div class="w3-container">
<h2>Insert Notification Rule </h2>

<p>"Days"Numeric representation of the day of the week <br>
    1 (for Mondays) through 7 (for Sundays)</p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <table class='w3-table w3-responsive'>
            <tr>
                <th></th>
                <th>Device</th>
                <th>Alarm#</th>
                <th>Start Time</th>
                <th>End Time</th>     
                <th>Days</th>                  
                <th>email</th>    
            </tr>
        <tr> <!-- Code to find available device's -->
            <th></th>
            <td><select name="device">
            <?php  
            //database connection var: $conn
            require 'dbtest.php';
            $dbflag=0;
            $sql1 = "SELECT DISTINCT ip FROM users2";
            $result1 = $conn->query($sql1);
            if ($result1->num_rows > 0) {
            // output data of each row
                while($row = $result1->fetch_assoc()) {
                    $ipparts=explode('.',long2ip($row['ip']));
                    $device=$ipparts[3];
                    echo "<option value='".$device;
                    echo "'>".$device."</option>";
                }
            }
            ?>  
  	</select></td> <!--End of devices-->
  
  	<td><select name="rule" required>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>            
            <option value="4">4</option>               
  	</select></td>
        <td><input type="time" name="hora1" ></td> 
        <td><input type="time" name="hora2" ></td>         
        <td><input type="text" name="dias" ></td>            
        <td><input type="email" name="email"></td>
        <td><input type="submit" name="submit" value="Submit"></td>        
        </tr>
         <!--/table-->
  </form>     
 
        <?php 
        // Code to save data to Data Base
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Get the vars from previous page (POST Method)

        $device=$_POST["device"];
        $rule=$_POST["rule"];
        $hora1=$_POST["hora1"];
        $hora2=$_POST["hora2"];        
        $dias=$_POST["dias"];   
        $email=$_POST["email"];

        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email=$_POST["email"];
        }
        
        if($email != '' and 
                preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $hora1) == true
                and 
                preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $hora2) == true
                and 
                $dias != ''){
            $sql = "INSERT INTO rules (device, rule, hora1, hora2,dias, email) ";
            $sql .= "VALUES ('$device','$rule', '$hora1','$hora2',$dias ,'$email')";
            if ($conn->query($sql) === TRUE) {
                $msg = "New record created successfully";
            } else {
                $msg = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
   //Delete the selected
   
   if ($_POST["Apagar"] == 'Delete' ){
         $sql = "DELETE FROM rules WHERE id IN(";
         $flag=0;
         // key where value equals "apple"
         while ($List_to_delete = current($_POST)) {
               if ($List_to_delete == 'DEL') {
               if ($flag > 0) $sql.=",";
               $sql.=key($_POST);
               $flag++;
               }
         next($_POST);
         }
         $sql.=")";
         if (mysqli_multi_query($conn, $sql)) {
            $msg = "<p>Records deleted successfully</p>";
            }
         else {
           $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
           }

   }
       }       
       ?>
        
<!-- Print Data  -->
    <!--table class='w3-table-all'-->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">            
        <?php
                $sql = "SELECT * FROM rules";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td><input type='checkbox' name='";
                    echo $row["id"]."' value='DEL'></td><td>";
                    echo $row['device'];
                    echo "</td><td>".$row['rule'];
                    echo "</td><td>".$row['hora1'];
                    echo "</td><td>".$row['hora2'];                    
                    echo "</td><td>".$row['dias'];
                    echo "</td><td>".$row['email']."</td><td></td></tr>";                    
                }
        }
        
        $conn->close();  
        ?> <!--End printing rulles-->
        </table>   
     <p><input type="submit" name="Apagar" value="Delete"></p>
</form>    
 <?php   echo $msg; ?>
</div>       
</body>
</html>
