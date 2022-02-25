<?php

  // error_reporting(0);

  function Conectarse()
  {
    
    // conexion para ginthersoft.com/corporativo_ginther (AWS)
    // $link = mysqli_connect("ginthersoft.com", "sistemas", "Pass123#$%", "ginthercorp");

    // conexion de test en gintestcorp.com (Hostgatos)
    $link = mysqli_connect("gintestcorp.com", "pruebagi_sistemas", "Pass123#$%.", "pruebagi_ginthercorp2");
    
    mysqli_set_charset($link,'utf8');
    if (!$link)
    {
        echo "<script>window.open('../index.php','_top');</script>";
        exit;
    }
  
    return $link;
  
  }

  function ConectarseCFDI()
  {

    $linkCFDI = mysqli_connect("gintestcorp.com", "pruebagi_sistemas", "Pass123#$%.", "pruebagi_cfdi_denken2");
    mysqli_set_charset($linkCFDI,'utf8');
    if (!$linkCFDI)
    {
        echo "<script>window.open('../index.php','_top');</script>";
        exit;
    }
  
    return $linkCFDI;

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
