<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=".$_REQUEST['nombre'].".xls");
header("Pragma: no-cache");
header("Expires: 0");
echo "<table>";
echo utf8_decode($_REQUEST['i_excel']);
echo "</table>";
?>


