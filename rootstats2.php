<?php
session_start();
//disconect if login is no login

  if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){
       $xi=$_SESSION['screen_width'];
       $yi=$_SESSION['screen_height'];
        }else{
            $xi=800;
            $yi=600;
        }
        

$sql = $_SESSION['sql_string'];
$iparray=$_SESSION["iparray"];



$logado=$_SESSION["login"];

require 'dbtest.php';           //Get acesso to MySql DB


$result = $conn->query($sql);    //Runs Query 

$example_data=array();

$hora='';
$hora_old='';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
          $hora= date('G', strtotime($row['reg_date']));
          if($hora != $hora_old){
              $hora_old = $hora;
              $hora_aux=$hora;
              }else{
                    $hora_aux='';
              }
   
           if($row['device']==$iparray[0]){
              $example_data[]=array($hora_aux,$row['temp'],'','','','','');
              }else if($row['device']==$iparray[1]){
              $example_data[]=array($hora_aux,'',$row['temp'],'','','','');
              }else if($row['device']==$iparray[2]){
              $example_data[]=array($hora_aux,'','',$row['temp'],'','','');
              }else if($row['device']==$iparray[3]){
              $example_data[]=array($hora_aux,'','','',$row['temp'],'','');
              }else if($row['device']==$iparray[4]){
              $example_data[]=array($hora_aux,'','','','',$row['temp'],'');
              }else if($row['device']==$iparray[5]){
              $example_data[]=array($hora_aux,'','','','','',$row['temp']);
              }
          }
    }
else {
    echo "0 results";
    }
$conn->close();

// Print Data Graph-------------------------------------------------------------------------------------

//Include the code
require_once 'PhPlot/phplot.php';


//Define the object
$plot = new PHPlot(round($xi*0.95),round($yi*0.4));


$plot->SetDataValues($example_data);

//Set titles
$plot->SetTitle("Room Temperature");
$plot->SetXTitle('Hour');
$plot->SetYTitle('Temp [C] ');

//Turn off X axis ticks and labels because they get in the way:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->SetXTickLabelPos('none');
//Try to adjust X Scale!!
//
# Make a legend for the ips:

if($logado=='root'){
   $plot->SetLegend($iparray);
   $plot->SetLegendPosition(0, 0, 'image', 0, 0, 50, 0);
}
//Draw it
$plot->DrawGraph();

