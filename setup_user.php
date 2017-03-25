<?php
require("sessao.php");
include("template.php");   

?>
    <div class="w3-container">    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <p>Ip:<input type='text' placeholder='xxx.xxx.xxx.xxx' name='ip'></p>
        <p>Skin number (0-5):<input type="number" name="skin" min="0" max="5"></p>        
        <input type="submit" value="Submit">
    </form>
   </div>
<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['ip'] = $_POST["ip"];
            $_SESSION['skin']=$_POST["skin"];
            $ip_parts=explode (".",$_POST["ip"]);
            $_SESSION['device']=$ip_parts[3];
            header('location:site2.php'); 
        }
?>
    </body>
</html>
 