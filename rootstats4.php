<!DOCTYPE html>
<!--
File: rootstats3.php
// Print in a tableau the statistics from temperature's


-->
<HTML>
<HEAD>
 <TITLE>Lote 10 - Home Automation Server</TITLE>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<!-- <link rel="stylesheet" href="w3.css"> -->
</HEAD>
<style>
<!-- Best presentatio for the table -->
</style>
<BODY>

<?php
session_start();
//disconect if login is no login


$sql = $_SESSION['sql_string'];
$iparray=$_SESSION['iparray'];

echo $sql; 
echo "<br>";

require 'dbtest.php';            //Get acesso to MySql DB

$result = $conn->query($sql);    //Runs Query 

if ($result->num_rows > 0) {
    // output data of each row
    echo "<table class='w3-table-all'>";
    echo "<tr class='w3-green'><th>Device</th><th>"
    . "Average</th><th>Min</th><th>Max</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>";
        echo $row['device']."</td><td>".$row['AVG(temp)']."</td><td>";
        echo $row['MIN(temp)']."</td><td>".$row['MAX(temp)'];
        echo "</td></tr>";
        }
    echo "</table>";
    }
else {
    echo "0 results";
    }
$conn->close();
?>
</BODY>
