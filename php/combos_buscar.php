<?php
    session_start();
	include('../widgets/Combos.php');

    $tipoSelect=$_REQUEST['tipoSelect'];



    if($tipoSelect=='PERMISOS_SUCURSALES'){

        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $modulo = $_REQUEST['modulo'];
        $idUsuario = $_REQUEST['idUsuario'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarPermisosSucursal($idUnidadNegocio,$modulo,$idUsuario);
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect == 'ACCESOS_SUCURSALES')
    {

        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $idUsuario = $_REQUEST['idUsuario'];

        $modeloCombos = new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarSucursalesAcceso($idUnidadNegocio,$idUsuario);
        else
            echo json_encode("sesion");

    }

    if($tipoSelect=='UNIDADES_TODAS')
    {

        $modeloCombos = new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarTodaUnidadesNegocioTodas();
        else
            echo json_encode("sesion");

    }

    if($tipoSelect=='PAISES'){
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarPaises();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='ESTADOS'){
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarEstados();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='MUNICIPIOS'){

        $idEstado = $_REQUEST['idEstado'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarMunicipios($idEstado);
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='REGIMEN'){
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarRegimenes();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='DEPARTAMENTOS'){

        $idSucursal = $_REQUEST['idSucursal'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarDepartamentos($idSucursal);
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='PUESTOS'){

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarPuestos();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='FIRMANTES'){

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarFirmantes();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='UNIDADES_NEGOCIO_ACCESO'){

        $idUsuario = $_REQUEST['idUsuario'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarUnidadesNegocioAcceso($idUsuario);
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='PERMISOS_SUCURSALES_USUARIO'){

        $modulo = $_REQUEST['modulo'];
        $idUsuario = $_REQUEST['idUsuario'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarPermisosSucursalUsuario($modulo,$idUsuario);
        }else{
            echo json_encode("sesion");
        }
    }


    if($tipoSelect=='SALARIOS')
    {
        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $idSucursal = $_REQUEST['idSucursal'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarSalariosPuestos($idUnidadNegocio,$idSucursal);
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='ACCESOS_AREAS')
    {

        $modeloCombos= new Combos();

        $idSucursal = $_REQUEST['id_sucursal'];

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarAreas($idSucursal);
        else
            echo json_encode("sesion");

    }

    if($tipoSelect=='PROVEEDORES_UNIDAD')
    {

        $idUnidad = $_REQUEST['idUnidad'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarProvedoresUnidad($idUnidad);
        else
            echo json_encode("sesion");

    }

    if($tipoSelect=='DEPARTAMENTOS_AREA')
    {

        $idSucursal = $_REQUEST['idSucursal'];
        $idArea = $_REQUEST['idArea'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarDepartamentoArea($idSucursal, $idArea);
        else
            echo json_encode("sesion");

    }

    if($tipoSelect == 'CLASIFICACION_SALIDAS_AJUSTES')
    {
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
        {
            echo $resultado = $modeloCombos->buscarClasificacionPresupuesto();
        }else{
            echo json_encode("sesion");
        }
    }


    if($tipoSelect=='TODAS_UNIDADES_NEGOCIO'){

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarTodaUnidadesNegocio();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='FAMILIA_GASTOS'){

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarFamiliaGastos();
        }else{
            echo json_encode("sesion");
        }
    }
    //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso CON PERMISO
    if($tipoSelect=='CUENTAS_BANCOS')
    {
        $idCuentaBanco = $_REQUEST['idCuentaOrigen'];
        $tipo = $_REQUEST['tipo'];
        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $idsUnidadesPermiso = $_SESSION['unidades'];
        $modeloCombos= new Combos();
       
        if (isset($_SESSION['usuario'])){
            //---MGFS se agrega validacion para solo mostrar las cuentas de una unidad negocio si tiene permiso
           // $tienePermiso = strpos($idsUnidadesPermiso, $idUnidadNegocio);
            //if($tienePermiso===false){//--si no tiene permiso
                //echo 0;
           // }else{
                $idsUnidadesPermiso = ','.$idsUnidadesPermiso;//-- se agrega la coma para qeu lo identifique en la busqueda
                echo $resultado = $modeloCombos->buscaCuentasBancos($idCuentaBanco,$tipo,$idsUnidadesPermiso);
            //}
            
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='TIPOS_INGRESOS')
    {

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscaTiposIngresos($idCuentaBanco);
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='CONCEPTOS_CXP')
    {
        $tipo=$_REQUEST['tipo'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscaConceptosCxP($tipo);
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='CONCEPTOS_CXP_PAGOS')
    {
        $tipo=$_REQUEST['tipo'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscaConceptosCxPPagos($tipo);
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='CONCEPTOS_CXP_ABONOS')
    {
        $tipo=$_REQUEST['tipo'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscaConceptosCxPAbonos();
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='CLASIFICACION_GASTOS')
    {
        $idFamiliaGastos=$_REQUEST['idFamiliaGastos'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscaClasificacionGastos($idFamiliaGastos);
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='DEPARTAMENTOS_AREA_INTERNOS')
    {

        $idSucursal = $_REQUEST['idSucursal'];
        $idArea = $_REQUEST['idArea'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarDepartamentoAreaInternos($idSucursal, $idArea);
        else
            echo json_encode("sesion");

    }

    if($tipoSelect=='PERMISOS_SUCURSALES_LISTA_ID'){

        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $modulo = $_REQUEST['modulo'];
        $idUsuario = $_REQUEST['idUsuario'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarPermisosSucursalListaId($idUnidadNegocio,$modulo,$idUsuario);
        }else{
            echo json_encode("sesion");
        }
    }


     if($tipoSelect=='CLASIFICACION_VIATICOS')
    {
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarClasificacionViaticos();
        else
            echo json_encode("sesion");

    }

    if($tipoSelect=='RAZON_SOCIAL')
    {
        $idCliente = $_REQUEST['idCliente'];
        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarRazonesSocialesCliente($idCliente,$idUnidadNegocio);
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='USO_CFDI')
    {
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarUsoCFDI();
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='METODO_PAGO')
    {
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarMetodoPago();
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='FORMA_PAGO')
    {
        $tipo = $_REQUEST['tipo'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarFormaPago($tipo);
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='PRODUCTOS_SAT')
    {
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarClaveProductoSAT();
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='UNIDADES_SAT')
    {
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarClaveUnidadesSAT();
        else
            echo json_encode("sesion");
    }
    // Modulo Activos
    // Select marcas celulares
    if($tipoSelect=='SELECT_MARCAS_CELULARES')
    {
        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarMarcasCelulares();
        else
            echo json_encode("sesion");
    }
    // Select Compañias Celulares
    if($tipoSelect=='SELECT_COMPANIAS_CELULARES')
    {
        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarCompaniasCelulares();
        else
            echo json_encode("sesion");
    }
    // Select marcas Equipo de Computo
    if($tipoSelect=='SELECT_MARCAS_ECOMPUTO')
    {
        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarMarcasEComputo();
        else
            echo json_encode("sesion");
    }
    // Select Tipo de Eq. Computo
    if($tipoSelect=='SELECT_TIPO_ECOMPUTO')
    {
        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarTiposEComputo();
        else
            echo json_encode("sesion");
    }
    // Select marcas Vehiculo
    if($tipoSelect=='SELECT_MARCAS_VEHICULO')
    {
        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarMarcasVehiculo();
        else
            echo json_encode("sesion");
    }
    // Select Tipos de Vehiculos
    if($tipoSelect=='SELECT_TIPOS_VEHICULO')
    {
        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarTiposVehiculo();
        else
            echo json_encode("sesion");
    }
    // select planes de servicios_cat_planes
    if($tipoSelect=='PLANES')
    {
        $idSucursal=$_REQUEST['idSucursal'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarPlanes($idSucursal);
        }else{
            echo json_encode("sesion");
        }
    }

    // select Clasificacion de servicios de la tabla  servicios_clasificacion
    if($tipoSelect=='CASIFICACION_SERVICIOS'){
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarClasificacionServicios();
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='CONCEPTOS_CXC_ALARMAS')
    {
        $tipo=$_REQUEST['tipo'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscaConceptosCxCAlarmas($tipo);
        else
            echo json_encode("sesion");
    }
    
    if($tipoSelect=='SALARIOS_RAZON_SOCIAL')
    {
        $idRazonSocial = $_REQUEST['idRazonSocial'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
        {
            echo $resultado = $modeloCombos->buscarSalariosRazonSocial($idRazonSocial);
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='PROVEEDOR_CORPORATIVO')
    {

        $idUnidad = $_REQUEST['idUnidad'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarProvedoresCorporativo($idUnidad);
        else
            echo json_encode("sesion");

    }

    if($tipoSelect=='FAMILIA_ALARMAS')
    {

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarFamiliaAlarmas();
        else
            echo json_encode("sesion");

    }

    if($tipoSelect=='CUENTA_CAJA_CHICA')
    {
        $idSucursal = $_REQUEST['idSucursal'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscaCuentaCajaChica($idSucursal);
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='EMPRESAS_FISCALES')
    {

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscaEmpresasFiscales();
        else
            echo json_encode("sesion");
    }
    //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso CON PERMISO
    if($tipoSelect=='CUENTAS_BANCOS_SALDOS')
    {
        $idCuentaBanco = $_REQUEST['idCuentaOrigen'];
        $tipo = $_REQUEST['tipo'];
        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $idsUnidadesPermiso = $_SESSION['unidades'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){
            //---MGFS se agrega validacion para solo mostrar las cuentas de una unidad negocio si tiene permiso
            //$tienePermiso = strpos($idsUnidadesPermiso, $idUnidadNegocio);
            //if($tienePermiso===false){//--si no tiene permiso
               // echo 0;
            //}else{
                $idsUnidadesPermiso = ','.$idsUnidadesPermiso;//-- se agrega la coma para qeu lo identifique en la busqueda
                echo $resultado = $modeloCombos->buscaCuentasBancosSaldos($idCuentaBanco,$tipo,$idsUnidadesPermiso);
            //}
        }else{
            echo json_encode("sesion");
        }
    }

    if($tipoSelect=='PERMISOS_SUCURSALES_CAJA_CHICA'){

        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $modulo = $_REQUEST['modulo'];
        $idUsuario = $_REQUEST['idUsuario'];

        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){

            echo $resultado = $modeloCombos->buscarPermisosSucursalCajaChica($idUnidadNegocio,$modulo,$idUsuario);
        }else{
            echo json_encode("sesion");
        }
    }
    //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso CON PERMISO
    if($tipoSelect=='CUENTAS_BANCOS_CAJA_CHICA_SUCURSAL')
    {
        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $idSucursal = $_REQUEST['idSucursal'];
        $idsUnidadesPermiso = $_SESSION['unidades'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){
            //---MGFS se agrega validacion para solo mostrar las cuentas de una unidad negocio si tiene permiso
            $tienePermiso = strpos($idsUnidadesPermiso, $idUnidadNegocio);
            if($tienePermiso===false){//--si no tiene permiso
                echo 0;
            }else{
                echo $resultado = $modeloCombos->buscaCuentasBancosCajaChicaSucursal($idUnidadNegocio,$idSucursal);
            }
        }else{
            echo json_encode("sesion");
        }
    }

    //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso CON PERMISO
    if($tipoSelect=='CUENTAS_BANCOS_SALDOS_PERMISO')
    {
        $idCuentaBanco = $_REQUEST['idCuentaOrigen'];
        $tipo = $_REQUEST['tipo'];
        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $idsUnidadesPermiso = $_SESSION['unidades']; 
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){
            //---MGFS se agrega validacion para solo mostrar las cuentas de una unidad negocio si tiene permiso
            if($idsUnidadesPermiso!=''){
                $idsUnidadesPermiso = ','.$idsUnidadesPermiso;//-- se agrega la coma para qeu lo identifique en la busqueda
                echo $resultado = $modeloCombos->buscaCuentasBancosSaldosPermiso($idCuentaBanco,$tipo,$idsUnidadesPermiso);
            }else{
                echo 0;
            }
        }else{
            echo json_encode("sesion");
        }
    }
    //--MGFS 19-02-2020 SE AGREGA PARA SEGUIMIENTO ORDENES DE ALARMAS
    //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso CON PERMISO
    if($tipoSelect=='CUENTAS_BANCOS_UNIDAD')
    {
        $idCuentaBanco = $_REQUEST['idCuentaOrigen'];
        $tipo = $_REQUEST['tipo'];
        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $idsUnidadesPermiso = $_SESSION['unidades'];
        $modeloCombos= new Combos();
       
        if (isset($_SESSION['usuario'])){
            //---MGFS se agrega validacion para solo mostrar las cuentas de una unidad negocio si tiene permiso
            $tienePermiso = strpos($idsUnidadesPermiso, $idUnidadNegocio);
            if($tienePermiso===false){//--si no tiene permiso
                echo 0;
            }else{
                echo $resultado = $modeloCombos->buscaCuentasBancosUnidad($idCuentaBanco,$tipo,$idUnidadNegocio);
            }
            
        }else{
            echo json_encode("sesion");
        }
    }
    //--MGFS 19-02-2020 SE AGREGA PARA CXC ALARMAS
    //--MGFS 13-02-2020 Se modifica la busqueda de cuentas por unidad  y que tenga permiso CON PERMISO
    if($tipoSelect=='CUENTAS_BANCOS_SALDOS_UNIDAD')
    {
        $idCuentaBanco = $_REQUEST['idCuentaOrigen'];
        $tipo = $_REQUEST['tipo'];
        $idUnidadNegocio = $_REQUEST['idUnidadNegocio'];
        $idsUnidadesPermiso = $_SESSION['unidades'];
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario'])){
            //---MGFS se agrega validacion para solo mostrar las cuentas de una unidad negocio si tiene permiso
            $tienePermiso = strpos($idsUnidadesPermiso, $idUnidadNegocio);
            if($tienePermiso===false){//--si no tiene permiso
               echo 0;
            }else{
                
                echo $resultado = $modeloCombos->buscaCuentasBancosSaldosUnidad($idCuentaBanco,$tipo,$idUnidadNegocio);
            }
        }else{
            echo json_encode("sesion");
        }
    }

    //-->NJES April/29/2020 se agregan opciones para buscar los combos de marcas y clases armas en activos fijos
    if($tipoSelect=='SELECT_CLASE_ARMAS')
    {
        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarClasesArmas();
        else
            echo json_encode("sesion");
    }
    
    if($tipoSelect=='SELECT_MARCA_ARMAS')
    {
        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarMarcasArmas();
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='UNIDADES_NEGOCIO_SUCURSAL_PERMISO')
    {
        $modulo = $_REQUEST['modulo'];
        $idUsuario = $_REQUEST['idUsuario'];
        $listaIdUnidades = $_REQUEST['listaIdUnidades'];

        $modeloCombos= new Combos();
        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarPermisosUnidadesUsuario($modulo,$idUsuario,$listaIdUnidades);
        else
            echo json_encode("sesion");
    }

    if($tipoSelect=='TIPOS_DE_PANEL')
    {
        $modeloCombos= new Combos();

        if (isset($_SESSION['usuario']))
            echo $resultado = $modeloCombos->buscarTiposPanel();
        else
            echo json_encode("sesion");
    }


?>
