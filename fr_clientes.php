<?php
session_start();

$idCliente=0;
$regresar=0;

if(isset($_GET['idCliente'])!=0 && isset($_GET['regresar'])==1){

    $idCliente=$_GET['idCliente'];
    $regresar=1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GINTHERCORP</title>
    <!-- Hojas de estilo -->
    <link href="css/css/bootstrap.css" rel="stylesheet"  type="text/css" media="all">
    <link href="css/validationEngine.jquery.css" rel="stylesheet" />
    <link href="css/bootstrap-datepicker.standalone.min.css" rel="stylesheet"/>
    <link href="css/general.css" rel="stylesheet"  type="text/css"/>
    <link href="vendor/font_awesome/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
    <link href="vendor/select2/css/select2.css" rel="stylesheet"/>
</head>

<style> 
    body{
        background-color:rgb(238,238,238);
    }
    
    #div_principal,
    #div_razon_social,
    #div_contratos{
      position: absolute;
      top:0px;
      left : -101%;
      height: 100%;
      background-color: rgba(250,250,250,0.6);
      
    }
    #div_contenedor{
        background-color: #ffffff;
    }
   .input_group_span{
        background-color: rgb(96,91,89); 
        color: white;
   }
   #dialog_ordenes_compra > .modal-lg{
        min-width: 90%;
        max-width: 90%;
   }
   #dialog_buscar_productos > .modal-lg{
        min-width: 80%;
        max-width: 80%;
   }

   #d_estatus_oc{
       padding-top:7px;
       text-align:center;
       font-weight:bold;
       font-size:15px;
       height:40px;
       vertical-align:middle;
   }

    @media screen and(max-width: 1030px){
        .modal-lg{
            min-width: 800px;
            max-width: 800px;
        }
    }

    @media screen and (max-width: 600px) {
        .modal-dialog{
            max-width: 300px;
        }
    }

    .tr_totales th{
        border:none;
        background:rgba(231,243,245,0.6);
        font-weight:bold;
        font-size:11px;
        text-align:right;
    }
    .tr_totales th input{
        font-weight:bold;
        font-size:11px;
        text-align:right;
        margin-right:10px;
        padding-right:10px;
    }

    textarea{
        resize:none;
    }

</style>

<body>
    <div class="container-fluid" id="div_principal"> <!--div_principal-->

        <div class="row"> <!--div_row-->
            <div class="col-md-1"></div>
            <div class="col-md-offset-1 col-md-10" id="div_contenedor"> <!--div_contenedor-->
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="titulo_ban">Clientes</div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Limpia campos pantalla" class="btn btn-dark btn-sm form-control" id="b_nuevo"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Busca los clientes" class="btn btn-dark btn-sm form-control" id="b_buscar"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Guardar/Editar" class="btn btn-dark btn-sm form-control" id="b_guardar"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>
                   
                    
                    <div class="col-sm-12 col-md-2"></div>
                </div>
                <br>

                <form id="form_cliente" name="form_cliente">
                    <div class="row">
                        <div class="col-sm-2 col-md-2" style="text-align:rigth;"><label for="i_id_cliente" class="col-form-label">Clave</label></div>
                        <div class="col-sm-2 col-md-2">
                                <input type="text" id="i_id_cliente" name="i_id_cliente" readonly class="form-control form-control-sm validate[required]" disabled autocomplete="off"/>
                        </div>
                    </div>
                    <div class="row"> 
                        
                           <div class="col-sm-2 col-md-2"><label for="i_fecha_inicio" class="col-form-label requerido">Fecha Inicio </label></div>
                           <div class="col-sm-2 col-md-2"><input type="text" id="i_fecha_inicio" name="i_fecha_inicio" readonly class="form-control form-control-sm fecha validate[required]" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-md-2" style="text-align:rigth;"><label for="i_nombre_comercial" class="col-form-label requerido">Nombre Comercial</label></div>
                        <div class="col-sm-2 col-md-4">
                                <input type="text" id="i_nombre_comercial" name="i_nombre_comercial" class="form-control form-control-sm validate[required]"  autocomplete="off"/>
                        </div>
                    </div>
                    <div class="row">
                    <label for="ta_datos_contacto" class="col-sm-12 col-md-3 col-form-label requerido">Datos de contacto Principal </label>
                               
                        <div class="col-sm-12 col-md-12">
                            <div class="row">
                                 <div class="col-sm-9 col-md-9">
                                    <textarea  id="ta_datos_contacto" name="ta_datos_contacto" class="form-control validate[required]" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group row">
                                <div class="col-sm-10 col-md-6">
                                <label for="ch_inactivo" class="col-sm-2 col-md-2 col-form-label">Inactivo</label>
                                
                                    <input type="checkbox" id="ch_inactivo" name="ch_inactivo" value="">
                                </div>
                            </div>   
               
                 <hr>  <!--linea gris-->
                
                    <div class="row">
                        <div class="col-sm-4 col-md-2"></div>
                        <div class="col-sm-4 col-md-6"><button type="button" data-toggle="tooltip" data-placement="top" title="Busca Razones sociales" class="btn btn-dark btn-sm form-control" id="b_buscar_razones_sociales"><i class="fa fa-search" aria-hidden="true"></i>  Razón Social</button>
                        </div>
                        <div class="col-sm-4 col-md-2"></div>
                        <div class="col-sm-4 col-md-2">
                            <button type="button" data-toggle="tooltip" data-placement="top" title="Agregar Razones sociales" class="btn btn-success btn-sm form-control" id="b_agregar_razon_social"><i class="fa fa-plus" aria-hidden="true"></i>  Razón Social</button>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon"  id="t_razones_sociales_cliente">
                            <thead>
                                <tr class="renglon">
                                    <th scope="col" width="30%">Razón Social</th>
                                    <th scope="col" width="15%">Nombre Corto</th>
                                    <th scope="col" width="10%">RFC</th>
                                    <th scope="col" width="25%">Empresa con la que se Factura</th>
                                    <th scope="col" width="10%">Estatus</th>
                                    <th scope="col" width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        
                            </table>  
                        </div>
                    </div>
                </form>
                <br><br><br>
            </div>
        </div>  
    </div><!-- fin  forma cliente div_principal-->
    <div class="container-fluid" id="div_razon_social"> <!--div_ forma razon social-->
        <div class="row">
            <div class="col-12" id="div_contenedor">

                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="titulo_ban">Razón Social</div>
                    </div>
                    <div class="col-sm-12 col-md-7"></div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" class="btn btn-info btn-sm form-control" id="b_regresar"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> regresar</button>
                    </div>
                </div>

                <div class="row">        
                    <div class="col-sm-12 col-md-2 mx-auto">
                        <button type="button" class="btn btn-dark btn-sm form-control" id="b_guardar_razon_social"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>                   
                </div>

                <div class="row">
                    <div class="col-10 mx-auto">
                        <form id="form_razon_social" name="form_razon_social">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="i_rfc" class="col-sm-2 col-md-2 col-form-label requerido">RFC</label>
                                        <div class="input-group col-sm-12 col-md-4">
                                            <input type="text" id="i_rfc" name="i_rfc" class="form-control validate[required,minSize[12],maxSize[13],custom[onlyLetterNumberN]]" size="13" autocomplete="off">
                                        </div>
                                        <div class="col-sm-12 col-md-2"></div>
                                        <label for="ch_activo" class="col-sm-2 col-md-2 col-form-label">Activo</label>
                                        <div class="col-sm-10 col-md-2">
                                            <input type="checkbox" id="ch_activo" name="ch_activo" value="">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="i_nombre_corto" class="col-sm-2 col-md-2 col-form-label requerido">Nombre Corto </label>
                                        <div class="col-sm-12 col-md-3">
                                            <input type="text" class="form-control validate[required]" id="i_nombre_corto" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="i_razon_social" class="col-sm-2 col-md-2 col-form-label requerido">Razón Social </label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control validate[required]" id="i_razon_social" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="i_representante" class="col-sm-2 col-md-2 col-form-label requerido">Representante Legal </label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control validate[required]" id="i_representante" autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="i_correorepresentante" class="col-sm-2 col-md-2 col-form-label requerido">Correo Representante Legal </label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control validate[required]" id="i_correorepresentante" autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="i_telefonorepresentante" class="col-sm-2 col-md-2 col-form-label requerido">Telefono Representante Legal </label>
                                        <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control validate[required]" id="i_telefonorepresentante" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <h5 class="card-header">Domicilio Fiscal</h5>
                                        <div  class="card-body">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="i_domicilio" class="col-sm-12 col-md-3 col-form-label requerido">Domicilio </label><br>
                                                        <div class="col-sm-12 col-md-9">
                                                            <input type="text" class="form-control validate[required]" id="i_domicilio" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="i_num_ext" class="col-sm-12 col-md-3 col-form-label requerido">Num. Ext </label><br>
                                                        <div class="col-sm-12 col-md-3">
                                                            <input type="text" class="form-control validate[required]" id="i_num_ext" autocomplete="off">
                                                        </div>

                                                        <label for="i_num_int" class="col-sm-12 col-md-3 col-form-label requerido">Num. Int </label><br>
                                                        <div class="col-sm-12 col-md-3">
                                                            <input type="text" class="form-control" id="i_num_int" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_cp" class="col-2 col-md-2 col-form-label requerido">Código Postal </label><br>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="row">
                                                        
                                                        <div class="input-group col-sm-12 col-md-9">
                                                            <input type="text" id="i_cp" name="i_cp" class="form-control validate[required,custom[integer]]" readonly autocomplete="off">
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-primary" type="button" id="b_buscar_cp" style="margin:0px;">
                                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label for="s_pais" class="col-1 col-md-1 col-form-label requerido">País </label><br>
                                                <div class="col-sm-12 col-md-3">
                                                    <select id="s_pais" name="s_pais" class="form-control validate[required]" autocomplete="off"></select>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group row">
                                                <label for="i_colonia" class="col-sm-2 col-md-2 col-form-label requerido">Colonia </label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input type="text" class="form-control validate[required]" id="i_colonia" disabled autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_id_municipio" class="col-2 col-md-2 col-form-label requerido">Municipio </label><br>
                                                <div class="col-sm-2 col-md-2">
                                                    <input type="text" class="form-control validate[required]" id="i_id_municipio" disabled autocomplete="off">
                                                </div>
                                                <div class="col-sm-2 col-md-8">
                                                    <input type="text" class="form-control validate[required]" id="i_municipio" disabled autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_id_estado" class="col-2 col-md-2 col-form-label requerido">Estado </label><br>
                                                <div class="col-sm-2 col-md-2">
                                                    <input type="text" class="form-control validate[required]" id="i_id_estado" disabled autocomplete="off">
                                                </div>
                                                <div class="col-sm-2 col-md-8">
                                                    <input type="text" class="form-control validate[required]" id="i_estado" disabled autocomplete="off">
                                                </div>
                                            </div>
                                        </div>   
                                    </div>  
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <h5 class="card-header">Domicilio Servicio</h5>
                                        <div  class="card-body">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="i_domicilio2" class="col-sm-12 col-md-3 col-form-label requerido">Domicilio </label><br>
                                                        <div class="col-sm-12 col-md-9">
                                                            <input type="text" class="form-control validate[required]" id="i_domicilio2" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="i_num_ext" class="col-sm-12 col-md-3 col-form-label requerido">Num. Ext </label><br>
                                                        <div class="col-sm-12 col-md-3">
                                                            <input type="text" class="form-control validate[required]" id="i_num_ext2" autocomplete="off">
                                                        </div>

                                                        <label for="i_num_int" class="col-sm-12 col-md-3 col-form-label requerido">Num. Int </label><br>
                                                        <div class="col-sm-12 col-md-3">
                                                            <input type="text" class="form-control" id="i_num_int2" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_cp" class="col-2 col-md-2 col-form-label requerido">Código Postal </label><br>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="row">
                                                        
                                                        <div class="input-group col-sm-12 col-md-9">
                                                            <input type="text" id="i_cp2" name="i_cp2" class="form-control validate[required,custom[integer]]" readonly autocomplete="off">
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-primary" type="button" id="b_buscar_cp2" style="margin:0px;">
                                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label for="s_pais" class="col-1 col-md-1 col-form-label requerido">País </label><br>
                                                <div class="col-sm-12 col-md-3">
                                                    <select id="s_pais2" name="s_pais" class="form-control validate[required]" autocomplete="off"></select>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group row">
                                                <label for="i_colonia" class="col-sm-2 col-md-2 col-form-label requerido">Colonia </label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input type="text" class="form-control validate[required]" id="i_colonia2" disabled autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_id_municipio" class="col-2 col-md-2 col-form-label requerido">Municipio </label><br>
                                                <div class="col-sm-2 col-md-2">
                                                    <input type="text" class="form-control validate[required]" id="i_id_municipio2" disabled autocomplete="off">
                                                </div>
                                                <div class="col-sm-2 col-md-8">
                                                    <input type="text" class="form-control validate[required]" id="i_municipio2" disabled autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_id_estado" class="col-2 col-md-2 col-form-label requerido">Estado </label><br>
                                                <div class="col-sm-2 col-md-2">
                                                    <input type="text" class="form-control validate[required]" id="i_id_estado2" disabled autocomplete="off">
                                                </div>
                                                <div class="col-sm-2 col-md-8">
                                                    <input type="text" class="form-control validate[required]" id="i_estado2" disabled autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="i_entrecalle" class="col-sm-2 col-md-2 col-form-label requerido">Entre calles </label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input type="text" class="form-control validate[required]" id="i_entrecalle" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="i_celularservicio" class="col-sm-2 col-md-2 col-form-label requerido">Telefono de Servicio</label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input type="text" class="form-control validate[required]" id="i_celularservicio" autocomplete="off">
                                                </div>
                                            </div>

                                        </div>   
                                    </div>  
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <h5 class="card-header">Datos Contacto Administrativo</h5>
                                        <div  class="card-body">                                
                                
                                            <div class="form-group row">
                                                <label for="i_telefono" class="col-sm-2 col-md-2 col-form-label requerido">Teléfono(s) </label>
                                                <div class="col-sm-12 col-md-6">
                                                    <input type="text" class="form-control validate[required]" id="i_telefono" autocomplete="off">
                                                </div>
                                                <label for="i_extension" class="col-sm-2 col-md-2 col-form-label requerido">Extensión </label>
                                                <div class="col-sm-12 col-md-2">
                                                    <input type="text" class="form-control validate[required]" id="i_extension" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_correos" class="col-sm-2 col-md-2 col-form-label requerido">Correo </label>
                                                <div class="col-sm-12 col-md-8">
                                                    <input type="text" class="form-control validate[required]" id="i_correos" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_contacto" class="col-sm-2 col-md-2 col-form-label requerido">Contacto </label>
                                                <div class="col-sm-12 col-md-8">
                                                    <input type="text" class="form-control validate[required]" id="i_contacto" autocomplete="off">
                                                </div>
                                            </div>

                                            <!-- <div class="form-group row">
                                                <label for="i_contacto" class="col-sm-2 col-md-2 col-form-label requerido">Otros Contactos </label>
                                                <div class="col-sm-12 col-md-8">
                                                    <textarea  class="form-control validate[required]" id="i_otro_contacto" autocomplete="off"></textarea>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>  
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <h5 class="card-header">Datos Contacto Operativo</h5>
                                        <div  class="card-body">                                
                                
                                            <div class="form-group row">
                                                <label for="i_telefono" class="col-sm-2 col-md-2 col-form-label requerido">Teléfono(s) </label>
                                                <div class="col-sm-12 col-md-6">
                                                    <input type="text" class="form-control validate[required]" id="i_telefono2" autocomplete="off">
                                                </div>
                                                <label for="i_extension" class="col-sm-2 col-md-2 col-form-label requerido">Extensión </label>
                                                <div class="col-sm-12 col-md-2">
                                                    <input type="text" class="form-control validate[required]" id="i_extension2" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_correos" class="col-sm-2 col-md-2 col-form-label requerido">Correo </label>
                                                <div class="col-sm-12 col-md-8">
                                                    <input type="text" class="form-control validate[required]" id="i_correos2" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="i_contacto" class="col-sm-2 col-md-2 col-form-label requerido">Contacto </label>
                                                <div class="col-sm-12 col-md-8">
                                                    <input type="text" class="form-control validate[required]" id="i_contacto2" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="i_posicion" class="col-sm-2 col-md-2 col-form-label requerido">Posicion</label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input type="text" class="form-control validate[required]" id="i_posicion" autocomplete="off">
                                                </div>
                                            </div>

                                            <!-- <div class="form-group row">
                                                <label for="i_contacto" class="col-sm-2 col-md-2 col-form-label requerido">Otros Contactos </label>
                                                <div class="col-sm-12 col-md-8">
                                                    <textarea  class="form-control validate[required]" id="i_otro_contacto2" autocomplete="off"></textarea>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>  
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <h5 class="card-header card-header-success">Facturación</h5>
                                        <div  class="card-body">
                                            <div class="form-group row">
                                                <label for="i_dias_credito" class="col-2 col-md-2 col-form-label">Días de Crédito </label><br>
                                                <div class="col-sm-2 col-md-2">
                                                    <input type="text" class="form-control" id="i_dias_credito" autocomplete="off">
                                                </div>
                                                <label for="i_credito_limite" class="col-sm-2 col-md-2 col-form-label">Crédito Límite </label>
                                                <div class="col-sm-12 col-md-2">
                                                    <input type="text" class="form-control" id="i_credito_limite" autocomplete="off">
                                                </div>
                                                <label for="i_credito_activo" class="col-sm-2 col-md-2 col-form-label">Crédito Activo </label>
                                                <div class="col-sm-12 col-md-2">
                                                    <input type="text" class="form-control validate[custom[integer]]" id="i_credito_activo" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="s_tipo_facturacion" class="col-sm-2 col-md-2 col-form-label">Tipo de Facturación</label>
                                                <div class="col-sm-2 col-md-2">
                                                    <select class="form-control coti" id="s_tipo_facturacion" name="s_tipo_facturacion" autocomplete="off">
                                                        <option value="0" disabled selected>Selecciona</option>    
                                                        <option value="1">Mes corriente</option>
                                                        <option value="2">Mes Vencido</option>
                                                        <option value="3">Mes anticipado</option>
                                                    </select>
                                                </div> 
                                                <label for="s_periodicidad" class="col-sm-2 col-md-2 col-form-label">Periodicidad</label>
                                                <div class="col-sm-2 col-md-2">
                                                    <select class="form-control coti" id="s_periodicidad" name="s_periodicidad" autocomplete="off">
                                                        <option value="0" disabled selected>Selecciona</option>    
                                                        <option value="1">Semanal</option>
                                                        <option value="2">Quincenal</option>
                                                        <option value="3">Mensual</option>
                                                    </select>
                                                </div>
                                                
                                                <label for="i_dia" class="col-sm-2 col-md-2 col-form-label">Día</label>
                                                <div class="col-sm-1 col-md-1" id="contenedor_dia">
                                                    <input type="text" id="i_dia" name="i_dia"  class="form-control coti" autocomplete="off"  readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="s_regimen" class="col-sm-2 col-md-2 col-form-label">Régimen</label>
                                                <div class="col-sm-6 col-md-6">
                                                    <select class="form-control coti validate[required]" id="s_regimen" name="s_regimen" autocomplete="off"></select>
                                                </div>
                                            </div>

                                        </div>
                                    </div> 
                                </div>
                            </div>

                        </form>

                        <!-- TABLA CONTRATOS-->
                        <div class="card">
                            <h5 class="card-header card-header-success">Contratos</h5>
                            <div  class="card-body">
                                <div class="row">
                                    <div class="col-sm-4 col-md-10"></div>
                                    <div class="col-sm-4 col-md-2">
                                        <button type="button" data-toggle="tooltip" data-placement="top" title="Agregar Contrato" class="btn btn-success btn-sm form-control" id="b_agregar_contrato"><i class="fa fa-plus" aria-hidden="true"></i>  Contrato</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <table class="tablon"  id="t_contratos_cliente">
                                        <thead>
                                            <tr class="renglon">
                                                <th scope="col" width="10%">Contrato</th>
                                                <th scope="col" width="15%">Departamento</th>
                                                <th scope="col" width="15%">Supervisor</th>
                                                <th scope="col" width="10%">Fecha</th>
                                                <th scope="col" width="10%">Vigencia</th>
                                                <th scope="col" width="15%">RS Cliente</th>
                                                <th scope="col" width="15%">RS Facturacion</th>
                                                <th scope="col" width="15%">RS Contrato</th>
                                                <th scope="col" width="5%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    
                                        </table>  
                                    </div>
                                </div>
                            </div>
                        </div>    
                    
                    </div>
                </div>

                <div class="row">
                    <div class="col-10 mx-auto">
                        <button type="button" class="btn btn-success btn-lg verificar_permiso" alt="BOTON_ASIGNAR_UNIDAD_NEGOCIO_RAZON_SOCIAL" id="b_asignar_unidades"><i class="fa fa-external-link-square" aria-hidden="true"></i> Asignar Unidades de Negocio</button>
                        <button type="button" class="btn btn-success btn-lg verificar_permiso" alt="BOTON_EXCEL_CLIENTES" id="b_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
                        <form id="f_imprimir_excel" action="php/excel_genera.php" method="POST" target="_blank">
                            <input type="hidden" readonly id="i_nombre_excel" name='i_nombre_excel'>
                            <input type="hidden" readonly id="i_fecha_excel" name='i_fecha_excel'>
                            <input type="hidden" readonly id="i_modulo_excel" name='i_modulo_excel'>
                        </form>
                    </div>
                </div>

            </div> <!--div_contenedor-->
        </div>
    </div><!-- fin foma div_razon_social-->

<div class="container-fluid" id="div_contratos"> <!--div_principal-->

    <div class="row"> <!--div_row-->
        <div class="col-md-1"></div>
        <div class="col-md-offset-1 col-md-10" id="div_contenedor"> <!--div_contenedor-->
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="titulo_ban">Contratos</div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Limpia campos pantalla" class="btn btn-dark btn-sm form-control" id="b_nuevo_contrato"><i class="fa fa-file-o" aria-hidden="true"></i> Nuevo</button>
                </div>
                <div class="col-sm-12 col-md-2"></div>
                <div class="col-sm-12 col-md-2">
                    <button type="button" data-toggle="tooltip" data-placement="top" title="Guardar/Editar" class="btn btn-dark btn-sm form-control" id="b_guardar_contrato"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                </div>
            
                
                <div class="col-sm-12 col-md-2"><button type="button" class="btn btn-info btn-sm form-control" id="b_regresar_rs"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> regresar</button>
                        </div>
            </div>
            <br>

            <form id="form_contratos" name="form_contratos">
                <!-- ID CLIENTE Y ID RAZON SOCIAL VARIA SI SE HACE UN CONTRATO NUEVO O UNA EDICION--->
                <input type="hidden" id="i_id_cliente_c" name="i_id_cliente_c" />
                <input type="hidden" id="i_id_razon_social_c" name="i_id_razon_social_c" />
                <!---->   
                <div class="row">
                    <div class="col-sm-2 col-md-2" style="text-align:rigth;"><label for="i_nombre_comercial_c" class="col-form-label requerido">Nombre Comercial</label></div>
                    <div class="col-sm-2 col-md-4">
                            <input type="text" id="i_nombre_comercial_c" name="i_nombre_comercial_c" class="form-control form-control-sm validate[required]" readonly  autocomplete="off"/>
                    </div>
                    <div class="col-sm-2 col-md-1"></div>
                    <div class="col-sm-2 col-md-2"><label for="i_id_contrato" class="col-form-label">ID Contrato </label></div>
                    <div class="col-sm-2 col-md-2"><input type="text" id="i_id_contrato" name="i_id_contrato" readonly class="form-control form-control-sm" autocomplete="off"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-md-2" style="text-align:rigth;"><label for="i_rfc_c" class="col-form-label requerido">RFC</label></div>
                    <div class="col-sm-3 col-md-3">
                            <input type="text" id="i_rfc_c" name="i_rfc_c" readonly class="form-control form-control-sm validate[required]" disabled autocomplete="off"/>
                    </div>
                    <div class="col-sm-1 col-md-2"></div>
                    <div class="col-sm-2 col-md-2"><label for="i_fecha_c" class="col-form-label requerido">Fecha Inicio </label></div>
                    <div class="col-sm-2 col-md-2"><input type="text" id="i_fecha_c" name="i_fecha_c" readonly class="form-control form-control-sm fecha validate[required]" autocomplete="off"/>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-sm-2 col-md-2"><label for="i_nombre_corto_c" class="col-form-label requerido">Nombre Corto </label></div>
                    <div class="col-sm-3 col-md-3"><input type="text" id="i_nombre_corto_c" name="i_nombre_corto_c" readonly class="form-control form-control-sm validate[required]" autocomplete="off"/>
                    </div>
                    <div class="col-sm-1 col-md-2"></div>
                    <div class="col-sm-2 col-md-2"><label for="i_vigencia_c" class="col-form-label requerido">Vigencia </label></div>
                    <div class="col-sm-2 col-md-2"><input type="text" id="i_vigencia_c" name="i_vigencia_c" readonly class="form-control form-control-sm fecha validate[required]" autocomplete="off"/>
                    </div>
                </div>
                
                <div class="row">

                    <label for="i_cotizacion" class="col-2 col-md-2 col-form-label">Cotización </label>
                    <div class="input-group col-sm-12 col-md-3">
                        <!-- <input type="text" id="i_cotizacion" name="i_cotizacion" class="form-control validate[required]" readonly autocomplete="off"> -->
                        <input type="text" id="i_cotizacion" name="i_cotizacion" class="form-control" readonly autocomplete="off">
                        <input type="hidden" id="ta_texto_inicio" name="ta_texto_inicio">
                        <input type="hidden" id="ta_texto_fin" name="ta_texto_fin">
                        
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="b_buscar_cotizacion" style="margin:0px;">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="input-group-btn">
                            <button class="btn btn-info" type="button" id="b_detalle_cotizacion" style="margin:0px;" disabled>
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
            
                    <div class="col-sm-1 col-md-2"></div> 

                    <div class="col-sm-2 col-md-2" style="text-align:rigth;"><label for="s_tipo_contrato" class="col-form-label requerido">Tipo Contrato</label></div>
                    <div class="col-sm-3 col-md-3">
                            <select  id="s_tipo_contrato" name="s_tipo_contrato" class="form-control form-control-sm validate[required]" autocomplete="off"></select>
                    </div>

                </div>
                <br>
                <div class="row">
                    <label for="i_departamento" class="col-2 col-md-2 col-form-label">Departamento</label><br>       
                    <div class="input-group col-sm-5 col-md-5">
                        <input type="text" id="i_departamento" name="i_departamento" class="form-control" readonly autocomplete="off">
                        <!--<input type="text" id="i_departamento" name="i_departamento" class="form-control validate[required]" readonly autocomplete="off">-->
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="b_buscar_departamentos" alt="DO" style="margin:0px;">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2"></div>
                    <div class="col-sm-12 col-md-3">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Bajar Contratos" class="btn btn-info btn-sm form-control" id="b_bajar_contratos"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <i class="fa fa-file-word-o" aria-hidden="true"></i> Bajar Contratos</button>
                    </div>
                    
                    
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-2 col-md-2"><label for="i_archivo" class="col-form-label requerido">Subir Contrato </label></div>
                    <div class="col-sm-3 col-md-3"><input type="file" id="i_archivo" name="i_archivo" readonly class="form-control form-control-sm " autocomplete="off"/>
                    <input type="hidden" id="i_ruta_anterior" name="i_ruta_anterior"/>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Subir Contrato" class="btn btn-info btn-sm form-control" id="b_subir_contrato"><i class="fa fa-upload" aria-hidden="true"></i> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Subir Contrato</button>
                    </div>
                    
                    <div class="alert alert-primary col-md-5" role="alert" id="a_doc_modificado" style="display:none;">
                       
                    </div>
                </div>
                
                <div class="row">
                    <label for="i_razon_social_factura" class="col-4 col-md-4 col-form-label requerido">Razón Social con la que  se Factura</label><br>
                    <div class="col-sm-12 col-md-10">
                           <div class="row">
                               
                                <div class="input-group col-sm-12 col-md-9">
                                    <input type="text" id="i_razon_social_factura" name="i_razon_social_factura" class="form-control validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_rs_factura" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </div>
                  
                </div>
                <br>
                <div class="row">
                    <label for="i_razon_social_contrato" class="col-4 col-md-4 col-form-label requerido">Razón Social de Contratación</label><br>
                    <div class="col-sm-12 col-md-10">
                           <div class="row">
                               
                                <div class="input-group col-sm-12 col-md-9">
                                    <input type="text" id="i_razon_social_contrato" name="i_razon_social_contrato" class="form-control validate[required]" readonly autocomplete="off">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="b_buscar_rs_contrato" style="margin:0px;">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <label for="i_departamento_n" class="col-2 col-md-2 col-form-label ">Deptos. Multiples</label><br>       
                    <div class="input-group col-sm-5 col-md-5">
                        <input type="text" id="i_departamento_n" name="i_departamento_n" class="form-control" readonly autocomplete="off">
                        <!--<input type="text" id="i_departamento_n" name="i_departamento_n" class="form-control validate[required]" readonly autocomplete="off">--->
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="b_buscar_departamentos_add" alt="DV" style="margin:0px;">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-4">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="Asigar Contrato a Este cliente" class="btn btn-dark btn-sm form-control" id="b_vincular_departamento"><i class="fa fa-share-alt" aria-hidden="true"></i> Vincular Departamento a este Contrato</button>
                    </div>
                    
                    
                </div>

            </form>
            <br><br><br>
        </div>
    </div>  
</div><!-- fin  forma Contratos-->

    <!-- Inicia los modals--------------- -->
    <div id="dialog_buscar_clientes" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_clientes" id="i_filtro_clientes" class="form-control filtrar_renglones" alt="renglon_clientes" placeholder="Filtrar" autocomplete="off"></div>
                    </div>    
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon"  id="t_clientes">
                            <thead>
                                <tr class="renglon">
                                <th scope="col">ID</th>
                                <th scope="col">Nombre Comercial</th>
                                <th scope="col">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            </table>  
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>


    <div id="dialog_buscar_razones_sociales" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Razones Sociales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_razones_sociales" id="i_filtro_razones_sociales" class="form-control filtrar_renglones" alt="renglon_razones_sociales" placeholder="Filtrar" autocomplete="off"></div>
                    </div>    
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <table class="tablon"  id="t_razones_sociales">
                            <thead>
                                <tr class="renglon">
                                <th scope="col">Clave</th>
                                <th scope="col">Razón Social</th>
                                <th scope="col">RFC</th>
                                <th scope="col">Nombre Corto</th>
                                <th scope="col">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            </table>  
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>


<div id="dialog_buscar_cp" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Codigos Postales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label for="s_estados">Estado</label>
                    <select class="form-control coti" id="s_estados" style="width: 100%;" autocomplete="off"></select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label for="s_municipios">Municipio</label>
                    <select class="form-control coti" id="s_municipios" style="width: 100%;" autocomplete="off"></select>
                </div>
                <div class="col-sm-12 col-md-4"><br><input type="text" name="i_filtro_cp" id="i_filtro_cp" class="form-control filtrar_renglones" alt="renglon_cp" placeholder="Filtrar" autocomplete="off"></div>
            </div>                               
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cp">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Código Postal</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Municipio</th>
                          <th scope="col">Colonia</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_buscar_cp2" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Codigos Postales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <label for="s_estados">Estado</label>
                    <select class="form-control coti" id="s_estados2" style="width: 100%;" autocomplete="off"></select>
                </div>
                <div class="col-sm-12 col-md-4">
                    <label for="s_municipios">Municipio</label>
                    <select class="form-control coti" id="s_municipios2" style="width: 100%;" autocomplete="off"></select>
                </div>
                <div class="col-sm-12 col-md-4"><br><input type="text" name="i_filtro_cp2" id="i_filtro_cp2" class="form-control filtrar_renglones" alt="renglon_cp2" placeholder="Filtrar" autocomplete="off"></div>
            </div>                               
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_cp2">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Código Postal</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Municipio</th>
                          <th scope="col">Colonia</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_cotizaciones" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Búsqueda de Cotizaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="i_filtro_cotizaciones" id="i_filtro_cotizaciones" alt="renglon_cotizaciones" class="form-control filtrar_renglones" placeholder="Filtrar" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_cotizaciones">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Folio</th>
                            <th scope="col">Cotización</th>
                            <th scope="col">Versión</th>
                            <th scope="col">Fecha Creación</th>
                            <th scope="col">Proyecto</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Sucursal</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Estatus Cotización</th>
                            <th scope="col">Estatus Proyecto</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div id="dialog_buscar_departamentos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Búsqueda de Departamentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-md-6"><input type="text" name="i_filtro_departamentos" id="i_filtro_departamentos" class="form-control filtrar_renglones" alt="renglon_departamentos" placeholder="Filtrar" autocomplete="off"></div>
            </div>    
            <br>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <table class="tablon"  id="t_departamentos">
                      <thead>
                        <tr class="renglon">
                          <th scope="col">Clave</th>
                          <th scope="col">Descripción</th>
                          <th scope="col">Unidad</th>
                          <th scope="col">Sucursal</th>
                          <th scope="col">Area</th>
                          <th scope="col">Estatus</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog_buscar_razon_social_factura" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Razón Social que Factura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_razon_social_factura" id="i_filtro_razon_social_factura" class="form-control filtrar_renglones" alt="renglon_razon_social_factura" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_razon_social_factura">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Razón Social</th>
                            <th scope="col">RFC</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>  
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>

<div id="dialog_buscar_razon_social_contrato" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Búsqueda de Razón Social Contratación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-10"><input type="text" name="i_filtro_razon_social_contrato" id="i_filtro_razon_social_contrato" class="form-control filtrar_renglones" alt="renglon_razon_social_contrato" placeholder="Filtrar" autocomplete="off"></div>
                </div>    
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <table class="tablon"  id="t_razon_social_contrato">
                        <thead>
                            <tr class="renglon">
                            <th scope="col">Razón Social</th>
                            <th scope="col">RFC</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        </table>  
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dialog_detalle_cotizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Cotización</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			    
			</div>
			<div class="modal-body">
					<div style="width:100%" id="div_archivo"></div>
			</div>
		
		</div>
	</div>
</div>

</body> 

<script src="js/jquery3.3.1/jquery-3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/js/bootstrap.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-es.js"></script>
<script src="js/general.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="vendor/select2/js/select2.js"></script>

<script>
 
    var idCliente=<?php echo $idCliente?>;
    var regresar=<?php echo $regresar?>;
    var tipoMov=0, tipoMovR=0, tipoMovC=0;
    var clienteOriginal='';
    var idRazonSocial=0,idContrato=0;
    var razonSocialOriginal='';
    var modulo='CLIENTES';
    var idUnidadActual=<?php echo $_SESSION['id_unidad_actual']?>;
    var idUsuario=<?php echo $_SESSION['id_usuario']?>;
    var usuario='<?php echo $_SESSION['usuario']?>';
    var estatus = 'A';

    var totalPartidas = 0;
    var matriz = <?php echo $_SESSION['sucursales']?>;
    var buscarDepartamento='DO';//DO es departamento original DV nuevo departamento a vincular
    $(function(){

        mostrarBotonAyuda(modulo);

        muestraSucursalCorporativo('i_id_sucursal',idUnidadActual,modulo,idUsuario);
        muestraSelectTiposContratos('s_tipo_contrato');
        $('#ch_inactivo').prop('checked',false).prop('disabled',true); 

        $("#div_principal").css({left : "0%"}); 

        $('#b_agregar_razon_social').prop('disabled',true);

        if(regresar==1 && idCliente>0 ){
         
            muestraRegistro();
            muestraRazonesSociales();
        }
        

        $('#b_agregar_razon_social').on('click',function(){
            tipoMovR=0;
            idRazonSocial=0; 
           
            $("#div_principal").animate({left : "-101%"}, 500, 'swing');
            $('#div_razon_social').animate({left : "0%"}, 600, 'swing');

            $('#form_razon_social').find('input,textarea').val('');
            $('#form_razon_social select').val(0);
            $('#ch_activo').prop('checked',true).prop('disabled',true); 
            $('#b_guardar_razon_social').prop('disabled',false);
            $('#b_asignar_unidades').prop('disabled',true);
            muestraSelectPaises('s_pais');
            muestraSelectPaises('s_pais2');
            muestraSelectRegimen("s_regimen");
        });
        $('#b_regresar').on('click',function(){
           
            $("#div_razon_social").animate({left : "-101%"}, 500, 'swing');
            $('#div_principal').animate({left : "0%"}, 600, 'swing');
        });
    
    
        $('.fecha').datepicker({
            format : "yyyy-mm-dd",
            autoclose: true,
            language: "es",
            todayHighlight: true
        });

        $('#b_buscar').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_clientes').val('');
            $('.renglon_clientes').remove();

            $.ajax({

                type: 'POST',
                url: 'php/clientes_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_clientes').remove();
                
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_clientes" alt="'+data[i].id+'">\
                                        <td data-label="ID">' + data[i].id+ '</td>\
                                        <td data-label="NOMBRE COMERCIAL">' + data[i].nombre_comercial+ '</td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_clientes tbody').append(html);   
                            $('#dialog_buscar_clientes').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_clientes').on('click', '.renglon_clientes', function() {
            $('#b_guardar_razon_social').prop('disabled',false);
            tipoMov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('disabled', false);
            idCliente = $(this).attr('alt');
            
            $('#dialog_buscar_clientes').modal('hide');
            $('#b_agregar_razon_social').prop('disabled',false);
            muestraRegistro();
            muestraRazonesSociales();


        });



        function muestraRegistro(){ 

            $.ajax({
                type: 'POST',
                url: 'php/clientes_buscar_id.php',
                dataType:"json", 
                data:{
                    'idCliente':idCliente
                },
                success: function(data) 
                { 
                    idCliente=data[0].id;
                    clienteOriginal=data[0].nombre_comercial;
                    $('#i_id_cliente').val(idCliente);
                    $('#i_fecha_inicio').val(data[0].fecha_inicio);
                    $('#i_nombre_comercial').val(data[0].nombre_comercial);
                    $('#ta_datos_contacto').val(data[0].datos_contacto);
                    
                
                    if (data[0].inactivo == 0) {
                        $('#ch_inactivo').prop('checked', false);
                    } else {
                        $('#ch_inactivo').prop('checked', true);
                    }
                
                
                },
                error: function (xhr) {
                    console.log('php/clientes_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error al buscar el cliente con clave: '+idCliente);
                }
            });
        }

        function muestraRazonesSociales(){ 
            $('.renglon_razones_sociales_cliente').remove();
            $.ajax({
                type: 'POST',
                url: 'php/razones_sociales_buscar_id_cliente.php',
                dataType:"json", 
                data:{
                    'idCliente':idCliente
                },
                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_razones_sociales_cliente').remove();
                
                        for(var i=0;data.length>i;i++){

                            var boton='<button type="button" data-toggle="tooltip" data-placement="top" title="Editar Razón social" class="btn btn-info btn-sm form-control" id="b_editar_razon_social" alt="'+data[i].id+'"><i class="fa fa-pencil" aria-hidden="true"></i></button>';

                            var html='<tr class="renglon_razones_sociales_cliente" alt="'+data[i].id+'">\
                                        <td data-label="Razón Social">' + data[i].razon_social+ '</td>\
                                        <td data-label="Nombre Corto">' + data[i].nombre_corto+ '</td>\
                                        <td data-label="RFC">' + data[i].rfc+ '</td>\
                                        <td data-label="Razón Social"></td>\
                                        <td data-label="Estatus">' + data[i].estatus+ '</td>\
                                        <td data-label="Estatus">' + boton+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_razones_sociales_cliente tbody').append(html);   
                        }
                }else{

                        mandarMensaje('No se encontraron razones sociales sobre este cliente');
                }

                },
                error: function (xhr) {
                    console.log('php/clientes_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error al buscar el cliente con clave: '+idCliente);
                }
            });
        }

        
        

        


        $('#b_buscar_razones_sociales').on('click',function(){

            $('#forma').validationEngine('hide');
            $('#i_filtro_razones_sociales').val('');
            $('.renglon_razones_sociales').remove();

            $.ajax({

                type: 'POST',
                url: 'php/razones_sociales_buscar.php',
                dataType:"json", 
                data:{'estatus':2},

                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_razones_sociales').remove();
                
                        for(var i=0;data.length>i;i++){

                            var html='<tr class="renglon_razones_sociales" alt="'+data[i].id_cliente+'">\
                                        <td data-label="Clave">' + data[i].id+ '</td>\
                                        <td data-label="Razón Social">' + data[i].razon_social+ '</td>\
                                        <td data-label="Nombre Corto">' + data[i].nombre_corto+ '</td>\
                                        <td data-label="RFC">' + data[i].rfc+ '</td>\
                                        <td data-label="Estatus">' + estatus+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_razones_sociales tbody').append(html);   
                            $('#dialog_buscar_razones_sociales').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    
                    mandarMensaje('Error en el sistema');
                }
            });
        });

        $('#t_razones_sociales').on('click', '.renglon_razones_sociales', function() {

            tipoMov = 1;
            $('#b_guardar').prop('disabled',false);
            $('#ch_inactivo').prop('disabled', false);
            idCliente = $(this).attr('alt');

            $('#dialog_buscar_razones_sociales').modal('hide');
            $('#b_agregar_razon_social').prop('disabled',false);
            muestraRegistro();
            muestraRazonesSociales();
            
        });

        $('#b_guardar').click(function(){

            $('#b_guardar').prop('disabled',true);

            if ($('#form_cliente').validationEngine('validate')){
                
                verificar();

            }else{
            
                $('#b_guardar').prop('disabled',false);
            }
        });


        function verificar(){

            $.ajax({
                type: 'POST',
                url: 'php/clientes_verificar.php',
                dataType:"json", 
                data:  {'nombreComercial':$('#i_nombre_comercial').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipoMov == 1 && clienteOriginal === $('#i_nombre_comercial').val()) {
                            guardar();
                        } else {

                            mandarMensaje('El nombre comercial : '+ $('#i_nombre_comercial').val()+' ya existe intenta con otro');
                            $('#i_nombre_comercial').val('');
                            $('#b_guardar').prop('disabled',false);
                        }
                    } else {
                        guardar();
                    }
                },
                error: function (xhr) {
                    console.log('php/clientes_verificar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('Error al verificar el nombre coemrcial del cliente');
                    $('#b_guardar').prop('disabled',false);
                }
            });
        }


        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardar(){

            $.ajax({
                type: 'POST',
                url: 'php/clientes_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatos()

                },
                //una vez finalizado correctamente
                success: function(data){
                
                    if (data > 0 ) {
                        if (tipoMov == 0){
                            
                            mandarMensaje('Se guardó el nuevo registro');
                            $('#b_nuevo').click();

                        }else{
                                
                            mandarMensaje('Se actualizó el registro');
                            $('#b_nuevo').click();
                            
                        }
                    

                    }else{
                        
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                error: function(xhr){
                
                    console.log('php/clientes_guardar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el guardado');
                    $('#b_guardar').prop('disabled',false);
                }
            });

        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatos(){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var paq = {
                    'tipoMov' : tipoMov,
                    'idCliente' : idCliente,
                    'nombreComercial' : $('#i_nombre_comercial').val(),
                    'fechaInicio' : $('#i_fecha_inicio').val(),
                    'datosContacto' : $('#ta_datos_contacto').val(),
                    'inactivo' : $("#ch_inactivo").is(':checked') ? 1 : 0
                    
                }
                paquete.push(paq);
            
            return paquete;
        }  

        //*********************MODULO DE RAZONES SOCIALES************************************** */
        
        $(document).on('click','#b_editar_razon_social',function(){
            idRazonSocial=$(this).attr('alt');
            $('#div_razon_social').animate({left : "0%"}, 600, 'swing');
            $("#div_principal").animate({left : "-101%"}, 500, 'swing');            
            
            $('#form_razon_social input,textarea').val('');
            $('#form_razon_social select').val(0);
            $('#b_guardar_razon_social').prop('disabled',false);
            $('#ch_activo').prop('disabled',false); 
            $('#b_asignar_unidades').prop('disabled',false);
            muestraSelectPaises('s_pais');
            muestraSelectPaises('s_pais2');
            muestraSelectRegimen("s_regimen");
            muestraRegistroRazonSocial();
            muestraContratos();
        });

        function muestraRegistroRazonSocial(){ 
            tipoMovR=1;
            $.ajax({
                type: 'POST',
                url: 'php/razones_sociales_buscar_id.php',
                dataType:"json", 
                data:{
                    'idRazonSocial':idRazonSocial
                },
                success: function(data) 
                { 
                    razonSocialOriginal=data[0].nombre_corto;
                    $('#i_rfc').val(data[0].rfc);
                    $('#i_nombre_corto').val(data[0].nombre_corto);
                    $('#i_razon_social').val(data[0].razon_social);
                    $('#i_representante').val(data[0].r_legal);
                    $("#i_correorepresentante").val(data[0].correo_r_legal);
                    $("#i_telefonorepresentante").val(data[0].telefono_r_legal);

                    //Domicilio fiscal
                    $('#i_domicilio').val(data[0].domicilio);
                    $('#i_cp').val(data[0].codigo_postal);
                    $('#i_colonia').val(data[0].colonia);
                    $('#i_num_int').val(data[0].no_interior);
                    $('#i_num_ext').val(data[0].no_exterior);
                    if(data[0].id_pais != 0){
                        $('#s_pais').val(data[0].id_pais);
                        $('#s_pais').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_pais').val('');
                        $('#s_pais').select2({placeholder: 'Selecciona'});
                    }
                    $('#i_id_estado').val(data[0].id_estado);
                    $('#i_estado').val(data[0].estado);
                    $('#i_id_municipio').val(data[0].id_municipio);
                    $('#i_municipio').val(data[0].municipio);

                    //Domicilio servicio
                    $('#i_domicilio2').val(data[0].domicilio_servicio);
                    $('#i_cp2').val(data[0].codigo_postal_servicio);
                    $('#i_colonia2').val(data[0].colonia_servicio);
                    $('#i_num_int2').val(data[0].no_interior_servicio);
                    $('#i_num_ext2').val(data[0].no_exterior_servicio);
                    if(data[0].id_pais_servicio != 0){
                        $('#s_pais2').val(data[0].id_pais_servicio);
                        $('#s_pais2').select2({placeholder: $(this).data('elemento')});
                    }else{
                        $('#s_pais2').val('');
                        $('#s_pais2').select2({placeholder: 'Selecciona'});
                    }
                    $('#i_id_estado2').val(data[0].id_estado_servicio);
                    $('#i_estado2').val(data[0].estado2);
                    $('#i_id_municipio2').val(data[0].id_municipio_servicio);
                    $('#i_municipio2').val(data[0].municipio2);
                    $('#i_entrecalle').val(data[0].entrecalle_servicio);
                    $("#i_celularservicio").val(data[0].celular_servicio);
                    $("#i_posicion").val(data[0].posicion);

                    //Datos contacto Administrativo
                    $('#i_telefono').val(data[0].telefono);
                    $('#i_extension').val(data[0].ext);
                    $('#i_contacto').val(data[0].contacto);
                    $('#i_correos').val(data[0].email);

                    //Datos contacto Operativo
                    $('#i_telefono2').val(data[0].telefono_operativo);
                    $('#i_extension2').val(data[0].ext_operativo);
                    $('#i_contacto2').val(data[0].contacto_operativo);
                    $('#i_correos2').val(data[0].correo_operativo);

                    //facturacion
                    $('#i_dias_credito').val(data[0].dias_cred);
                    $('#i_credito_limite').val(formatearNumero(data[0].limite_cred));
                    $('#i_credito_activo').val(formatearNumero(data[0].cred_activo));
                    $('#s_periodicidad').val(data[0].periodicidad);
                    $('#s_tipo_facturacion').val(data[0].tipo_facturacion);
                    $('#i_dia').val(data[0].dia);
                    if(data[0].regimen != ""){
                        $('#s_regimen').val(data[0].regimen);
                        $('#s_regimen').select2({placeholder: $(this).data('elemento')});
                    }
                
                    if (data[0].activo == 1) {
                        $('#ch_activo').prop('checked', true);
                    } else {
                        $('#ch_activo').prop('checked', false);
                    }
                
                
                },
                error: function (xhr) {
                    console.log('php/razones_sociales_buscar_id.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error al buscar la razon social: '+idRazonSocial);
                }
            });
        }

    

        $('#b_guardar_razon_social').click(function(){

            $('#b_guardar_razon_social').prop('disabled',true);

            if ($('#form_razon_social').validationEngine('validate')){
                
                verificarRazonSocial();

            }else{
            
                $('#b_guardar_razon_social').prop('disabled',false);
            }
        });


        function verificarRazonSocial(){

            $.ajax({
                type: 'POST',
                url: 'php/razones_sociales_verificar.php',
                dataType:"json", 
                data:  {'nombreCorto':$('#i_nombre_corto').val()},
                success: function(data) 
                {
                    if(data == 1){
                        
                        if (tipoMovR == 1 && razonSocialOriginal === $('#i_nombre_corto').val()) {
                            guardarRazonSocial();
                        } else {

                            mandarMensaje('El nombre corto : '+ $('#i_nombre_corto').val()+' ya existe intenta con otro');
                            $('#i_nombre_corto').val('');
                            $('#b_guardar_razon_social').prop('disabled',false);
                        }
                    } else {
                        guardarRazonSocial();
                    }
                },
                error: function (xhr) {
                    console.log('php/razones_sociales_verificar.php -->'+JSON.stringify(xhr));
                    mandarMensaje('Error al verificar el nombre corto de la razon social');
                }
            });
        }


        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardarRazonSocial(){

            $.ajax({
                type: 'POST',
                url: 'php/razones_sociales_guardar.php', 
                dataType:"json", 
                data: {
                        'datos':obtenerDatosRazonesSociales()
                },
                //una vez finalizado correctamente
                success: function(data){
                
                    if (data > 0 ) {
                        if (tipoMov == 0){
                            
                            mandarMensaje('Se guardó el nuevo registro');
                            $('#b_regresar').click();
                            muestraRazonesSociales();

                        }else{
                                
                            mandarMensaje('Se actualizó el registro');
                            $('#b_regresar').click();
                            muestraRazonesSociales();
                            
                        }
                    

                    }else{
                        
                        mandarMensaje('Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }

                },
                    //si ha ocurrido un error
                error: function(xhr){
                
                    console.log('php/razones_sociales_guardar.php -->'+JSON.stringify(xhr));
                    $('#b_guardar').prop('disabled',false);
                    mandarMensaje('Error en el guardado');
                }
            });

        }
        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatosRazonesSociales(){
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var paq = {
                'tipoMovR' : tipoMovR,
                'idRazonSocial' : idRazonSocial,
                'idCliente' : idCliente,
                'rfc' : $('#i_rfc').val(),
                'nombreCorto' : $('#i_nombre_corto').val(),
                'razonSocial' : $('#i_razon_social').val(),
                'representanteLegal' : $('#i_representante').val(),
                'correoRepresentanteLegal' : $('#i_correorepresentante').val(),
                'telefonoRepresentanteLegal' : $('#i_telefonorepresentante').val(),

                'domicilio' : $('#i_domicilio').val(),
                'codigoPostal' : $('#i_cp').val(),
                'colonia' : $('#i_colonia').val(),
                'noInt' : $('#i_num_int').val(),
                'noExt' : $('#i_num_ext').val(),
                'idPais' : $('#s_pais').val(),
                'idEstado' : $('#i_id_estado').val(),
                'idMunicipio' : $('#i_id_municipio').val(),

                'domicilio2' : $('#i_domicilio2').val(),
                'codigoPostal2' : $('#i_cp2').val(),
                'colonia2' : $('#i_colonia2').val(),
                'noInt2' : $('#i_num_int2').val(),
                'noExt2' : $('#i_num_ext2').val(),
                'idPais2' : $('#s_pais2').val(),
                'idEstado2' : $('#i_id_estado2').val(),
                'idMunicipio2' : $('#i_id_municipio2').val(),
                'entreCalles' : $('#i_entrecalle').val(),
                'celularServicio': $("#i_celularservicio").val(),
                'posicion' : $("#i_posicion").val(),

                'telefonos' : $('#i_telefono').val(),
                'extension' : $('#i_extension').val(),
                'contacto' : $('#i_contacto').val(),
                'correo' : $('#i_correos').val(),

                'telefonos2' : $('#i_telefono2').val(),
                'extension2' : $('#i_extension2').val(),
                'contacto2' : $('#i_contacto2').val(),
                'correo2' : $('#i_correos2').val(),

                'diasCredito' : $('#i_dias_credito').val(),
                'creditoLimite' : quitaComa($('#i_credito_limite').val()),
                'creditoActivo' : quitaComa($('#i_credito_activo').val()),
                'periodicidad' : $('#s_periodicidad').val(),
                'tipo_facturacion':$('#s_tipo_facturacion').val(),
                'dia' : $('#i_dia').val(),
                'regimen' : $("#s_regimen").val(),

                'activo' : $("#ch_activo").is(':checked') ? 1 : 0
                    
            }
                
            paquete.push(paq);
            
            return paquete;
        }  


        //***********BUSCAR Código Postal Y SUS VALORES************** */  
        //************Busca los cp por estado y municipio */
        $('#b_buscar_cp').on('click',function(){

            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();
            muestraSelectEstados('s_estados');
            muestraSelectMunicipios('s_municipios',0);
            $('#dialog_buscar_cp').modal('show'); 

        });

        $('#b_buscar_cp2').on('click',function(){

            $('#i_filtro_cp2').val('');
            $('.renglon_cp2').remove();
            muestraSelectEstados('s_estados2');
            muestraSelectMunicipios('s_municipios2',0);
            $('#dialog_buscar_cp2').modal('show'); 

        });

        $(document).on('change','#s_estados',function(){
            buscarCp($('#s_estados').val(),0);
            muestraSelectMunicipios('s_municipios',$('#s_estados').val());
        });
        $(document).on('change','#s_municipios',function(){
            buscarCp($('#s_estados').val(),$('#s_municipios').val());
        });

        $(document).on('change','#s_estados2',function(){
            buscarCp2($('#s_estados2').val(),0);
            muestraSelectMunicipios('s_municipios2',$('#s_estados2').val());
        });
        $(document).on('change','#s_municipios2',function(){
            buscarCp2($('#s_estados2').val(),$('#s_municipios2').val());
        });

        function buscarCp(idEstado,idMunicipio){
            $('#i_filtro_cp').val('');
            $('.renglon_cp').remove();

            $.ajax({

                type: 'POST',
                url: 'php/codigo_postal_buscar.php',
                dataType:"json", 
                data:{
                    'idEstado':idEstado,
                    'idMunicipio': idMunicipio
                },
                success: function(data) {
                
                if(data.length != 0){

                    $('.renglon_cp').remove();
                
                    for(var i=0;data.length>i;i++){

                        ///llena la tabla con renglones de registros

                        var html='<tr class="renglon_cp" alt="'+data[i].id_colonia+'" alt2="'+data[i].colonia+'" alt3="'+data[i].codigo_postal+'" alt4="'+data[i].estado+'" alt5="'+data[i].id_estado+'"alt6="'+data[i].municipio+'"alt7="'+data[i].id_municipio+'">\
                                    <td data-label="ID">' + data[i].codigo_postal+ '</td>\
                                    <td data-label="Clave">' + data[i].estado+ '</td>\
                                    <td data-label="Descripción">' + data[i].municipio+ '</td>\
                                    <td data-label="Tallas">' + data[i].colonia+ '</td>\
                                </tr>';
                        ///agrega la tabla creada al div 
                        $('#t_cp tbody').append(html);   
                            
                    }
                }else{

                    mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/codigo_postal_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        function buscarCp2(idEstado,idMunicipio){
            $('#i_filtro_cp2').val('');
            $('.renglon_cp2').remove();

            $.ajax({

                type: 'POST',
                url: 'php/codigo_postal_buscar.php',
                dataType:"json", 
                data:{
                    'idEstado':idEstado,
                    'idMunicipio': idMunicipio
                },
                success: function(data) {
                
                if(data.length != 0){

                    $('.renglon_cp2').remove();
                
                    for(var i=0;data.length>i;i++){

                        ///llena la tabla con renglones de registros

                        var html='<tr class="renglon_cp2" alt="'+data[i].id_colonia+'" alt2="'+data[i].colonia+'" alt3="'+data[i].codigo_postal+'" alt4="'+data[i].estado+'" alt5="'+data[i].id_estado+'"alt6="'+data[i].municipio+'"alt7="'+data[i].id_municipio+'">\
                                    <td data-label="ID">' + data[i].codigo_postal+ '</td>\
                                    <td data-label="Clave">' + data[i].estado+ '</td>\
                                    <td data-label="Descripción">' + data[i].municipio+ '</td>\
                                    <td data-label="Tallas">' + data[i].colonia+ '</td>\
                                </tr>';
                        ///agrega la tabla creada al div 
                        $('#t_cp2 tbody').append(html);   
                            
                    }
                }else{

                    mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/codigo_postal_buscar.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error en el sistema');
                }
            });
        }

        $('#t_cp').on('click', '.renglon_cp', function() {

            var  idColonia = $(this).attr('alt');
            var  colonia = $(this).attr('alt2');
            var  cp = $(this).attr('alt3');
            var  estado = $(this).attr('alt4');
            var  idEstado = $(this).attr('alt5');
            var  municipio = $(this).attr('alt6');
            var  idMunicipio = $(this).attr('alt7');

            $('#i_cp').val(cp);
            $('#i_colonia').val(colonia).attr('alt',idColonia);
            $('#i_id_estado').val(idEstado);
            $('#i_id_municipio').val(idMunicipio);
            $('#i_estado').val(estado);
            $('#i_municipio').val(municipio);
            
            $('#dialog_buscar_cp').modal('hide');

        });  

        $('#t_cp2').on('click', '.renglon_cp2', function() {

            var  idColonia = $(this).attr('alt');
            var  colonia = $(this).attr('alt2');
            var  cp = $(this).attr('alt3');
            var  estado = $(this).attr('alt4');
            var  idEstado = $(this).attr('alt5');
            var  municipio = $(this).attr('alt6');
            var  idMunicipio = $(this).attr('alt7');

            $('#i_cp2').val(cp);
            $('#i_colonia2').val(colonia).attr('alt',idColonia);
            $('#i_id_estado2').val(idEstado);
            $('#i_id_municipio2').val(idMunicipio);
            $('#i_estado2').val(estado);
            $('#i_municipio2').val(municipio);

            $('#dialog_buscar_cp2').modal('hide');

        });  


        /***************************PERIODICIDAD*********************************/
        $('#s_periodicidad').on('change',function(){
            var valor=$(this).val();
            if( valor > 0 ){
                generaCampoDia(valor,'');
            }
        });

        $(document).on('change','#i_dia',function(){
            $(this).validationEngine('validate');
        });

        
        function generaCampoDia(periodicidad,valor){

            $('#contenedor_dia').html('').removeAttr('class');

            if(periodicidad==1){
                var html='<select class="form-control validate[required] coti" id="i_dia" name="i_dia">';
                    html+='<option value="0" disabled selected>Selecciona</option>';   
                    html+='<option value="L">Lunes</option>';
                    html+='<option value="M">Martes</option>';
                    html+='<option value="X">Miercoles</option>';
                    html+='<option value="J">Jueves</option>';
                    html+='<option value="V">Viernes</option>';
                    html+='<option value="S">Sabado</option>';
                    html+='<option value="D">Domingo</option>';
                    html+='</select>';
                $('#contenedor_dia').addClass('col-sm-3 col-md-3').append(html);  
                $('#i_dia').val(valor);
                              
            }else if( periodicidad==3){
                var html='<input type="text" id="i_dia" name="i_dia"  class="form-control validate[required,custom[integer],min[1],max[15]] coti" size="2" autocomplete="off" value="'+valor+'" >';
                $('#contenedor_dia').addClass('col-sm-1 col-md-1').append(html);
            }else{
                var html='<select class="form-control validate[required] coti" id="i_dia" name="i_dia">';
                    html+='<option value="0" disabled selected>Selecciona</option>';   
                    html+='<option value="Q1">01 - 16</option>';
                    html+='<option value="Q2">02 - 17</option>';
                    html+='<option value="Q3">03 - 18</option>';
                    html+='<option value="Q4">04 - 19</option>';
                    html+='<option value="Q5">05 - 20</option>';
                    html+='<option value="Q6">06 - 21</option>';
                    html+='<option value="Q7">07 - 22</option>';
                    html+='<option value="Q8">08 - 23</option>';
                    html+='<option value="Q9">09 - 24</option>';
                    html+='<option value="Q10">10 - 25</option>';
                    html+='<option value="Q11">11 - 26</option>';
                    html+='<option value="Q12">12 - 27</option>';
                    html+='<option value="Q13">13 - 28</option>';
                    html+='<option value="Q14">14 - 29</option>';
                    html+='<option value="Q15">15 - 30</option>';
                    html+='</select>';
                $('#contenedor_dia').addClass('col-sm-2 col-md-2').append(html);  
                $('#i_dia').val(valor);
            }
            
        }
        /***************************FIN PERIODICIDAD*****************************/





        $('#b_nuevo').on('click',function(){
            limpiar();
        });
        /* Limpia el modulo comple al dar click en nuevo o guardad*/
        function limpiar(){

            idCliente=0;
            clienteOriginal='';
            tipoMov=0;
            $('input,textarea').not('input:radio').val('');
            $('form').validationEngine('hide');
            $('#b_guardar').prop('disabled',false);
            $('#b_agregar_razon_social').prop('disabled',true);
            $('#ch_inactivo').prop('checked',false).prop('disabled',true);
            $('.renglon_razones_sociales_cliente').remove();   
        }

        $('#b_excel').click(function(){
            var html = '';
            var aux = new Date();
            var hoy = aux.getFullYear()+'_'+(aux.getMonth()+1)+'_'+aux.getDate();

            $('#i_nombre_excel').val('Registros Clientes');
            $('#i_fecha_excel').val(hoy);
            $('#i_modulo_excel').val('CLIENTES');

            $("#f_imprimir_excel").submit();
        });


        $('#b_asignar_unidades').on('click',function(){
            
            var razonSocial='';
          
            var idCliente=0;
            if(idRazonSocial>0){
               
                razonSocial=$('#i_razon_social').val();
                idCliente= $(document).find('#i_id_cliente').val();

            }
      
           window.open("fr_clientes_razones_sociales_accesos.php?idRazonSocial="+idRazonSocial+"&razonSocial="+razonSocial+"&idCliente="+idCliente,"_self");
        }); 
        
        //******************** MODLO DE CONTRATOS********************************** */

        function muestraContratos(){ 
            $('.renglon_contratos_c').remove();
            $.ajax({
                type: 'POST',
                url: 'php/contratos_buscar_cliente.php',
                dataType:"json", 
                data:{
                    'idCliente':idCliente
                },
                success: function(data) {
                
                if(data.length != 0){

                        $('.renglon_contratos_c').remove();
                
                        for(var i=0;data.length>i;i++){

                            var boton='<button type="button" data-toggle="tooltip" data-placement="top" title="Editar Razón social" class="btn btn-info btn-sm form-control" id="b_editar_contrato" alt="'+data[i].id_contrato+'" alt2="'+data[i].nombre_corto+'" alt3="'+data[i].rfc+'" ><i class="fa fa-pencil" aria-hidden="true"></i></button>';

                            var html='<tr class="renglon_contratos_c" alt="'+data[i].id_contrato+'">\
                                        <td data-label="Id Contrato">' + data[i].id_contrato+ '</td>\
                                        <td data-label="Departamento">' + data[i].departamento+ '</td>\
                                        <td data-label="Supervisor">' + data[i].supervisor+ '</td>\
                                        <td data-label="Fecha">' + data[i].fecha+ '</td>\
                                        <td data-label="Vigencia">'+data[i].vigencia+'</td>\
                                        <td data-label="RS Cliente">' + data[i].rs_cliente+ '</td>\
                                        <td data-label="RS Factura">' + data[i].rs_factura+ '</td>\
                                        <td data-label="Rs Contrato">' + data[i].rs_contrato+ '</td>\
                                        <td data-label="">' + boton+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_contratos_cliente tbody').append(html);   
                        }
                }else{

                        mandarMensaje('No se encontraron contratos sobre este cliente');
                }

                },
                error: function (xhr) {
                    console.log('php/contratos_buscar_cliente.php-->'+JSON.stringify(xhr));
                    mandarMensaje('Error al buscar contratos del el cliente con clave: '+idCliente);
                }
            });
        }
        //**** CALCULA LA FECHA DE VIGENCIA QUE ES IGUAL A LA FECHA MAS UN AÑO */
        function fechaVigencia(){

            var inicio=document.getElementById("i_fecha_c").value;
            var start=new Date(inicio);
            start.setFullYear(start.getFullYear()+1);
            var startf = start.toISOString().slice(0,10);
            document.getElementById("i_vigencia_c").value= startf;
        }

        $(document).on('change','#i_fecha_c',function(){
            if($(this).val()!=''){
                fechaVigencia();
                $('#i_departamento').attr('alt',0).attr('alt2',0).val('');
            }
        });

        $('#b_agregar_contrato').on('click',function(){
            
            tipoMovC=0;
            idContrato=0;

            $('#div_contratos').animate({left : "0%"}, 600, 'swing');
            $("#div_razon_social").animate({left : "-101%"}, 500, 'swing');

            var nComercial=$(document).find('#i_nombre_comercial').val();
            var nCorto=$(document).find('#i_nombre_corto').val();
            var rfcC=$(document).find('#i_rfc').val();

            $('#i_id_cliente_c').val(idCliente);
            $('#i_id_razon_social_c').val(idRazonSocial);
            $('#i_id_contrato').val('');
            $('#i_nombre_comercial_c').val(nComercial);
            $('#i_nombre_corto_c').val(nCorto);
            $('#i_rfc_c').val(rfcC);
            $('#i_fecha_c').val(hoy);
            
            $('#i_departamento').attr('alt',0).attr('alt2',0).val('');
            $('#i_razon_social_factura').attr('alt',0).val('');
            $('#i_razon_social_contrato').attr('alt',0).val('');
            $('#i_cotizacion').attr('alt',0).val('');
            $('#s_tipo_contrato').val('');
           
            $('#a_doc_modificado').hide();
            $('#i_ruta_anterior').val('');
            $('#b_subir_contrato').prop('disabled',true).attr('alt',0);
            $('#b_bajar_contratos').prop('disabled',true).attr('alt',0);
            $('#i_archivo').prop('disabled',true);
            fechaVigencia();
              
        });

        $('#b_regresar_rs').on('click',function(){

            $('#div_razon_social').animate({left : "0%"}, 600, 'swing');
            $("#div_contratos").animate({left : "-101%"}, 500, 'swing');

            muestraContratos();
            
        });

        /******* Busca todas las cotixzaciones mediante filtros ingresados*********/
        $(document).on('click','#b_buscar_cotizacion',function(){
            
            $.ajax({
                type: 'POST',
                url: 'php/cotizaciones_buscar_por_rfc.php',
                dataType:"json", 
                data:{'rfc':$('#i_rfc_c').val()},
                success: function(data) {
                      
                    $('.renglon_cotizaciones').remove();

                    if(data.length != 0){
                   
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var activo='';
                            
                            if(parseInt(data[i].estatus_cotizacion) == 1){

                                activo='Activa';
                            }else{
                                activo='Impresa';
                            }

                            var html='<tr class="renglon_cotizaciones" alt="'+data[i].id+'" alt2="'+data[i].folio+'" alt3="'+data[i].texto_inicio+'" alt4="'+data[i].texto_fin+'" alt5="'+data[i].id_sucursal+'">\
                                        <td data-label="Folio">' + data[i].folio+ '</td>\
                                        <td data-label="Cotizacion">' + data[i].cotizacion+ '</td>\
                                        <td data-label="Version">' + data[i].version+ '</td>\
                                        <td data-label="Fecha Creacion">' + data[i].fecha_creacion+ '</td>\
                                        <td data-label="Proyecto">' + data[i].proyecto+ '</td>\
                                        <td data-label="Cliente">' + data[i].cliente+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Usuario">' + data[i].usuario+ '</td>\
                                        <td data-label="Estatus Cotizacion">' + activo+ '</td>\
                                        <td data-label="Estatus Proyecto">' + data[i].estatus_proyecto+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_cotizaciones tbody').append(html);
                            $('#dialog_cotizaciones').modal('show');   
 
                        }
                   }else{

                        mandarMensaje('No se encontraron cotizaciones con esos datos.');
                   }

                },
                error: function (xhr) {
                    console.log('cotizaciones_buscar_por_rfc:'+JSON.stringify(xhr));
                    mandarMensaje('No se encontró información al buscar cotizacion por RFC');
                }
            });
        });    
        

        /******* Al dar click sobre alguna cotizacion esta manda a buscar los datos de la cotizacion selecionada *********/
        $('#t_cotizaciones').on('click', '.renglon_cotizaciones', function() {
           
            var idCotizacion = $(this).attr('alt');
            var folio = $(this).attr('alt2');
            var idSucursal = $(this).attr('alt5');
            $('#i_cotizacion').attr('alt',idCotizacion).attr('alt2',idSucursal).val(folio);
           
            $('#ta_texto_inicio').val($(this).attr('alt3'));
            $('#ta_texto_fin').val($(this).attr('alt4'));
            $('#b_detalle_cotizacion').attr('alt',idCotizacion).prop('disabled',true);
            var textoInicio = niveles($('#ta_texto_inicio').val().replace(/\n/g, '<br />'));
            var textoFin = niveles($('#ta_texto_fin').val().replace(/\n/g, '<br />'));

            var datos = {
                'path':'formato_cotizacion',
                'idRegistro':$('#i_cotizacion').attr('alt'),
                'tipo':2,
                'vp':'vp_cotizacion',
                'idRazonSocial':$('#i_id_razon_social_c').val()
            };
            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);
            
            $.post('php/convierte_pdf.php',{
                'D':datosJ
                },function(data){
                    setTimeout (desbloquea(), 10000); 
                });

           
            $('#dialog_cotizaciones').modal('hide');

        });
        /******* Fin de click sobre renglon cotizacion  *********/

        function desbloquea(){
            $('#b_detalle_cotizacion').prop('disabled',false);
        }



        //***********BUSCAR DEPARTAMENTOS ******* */ 
        $('#b_buscar_departamentos,#b_buscar_departamentos_add').on('click',function(){
            //DO = es departamento original DV = nuevo departamento a vincular
            buscarDepartamento=$(this).attr('alt');
            $('#i_filtro_departamentos').val('');
            $('.renglon_departamentos').remove();

            $.ajax({

                type: 'POST',
                url: 'php/departamentos_buscar_sin_contrato.php',
                dataType:"json", 
                data:{
                    'fecha': $('#i_fecha_c').val(),
                    'idSucursal': $('#i_cotizacion').attr('alt2')
                },
                success: function(data) {
                console.log("Resultado:"+data);
                if(data.length != 0){

                        $('.renglon_departamentos').remove();
                
                        for(var i=0;data.length>i;i++){

                            ///llena la tabla con renglones de registros
                            var inactivo='';
                            
                            if(parseInt(data[i].inactivo) == 1){

                                inactivo='Inactivo';
                            }else{
                                inactivo='Activo';
                            }

                            var html='<tr class="renglon_departamentos" alt="'+data[i].id+'" alt2="'+data[i].clave+'" alt3="' + data[i].descripcion+ '"  alt4="' + data[i].id_supervisor+ '" >\
                                        <td data-label="Clave">' + data[i].clave+ '</td>\
                                        <td data-label="Descripcion">' + data[i].descripcion+ '</td>\
                                        <td data-label="Unidad">' + data[i].unidad+ '</td>\
                                        <td data-label="Sucursal">' + data[i].sucursal+ '</td>\
                                        <td data-label="Area">' + data[i].area+ '</td>\
                                        <td data-label="Estatus">' + inactivo+ '</td>\
                                    </tr>';
                            ///agrega la tabla creada al div 
                            $('#t_departamentos tbody').append(html);   
                            $('#dialog_buscar_departamentos').modal('show');   
                        }
                }else{

                        mandarMensaje('No se encontró información');
                }

                },
                error: function (xhr) {
                    console.log('php/departamentos_buscar_sin_contrato.php-->'+JSON.stringify(xhr));
                    mandarMensaje('* Error en el sistema');
                }
            });
        });

        $('#t_departamentos').on('click', '.renglon_departamentos', function() {
            //DO = es departamento original DV = nuevo departamento a vincular
            if(buscarDepartamento=='DO'){
                var idDepartamento = $(this).attr('alt');
                var clave = $(this).attr('alt2');
                var departamento = $(this).attr('alt3');
                var idSupervisor = $(this).attr('alt4');
                $('#i_departamento').attr('alt',idDepartamento).attr('alt2',idDepartamento).val(clave +' - '+ departamento);
                
            }else{
                var idDepartamento = $(this).attr('alt');
                var clave = $(this).attr('alt2');
                var departamento = $(this).attr('alt3');
                var idSupervisor = $(this).attr('alt4');
                $('#i_departamento_n').attr('alt',idDepartamento).attr('alt2',idDepartamento).val(clave +' - '+ departamento);
            }
            $('#dialog_buscar_departamentos').modal('hide');
    
        });

        /*Busca razón social y selecciona*/
        $('#b_buscar_rs_factura').click(function(){
           
            $('#i_filtro_razon_social_factura').val('');
            muestraModalEmpresasFiscales('renglon_razon_social_factura','t_razon_social_factura tbody','dialog_buscar_razon_social_factura');
        });

        $('#t_razon_social_factura').on('click', '.renglon_razon_social_factura', function() {

            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_razon_social_factura').attr('alt',id).val(nombre);
            $('#dialog_buscar_razon_social_factura').modal('hide');

        });

        /*Busca razón social y selecciona*/
        $('#b_buscar_rs_contrato').click(function(){
            $('#i_filtro_razon_social_contrato').val('');
            muestraModalEmpresasFiscales('renglon_razon_social_contrato','t_razon_social_contrato tbody','dialog_buscar_razon_social_contrato');
        });

        $('#t_razon_social_contrato').on('click', '.renglon_razon_social_contrato', function() {

            var id = $(this).attr('alt');
            var nombre = $(this).attr('alt2');
            $('#i_razon_social_contrato').attr('alt',id).val(nombre);
            $('#dialog_buscar_razon_social_contrato').modal('hide');

        });


        

        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        $(document).on('click','#b_guardar_contrato',function(){
            
            if ($('#form_contratos').validationEngine('validate')){

                $.ajax({
                    type: 'POST',
                    url: 'php/contratos_guardar.php', 
                
                    data: {
                            'datos':obtenerDatosContrato('DO')

                    },
                    //una vez finalizado correctamente
                    success: function(data){
                        console.log(data);
                        if (data > 0 ) {
                            
                            if (tipoMovC == 0){
                                
                                mandarMensaje('Se guardó el nuevo registro');
                                // bajaContratos(data);

                                $('#b_nuevo_contrato').trigger('click');

                            }else{
                                //bajaContratos(data); 
                                mandarMensaje('Se actualizó el registro');
                                $('#b_nuevo_contrato').trigger('click');
                                
                            }

                        }else{
                            
                            mandarMensaje('Error en el guardado');
                            $('#b_guardar').prop('disabled',false);
                        }

                    },
                        //si ha ocurrido un error
                    error: function(xhr){
                    
                        console.log('php/contratos_guardar.php -->'+JSON.stringify(xhr));
                        mandarMensaje('* Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }
                });
            }else{
                $('#b_guardar').prop('disabled',false);
            }

        });

        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        $(document).on('click','#b_vincular_departamento',function(){
            
            if ($('#form_contratos').validationEngine('validate')){

                $.ajax({
                    type: 'POST',
                    url: 'php/contratos_guardar.php', 
                
                    data: {
                            'datos':obtenerDatosContrato('DV')

                    },
                    //una vez finalizado correctamente
                    success: function(data){
                        console.log(data);
                        if (data > 0 ) {
                            
                            if (tipoMovC == 0){
                                
                                mandarMensaje('Se guardó el nuevo registro');
                                $('#b_nuevo_contrato').trigger('click');

                            }else{
                                mandarMensaje('Se actualizó el registro');
                                $('#b_nuevo_contrato').trigger('click');
                                
                            }

                        }else{
                            
                            mandarMensaje('Error en el guardado');
                            $('#b_guardar').prop('disabled',false);
                        }

                    },
                        //si ha ocurrido un error
                    error: function(xhr){
                    
                        console.log('php/contratos_guardar.php -->'+JSON.stringify(xhr));
                        mandarMensaje('* Error en el guardado');
                        $('#b_guardar').prop('disabled',false);
                    }
                });
            }else{
                $('#b_guardar').prop('disabled',false);
            }

        });

        /* obtine los datos y los guarda en un arreglo*/
        function obtenerDatosContrato(Depto){
            var idDepratamento=0, idSupervisor=0;
            if(Depto=='DO'){
                idDepratamento = $('#i_departamento').attr('alt');
                idSupervisor = $('#i_departamento').attr('alt2');
            }else{
                idDepratamento = $('#i_departamento_n').attr('alt');
                idSupervisor = $('#i_departamento_n').attr('alt2');
                tipoMovC = 0;

            }
            var paquete = [];
                paquete[0]= 1;
            var cont = 0;
            var paq = {
                    'tipoMovC' : tipoMovC,
                    'idContrato' : idContrato,
                    'idCliente' : $('#i_id_cliente_c').val(),
                    'idRazonSocial' : $('#i_id_razon_social_c').val(),
                    'idSupervisor' : idSupervisor,
                    'idDepartamento' : idDepratamento,
                    'fecha' : $('#i_fecha_c').val(),
                    'vigencia' : $('#i_vigencia_c').val(),
                    'idRsFactura' : $('#i_razon_social_factura').attr('alt'),
                    'idRsContrato' : $('#i_razon_social_contrato').attr('alt'),
                    'idCotizacion' : $('#i_cotizacion').attr('alt'),
                    'folioCotizacion' : $('#i_cotizacion').val(),
                    'tipoContrato' : $('#s_tipo_contrato').val(),
                    'archivoActual' : $('#i_ruta_anterior').attr('alt')
                    
                }
                paquete.push(paq);
            return paquete;
        }  

        //*********************MODULO DE RAZONES SOCIALES************************************** */

        $(document).on('click','#b_editar_contrato',function(){

            tipoMovC=1;
            idContrato=$(this).attr('alt');
           
            var nCorto=$(this).attr('alt2');
            var rfcC=$(this).attr('alt3');
            var nComercial=$(document).find('#i_nombre_comercial').val();
            $('#i_id_contrato').val(idContrato);
            $('#i_nombre_comercial_c').val(nComercial);
            $('#i_nombre_corto_c').val(nCorto);
            $('#i_rfc_c').val(rfcC);
            $('#b_detalle_cotizacion').attr('alt',0).prop('disabled',true);
            $('#div_contratos').animate({left : "0%"}, 600, 'swing');
            $("#div_razon_social").animate({left : "-101%"}, 500, 'swing');
            $('#i_archivo').prop('disabled',false);
            $('#b_bajar_contratos').attr('alt',idContrato).prop('disabled',false);
            $('#a_doc_modificado').hide();
            $('#i_ruta_anterior').val('');
            $('#b_subir_contrato').attr('alt',idContrato).prop('disabled',false);
            muestraRegistroContrato(idContrato);
            
        });

        function muestraRegistroContrato(idContrato){ 
          
            $.ajax({
                type: 'POST',
                url: 'php/contratos_buscar_id.php',
                dataType:"json", 
                data:{
                    'idContrato':idContrato
                },
                success: function(data) 
                { 
                    //console.log(data);
                    $('#b_detalle_cotizacion').attr('alt',data[0].id_cotizacion).prop('disabled',true);
                    $('#i_id_cliente_c').val(data[0].id_cliente);
                    $('#i_id_razon_social_c').val(data[0].id_razon_social);
                    $('#i_departamento').attr('alt',data[0].id_depto).attr('alt2',data[0].id_supervisor).val(data[0].departamento);
                    $('#i_fecha_c').val(data[0].fecha);
                    $('#i_vigencia_c').val(data[0].vigencia);
                    $('#i_razon_social_factura').attr('alt',data[0].id_razon_social_factura).val(data[0].rs_factura);
                    $('#i_razon_social_contrato').attr('alt',data[0].id_razon_social_contratacion).val(data[0].rs_contrato);
                    $('#i_cotizacion').attr('alt',data[0].id_cotizacion).attr('alt2',data[0].id_sucursal).val(data[0].folio_cotizacion);

                    $('#ta_texto_inicio').val(data[0].texto_inicio);
                    $('#ta_texto_fin').val(data[0].texto_fin);
                   
                    if(data[0].doc_contrato!=''){
                       var ruta='contratos_editados/'+data[0].doc_contrato;
                       $('#i_ruta_anterior').attr('alt',data[0].doc_contrato).val(ruta);
                       $('#a_doc_modificado').html('Contrato Modificado: <a href="'+ruta+'" class="alert-link" target="_blank">'+data[0].doc_contrato+'</a>');
                       $('#a_doc_modificado').show();

                    }else{
                        $('#i_ruta_anterior').attr('alt','').val('');
                        $('#a_doc_modificado').html('');
                        $('#a_doc_modificado').hide();

                    }
                   
                    $('#s_tipo_contrato').val(data[0].tipo_contrato);
                    $('#s_tipo_contrato').select2({placeholder: $(this).data('elemento')});

                    var textoInicio = niveles($('#ta_texto_inicio').val().replace(/\n/g, '<br />'));
                    var textoFin = niveles($('#ta_texto_fin').val().replace(/\n/g, '<br />'));

                    var datos = {
                        'path':'formato_cotizacion',
                        'idRegistro':$('#i_cotizacion').attr('alt'),
                        'tipo':2,
                        'vp':'vp_cotizacion',
                        'idRazonSocial':$('#i_id_razon_social_c').val()
                    };
                    let objJsonStr = JSON.stringify(datos);
                    let datosJ = datosUrl(objJsonStr); 
                    
                     $.post('php/convierte_pdf.php',{
                        'D':datosJ
                        },function(data){
                            setTimeout (desbloquea(), 10000);  
                            
                        });
                            
                        
                },
                error: function (xhr) {
                console.log('contratos_buscar_id-->'+JSON.stringify(xhr));
                    mandarMensaje('Error el contrato con id'+idContrato);
                }
            });
        }


        $(document).on('click','#b_nuevo_contrato',function(){
            tipoMovC=0;
            tipoMovC=0;
            idContrato=0;
            $('#b_ver_contrato').prop('disabled',true);
            $('#div_contratos').animate({left : "0%"}, 600, 'swing');
            $("#div_razon_social").animate({left : "-101%"}, 500, 'swing');

            var nComercial=$(document).find('#i_nombre_comercial').val();
            var nCorto=$(document).find('#i_nombre_corto').val();
            var rfcC=$(document).find('#i_rfc').val();

            $('#i_fecha_c').val(hoy);
            $('#i_id_contrato').val('');
            $('#i_departamento').attr('alt',0).attr('alt2',0).val('');
            $('#i_departamento_n').attr('alt',0).attr('alt2',0).val('');
            $('#i_razon_social_factura').attr('alt',0).val('');
            $('#i_razon_social_contrato').attr('alt',0).val('');
            $('#i_cotizacion').attr('alt',0).val('');
            $('#s_tipo_contrato').val('');
            $('#a_link_contrato').text('').attr('href','');
            $('#i_ruta_anterior').val('');
            $('#a_doc_modificado').hide();
            $('#b_subir_contrato').prop('disabled',true).attr('alt',0);
            $('#b_bajar_contratos').prop('disabled',true).attr('alt',0);
            fechaVigencia();
                    
        });

        $(document).on('click','#b_detalle_cotizacion',function(){
            
            var idRazonSocial=$('#i_id_razon_social_c').val();
            $("#div_archivo").empty(); 
            
            var ruta='cotizaciones/cotizacion_vp_'+idRazonSocial+'.pdf';
           
            var fil="<embed width='100%' height='500px' src='"+ruta+"'>";
            $("#div_archivo").append(fil);  

            $('#dialog_detalle_cotizacion').modal('show');
        });

        function bajaContratos(idContrato){
          
            var tipoContrato='';
            switch(parseInt($('#s_tipo_contrato').val())){
                case 1: tipoContrato='formato_contrato_k9';
                break;
                case 2: tipoContrato='formato_contrato_patrimonial';
                break;
                case 3: tipoContrato='formato_contrato_patrimonial_k9';
                break;
            }
           
            var datos = {
                'path':tipoContrato,
                'idRegistro':idContrato,
                'nombreArchivo':tipoContrato,
                'tipo':1
            };

            let objJsonStr = JSON.stringify(datos);
            let datosJ = datosUrl(objJsonStr);

            window.open("php/convierte_pdf.php?D="+datosJ,'_new');
            window.open("php/contratos_descargar_docx.php?idContrato=" + idContrato+"&tipoContrato="+tipoContrato);
        }

        function bajaContratoEditar(idContrato){
            window.open("php/contratos_descargar_docx.php?idContrato=" + idContrato);
        }

        $('#b_bajar_contratos').on('click',function(){
            var idContrato = $(this).attr('alt');
            if($('#s_tipo_contrato').val()>0){
                bajaContratos(idContrato);
            }else{
                mandarMensaje('Debes seleccionar un tipo de contrato primero');
            }
           
        });


        $('#b_subir_contrato').on('click',function(){
            $('#b_subir_contrato').prop('disabled',true);
            if($('#i_archivo').val()!=''){
                var idContrato = $(this).attr('alt');
                guardarContrato(idContrato);
            }else{

                mandarMensaje('Debes selecionar primero el documento a subir');
                $('#b_subir_contrato').prop('disabled',false);
            }
        });

        /* funcion que manda a generar la insecion o actualizacion de un registro */    
        function guardarContrato(idContrato){
            
            var tipoContrato='';
            switch(parseInt($('#s_tipo_contrato').val())){
                case 1: tipoContrato='formato_contrato_k9';
                break;
                case 2: tipoContrato='formato_contrato_patrimonial';
                break;
                case 3: tipoContrato='formato_contrato_patrimonial_k9';
                break;
            }
          
          //Damos el valor del input tipo_mov file
          var archivos = document.getElementById("i_archivo");

          //Obtenemos el valor del input (los archivos) en modo de arreglo
          var i_archivo = archivos.files; 

          var datos = new FormData();
          datos.append('idContrato',idContrato);
          datos.append('tipoContrato',tipoContrato);
          datos.append('archivo_1',i_archivo[0]);
          datos.append('elementos',$("#i_archivo").val()!='' ? 1 : 0);

          var fichero = $('#i_archivo').val();   
          var ext = fichero.split('.');
          ext = ext[ext.length -1];
          
          if(esDoc(ext)){  //valida la extension de la imagen
              $.ajax({
                  type: 'POST',
                  url: 'php/contratos_subir_contrato.php',  
                  //dataType: 'json',
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: datos,
                  //mientras enviamos el archivo
                  //mensaje de que la imagen se esta subiendo
                  beforeSend: function(){
                   if($("#i_archivo").val()!=''){ 
                      message ="Subiendo el documento, por favor espere...";
                      mandarMensaje(message);     
                   }else{
                      mandarMensaje("Generando registro, por favor espere...");
                   }   
                  },
                  //una vez finalizado correctamente
                  success: function(data){
                      console.log(data);
                      if (data != '')
                      {
                        mandarMensaje('El documento se guardó correctamente');
                      
                        var nombre=data;
                        var ruta='contratos_editados/'+nombre;
                        $('#i_ruta_anterior').attr('alt',nombre).val(ruta);
                        $('#a_doc_modificado').html('Contrato Modificado: <a href="'+ruta+'" target="_blank">'+nombre+'</a>');
                        $('#a_doc_modificado').show();
                        $('#b_subir_contrato').prop('disabled',false);

                      }else{
                          
                          mandarMensaje('Ocurrio un eeror al guardar el documento');
                          $('#b_subir_contrato').prop('disabled',false);
                          $('#i_ruta_anterior').attr('alt','').val('');
                          $('#a_doc_modificado').hide();
                      }

                  },
                  //si ha ocurrido un error
                  error: function(xhr){
                      console.log('php/contratos_subir_contrato.php-->'+JSON.stringify(xhr));
                      mandarMensaje("* Ocurrio un eeror al guardar el documento");
                      $('#b_subir_contrato').prop('disabled',false);
                  }
              });
          }else{
              mandarMensaje('Verifica la extensión del documento');
              $('#b_subir_contrato').prop('disabled',false);
          }   
      }
      
      /* Funcion que verifica si es una imagen */
      function esDoc(extension){
          if(extension!=''){
                      
              switch(extension.toLowerCase()) 
              {
                  case 'pdf': case 'PDF': 
                  return true;
                  break;
                  default:
                  return false;
                  break;
              }
          }else{
              return true;    
          }
      }

    
       
    });

</script>

</html>