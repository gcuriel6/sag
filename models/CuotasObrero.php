<?php

include 'conectar.php';

class CuotasObrero
{

    /**
    * Se declara la variable $link y en el constructor se asigna o inicializa
    * 
    **/

    public $link;

    function CuotasObrero()
    {
  
      $this->link = Conectarse();

    }

    function guardarCuotasObrero($datos){
        $verifica = 0;

        $this->link->begin_transaction();
        $this->link->query("START TRANSACTION;");

        $verifica = $this -> guardarActualizar($datos);

        if($verifica > 0)
            $this->link->query("commit;");
        else
            $this->link->query('rollback;');

        return $verifica;
    }

    function guardarActualizar($datos){
        $verifica = 0;

        $tipoMov = $datos['tipoMov'];
        $id = $datos['id'];
        $idRazonSocial = $datos['idRazonSocial'];
        $salarioDiario = $datos['salarioDiario'];
        $salarioDiarioIntegrado = $datos['salarioDiarioIntegrado'];
        $imss = $datos['imss'];
        $infonavit = $datos['infonavit'];
        $sar = $datos['sar'];
        $concepto = $datos['concepto'];
        $inactivo = $datos['inactivo'];

        if($tipoMov==0){

          $query = "INSERT INTO cat_cuotas_obrero(id_razon_social, salario_diario,salario_integrado,imss,infonavit,sar,concepto) 
                    VALUES ('$idRazonSocial','$salarioDiario','$salarioDiarioIntegrado','$imss','$infonavit','$sar ','$concepto')";
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
          $id = mysqli_insert_id($this->link);

        }else{

          $query = "UPDATE cat_cuotas_obrero SET id_razon_social='$idRazonSocial',salario_diario='$salarioDiario', 
                    salario_integrado='$salarioDiarioIntegrado', imss='$imss', infonavit='$infonavit',
                    sar='$sar', concepto='$concepto',inactivo='$inactivo' 
                    WHERE id=".$id;
          $result = mysqli_query($this->link, $query) or die(mysqli_error());
    
        }
        
        if ($result) 
          $verifica = $id;  

        
        return $verifica;
    }

    function verificarCuotasObrero($datos){
        $idRazonSocial = $datos['idRazonSocial'];
        $salarioDiario = $datos['salarioDiario'];

        $verifica = 0;

        $query = "SELECT id FROM cat_cuotas_obrero 
                    WHERE id_razon_social=$idRazonSocial AND salario_diario=$salarioDiario 
                    AND inactivo=0";
        $result = mysqli_query($this->link, $query)or die(mysqli_error());
        $num = mysqli_num_rows($result);

        if($num > 0)
            $verifica = 1;

        return $verifica;
    }

    function buscarCuotasObreroId($idCuotaObrero){
        $resultado = $this->link->query("SELECT a.id,a.id_razon_social,b.razon_social,a.salario_diario,
                a.salario_integrado,a.imss,a.infonavit,a.sar,a.concepto,a.inactivo
                FROM cat_cuotas_obrero a
                LEFT JOIN empresas_fiscales b ON a.id_razon_social=b.id_empresa 
                WHERE a.id=".$idCuotaObrero);

        return query2json($resultado);
    }

    /**
      * Busca los datos de una unidad de negocio, retorna un JSON con los datos correspondientes
      * 
      * @param int $estatus indica el estatus que debe tener el registro 1=inactivos 0=inactivos 2=todos
      *
      **/
    function buscarCuotasObrero($estatus){
        $condicionEstatus='';

        if($estatus==1){
            $condicionEstatus='WHERE a.inactivo=1';
        }
        if($estatus==0){
            $condicionEstatus='WHERE a.inactivo=0';
        }
    
        $resultado = $this->link->query("SELECT a.id,a.id_razon_social,b.razon_social,a.salario_diario,
                a.salario_integrado,a.imss,a.infonavit,a.sar,a.concepto,a.inactivo
                FROM cat_cuotas_obrero a
                LEFT JOIN empresas_fiscales b ON a.id_razon_social=b.id_empresa
                $condicionEstatus
                ORDER BY a.id");
        return query2json($resultado);
    }

}//--fin de class CuotasObrero
    
?>