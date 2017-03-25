<HTML>
<HEAD>
 <TITLE>New Document</TITLE>
</HEAD>
<BODY>
 <?php
 
//database connection var: $conn
require 'dbtest.php';

$ip1 = ip2long('192.168.1.51');
$ip2 = ip2long('192.168.1.52');
$ip3 = ip2long('192.168.1.53');
$ip4 = ip2long('192.168.1.54');

//$sql = "INSERT INTO users (divisao, pass, ip) VALUES ('carolina', 'lote10', '$ip1')";
//$sql = "INSERT INTO users (divisao, pass, ip) VALUES ('mafalda', 'lote10', '$ip2')";
//$sql = "INSERT INTO users (divisao, pass, ip) VALUES ('abel', 'lote10', '$ip3')";
//$sql = "INSERT INTO users (divisao, pass, ip) VALUES ('noemia', 'lote10', '$ip4')";


if (mysqli_multi_query($conn, $sql)) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn->close();
?>
</BODY>
</HTML>
