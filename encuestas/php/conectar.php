<?php

  error_reporting(0);

  function Conectarse()
  {
    
    $link = mysqli_connect("192.168.0.180", "dnkndev", "chid0t3am.", "ginthercorp");
    mysqli_set_charset($link,'utf8');
    if (!$link)
    {
        echo "<script>window.open('../index.php','_top');</script>";
        exit;
    }
  
    return $link;
  
  }

  ///FUNCION QUE CONVIERTE EL RESULTADO DEL QUERY EN JSON
  function query2json($result)
  {

    $arr = array();
    while($row = $result->fetch_assoc())
    {
     $arr[] = $row;
    }

    return json_encode($arr);

  }

?>