<?php

include 'conectar.php';

class EmpresasFiscales
{

    /**
    * Se declara la variable $link y en el constructor se asigna
    * 
    **/

    public $link;

    function EmpresasFiscales()
    {
  
      $this->link = Conectarse();

    }

    /**
      * Busca los datos de empresas_fiscales ACTIVAS, retorna un JSON con los datos correspondientes
      * 
      * MGFS se quita la condicion de id_cfdi > 0 ya que debe mostrar siempre todas la empresas fiscales 
      * al facturar se debe validar que tenga todos los datos correctos 
      **/
    function buscarEmpresasFiscales()
    {

        $result1 = $this->link->query("SELECT id_empresa,razon_social,rfc,id_cfdi
                                            FROM empresas_fiscales 
                                            WHERE generica=0 AND empresas_fiscales.activa=1
                                            ORDER BY razon_social");
    
        return query2json($result1);

    }//-- fin function buscarCostoAdministrativo

    function buscarEmpresasFiscalesCuotas()
    {

        $result1 = $this->link->query("SELECT id_empresa,razon_social,rfc,id_cfdi
          FROM empresas_fiscales 
          INNER JOIN cat_cuotas_obrero ON empresas_fiscales.id_empresa = cat_cuotas_obrero.id_razon_social
          WHERE cat_cuotas_obrero.inactivo = 0 AND empresas_fiscales.activa=1
          GROUP BY empresas_fiscales.id_empresa 
          ORDER BY razon_social");
    
        return query2json($result1);

    }//-- fin function buscarCostoAdministrativo

    function buscarEmpresasFiscalesYGenerica()
    {

        $result1 = $this->link->query("SELECT id_empresa,razon_social,rfc,id_cfdi
                                        FROM empresas_fiscales 
                                        WHERE 
                                        -- generica=1 AND
                                         activa=1
                                        ORDER BY razon_social");
    
        return query2json($result1);

    }//-- fin function buscarCostoAdministrativo

    function buscaEmpresasFiscalesTodas(){
      $result1 = $this->link->query("SELECT GROUP_CONCAT(id_empresa) AS empresas_fiscales
      FROM empresas_fiscales 
      WHERE  generica=0 AND activa=1
      ORDER BY razon_social");

      return query2json($result1);
    }//-- fin function buscaEmpresasFiscalesTodas

    /**
      * Busca los datos de empresas_fiscales ACTIVAS QUE VAN A FACTURAR, retorna un JSON con los datos correspondientes
      * 
      * MGFS se quita la condicion de  ya que debe mostrar siempre todas la empresas fiscales 
      * al facturar se debe validar que tenga todos los datos correctos 
      **/
      function buscarEmpresasFiscalesCFDI()
      {
  
          $result1 = $this->link->query("SELECT id_empresa,razon_social,rfc,id_cfdi
                                              FROM empresas_fiscales 
                                              WHERE id_cfdi > 0 AND generica=0 AND empresas_fiscales.activa=1
                                              ORDER BY razon_social");
      
          return query2json($result1);
  
      }//-- fin function buscarCostoAdministrativo

       /**
      * Busca los datos de empresas_fiscales CON UN RFC ESPECIFICO ACTIVAS QUE VAN A FACTURAR, retorna un JSON con los datos correspondientes
      * 
      * MGFS se quita la condicion de  ya que debe mostrar siempre todas la empresas fiscales 
      * al facturar se debe validar que tenga todos los datos correctos 
      **/
      function buscarEmpresasFiscalesCFDIRFC($rfc)
      {
          
          $result1 = $this->link->query("SELECT a.id_empresa,a.razon_social,a.rfc,a.id_cfdi,a.calle,a.calle_fiscal,a.num_ext,a.colonia,a.cp,a.representante,
          UPPER(b.estado) AS estado,UPPER(c.municipio) AS municipio
          FROM empresas_fiscales a
          LEFT JOIN estados b ON a.id_estado=b.id
          LEFT JOIN municipios c ON  a.id_municipio=c.id
          WHERE a.id_cfdi > 0 AND a.generica=0 AND a.activa=1 AND a.rfc='$rfc'
          ORDER BY a.razon_social");
      
          return query2json($result1);
  
      }//-- fin function buscarCostoAdministrativo

      /*Busca empresas fiscales diferentes a un rfc si el paametro es diferente de vacio*/
      function buscarEmpresasFiscalesDiferenteRFC($rfc){
        $condRFC = '';
        if($rfc != '')
            $condRFC = " AND rfc !='$rfc'";

        $result1 = $this->link->query("SELECT id_empresa,razon_social,rfc,id_cfdi
                                            FROM empresas_fiscales 
                                            WHERE generica=0 AND empresas_fiscales.activa=1 $condRFC
                                            ORDER BY razon_social");
    
        return query2json($result1);
      }


}//--fin de class EmpresasFiscales
    
?>