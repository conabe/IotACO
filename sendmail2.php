<?php
$to = "abel.conceicao@gmail.com";
$subject = "Alarm from device";
$txt = "Alarme de IO ocorrido em ####";
$headers = "From: automationserver.lote10@gmail.com" . "\r\n" .
"CC: abel.conceicao@icloud.com";

mail($to,$subject,$txt,$headers);
?> 