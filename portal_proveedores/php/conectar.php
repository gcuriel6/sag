<?php

  error_reporting(0);

  function Conectarse()
  {

    // $link = mysqli_connect("127.0.0.1", "sistemas", "Pass123#$%", "ginthercorp");

    $link = mysqli_connect("localhost", "pruebagi_sistemas", "Pass123#$%.", "pruebagi_ginthercorp");
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
