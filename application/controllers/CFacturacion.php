<?php
/**************************************************************************
* Nombre de la Clase: CFacturacion
* Version: 1.0.0
* Descripcion: Es el controlador para el Modulo de Facturacion
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 22/10/2018
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CFacturacion extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
        $this->load->model('MFacturacion'); /*Modelo para el Facturacion*/
        $this->load->model('MEstudiante'); /*Modelo para el registro Estudiante*/
        
        date_default_timezone_set('America/Bogota'); /*Zona horaria*/

        //lineas para eliminar el historico de navegacion./
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: index
     * Descripcion: Direcciona al usuario segun la sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function index() {
        
        if ($this->session->userdata('validated')) {

            $this->module($info);
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: module
     * Descripcion: Redirecciona respuesta al usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(1)){
                
                /*Consulta Modelo para obtener listado de Estudiantes registrados*/
                $listEstudiantes = $this->MEstudiante->list_estudiantes(1); /*solo activos*/
                /*Consulta Modelo para obtener listado de tarifas adicionales registradas*/
                $listTarAdc = $this->MFacturacion->list_tarifa_adc();
                
                $info['list_estudiante'] = $listEstudiantes;
                $info['list_tar_adicionales'] = $listTarAdc;
                $this->load->view('facturacion/panelfacturacion',$info); 
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: parametrizatarifa
     * Descripcion: Redirecciona a la opcion de parametrizar tarifas
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function parametrizatarifa() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(9)){
                
                /*Consulta Modelo para recupoerar lista de tarifas creadas*/
                $listTipoTarifa = $this->MFacturacion->list_tipo_tarifa();
                /*Consulta Modelo para obtener listado Cursos*/
                $listCursos = $this->MEstudiante->list_cursos();
                /*Consulta Modelo para obtener listado Jornadas*/
                $listJornadas = $this->MEstudiante->list_jornadas();
                /*Consulta Modelo para obtener listado tarifas fijas*/
                $listTarFijas = $this->MFacturacion->list_tarifa_fija();
                /*Consulta Modelo para obtener parametrizacion de tarifas fijas*/
                $listParamTarifas = $this->MFacturacion->list_param_tarifa();
                
                $info['list_tipo_tarifa'] = $listTipoTarifa;
                $info['list_cursos'] = $listCursos;
                $info['list_jornadas'] = $listJornadas;
                $info['list_tarfijas'] = $listTarFijas;
                $info['list_param_tar'] = $listParamTarifas;
                $this->load->view('facturacion/paramtarifa',$info); 
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addtipotarifa
     * Descripcion: Permite registrar un nuevo tipo tarifa en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function addtipotarifa() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(9)){
                
                /*Captura Variables*/
                $tarifaFija = strtoupper($this->input->post('tipo_tarifa'));
                $descTarifa = strtoupper($this->input->post('nombre_tarifa'));
                $valorTipoTarifa = $this->input->post('valor_tarifa');
                $incremCalendarioA = $this->input->post('increm_calendarioA');
                
                /*Consulta Modelo para registrar tipo Tarifa*/
                $insTarifa = $this->MFacturacion->registra_tipo_tarifa($tarifaFija,$descTarifa,$valorTipoTarifa,$incremCalendarioA);
                if ($insTarifa == FALSE){
                    
                    $this->session->set_tempdata('messageError', 'No fue posible registrar la tarifa en el sistema. Comuniquese con el administrador.', 7);
                    $this->parametrizatarifa();
                    
                } else {
                    
                    $this->session->set_tempdata('message', 'Se registro correctamente el tipo de tarifa en el sistema.', 7);
                    $this->parametrizatarifa();
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addtarifafija
     * Descripcion: Permite registrar la parametrizacion de una tarifa fija
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function addtarifafija() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(9)){
                
                /*Captura Variables*/
                $idCurso = $this->input->post('curso');
                $idJornada = $this->input->post('jornada');
                $idTarifaFija = $this->input->post('tarifa_fija');
                $valorTarifaFija = $this->input->post('valor_tarfija');
                
                if ($valorTarifaFija > 0){
                
                    /*Consulta Modelo para registrar configuracion de Tarifa Fija*/
                    $insTarifaFija = $this->MFacturacion->registra_tarifa_fija($idCurso,$idJornada,$idTarifaFija,$valorTarifaFija);
                    if ($insTarifaFija == FALSE){

                        $this->session->set_tempdata('messageError', 'No fue posible registrar la tarifa en el sistema. Comuniquese con el administrador.', 7);
                        $this->parametrizatarifa();

                    } else {

                        $this->session->set_tempdata('message', 'Se registro correctamente la parametrizacion de tarifa en el sistema.', 7);
                        $this->parametrizatarifa();

                    }
                
                } else {
                    
                    $this->session->set_tempdata('messageError', 'No fue posible registrar la parametrizacion. El valor de la tarifa no puede ser 0.', 7);
                    $this->parametrizatarifa();
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: resolrecibos
     * Descripcion: Redirecciona a la opcion de resolucion de recibos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function resolrecibos() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(10)){
                
                /*Consulta Modelo para obtener lista de resoluciones creadas*/
                $listResolucion = $this->MFacturacion->list_resoluciones();
                
                $info['list_resol'] = $listResolucion;
                $this->load->view('facturacion/resolucion',$info); 
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addresolucion
     * Descripcion: Permite registrar un rango de recibos en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function addresolucion() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(10)){
                
                /*Captura Variables*/
                $resolucion = $this->input->post('resolucion');
                $reciboIni = $this->input->post('rango_inicial');
                $reciboFin = $this->input->post('rango_final');
                
                if ($reciboIni < $reciboFin){
                
                    /*Consulta Modelo para registrar resolucion de recibos*/
                    $insResolucion = $this->MFacturacion->registra_resolucion($resolucion,$reciboIni,$reciboFin);
                    if ($insResolucion == FALSE){

                        $this->session->set_tempdata('messageError', 'No fue posible registrar la resolucion. Comuniquese con el administrador.', 7);
                        $this->resolrecibos();

                    } else {

                        $this->session->set_tempdata('message', 'Se registro correctamente la resolucion de recibos en el sistema.', 7);
                        $this->resolrecibos();

                    }
            
                } else {
                    
                    $this->session->set_tempdata('messageError', 'No se puede crear la resolucion. El rango inicial debe ser menor que el rango final', 7);
                    $this->resolrecibos();
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: addresolucion
     * Descripcion: Permite registrar un rango de recibos en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function regcuentacobrar() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(11)){
                
                /*Captura Variables*/
                $estudiante = $this->input->post('dataestudiante');
                $strdata = explode("|", $estudiante);
                $idEstudiante = str_replace(" ","",$strdata[0]);
                
                if ($this->jasr->validaTipoString($idEstudiante,5)){
                
                    $checkEstudiante = $this->MEstudiante->get_estudiante($idEstudiante);

                    if (($checkEstudiante != FALSE) && ($checkEstudiante->activo == 'S')){

                        /*Consulta Modelo para obtener listado de Tarifas Adicionales*/
                        $listTarAdc = $this->MFacturacion->list_tarifa_adc();

                        $flag = 0;
                        foreach ($listTarAdc as $tarifaCobra){

                            $marcaTarifa = $this->input->post($tarifaCobra['idTarifa']);
                            $cantidadTarifa = $this->input->post("cantidad_".$tarifaCobra['idTarifa']);

                            if ($marcaTarifa == 'on'){

                                if ($flag == 0){
                                    $insFactura = $this->MFacturacion->registra_factura($idEstudiante,$checkEstudiante->idCurso,$checkEstudiante->idJornada,1);
                                    $flag = 1;
                                }
                                /*Consulta Modelo para registrar detalle de factura*/
                                $this->MFacturacion->registra_factura_detalle($insFactura,$tarifaCobra['idTarifa'],$tarifaCobra['descTarifa'],$tarifaCobra['valorTipoTarifa'],$cantidadTarifa);

                            } 

                        }

                        if ($flag == 0){

                            $info['message'] = 'No se registro la cuenta por cobrar. Debe seleccionar al menos una tarifa.';
                            $info['alert'] = 2;
                            $this->module($info);

                        } else {

                            $info['message'] = 'Se registro correctamente la cuenta por cobrar.';
                            $info['alert'] = 1;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible registrar la cuenta por cobrar. El estudiante no existe o se encuentra inactivo.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }
                
                } else {
                    
                    $info['message'] = 'El Codigo del Estudiante es incorrecto';
                    $info['alert'] = 2;
                    $this->module($info);
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: edittarifa
     * Descripcion: Permite editar una tarifa
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function edittarifa($idTarifa) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(9)){
                
                /*Consulta Modelo para obtener los datos de la tarifa*/
                $dataTarifa = $this->MFacturacion->get_tarifa($idTarifa);
                
                $info['data_tarifa'] = $dataTarifa;
                $this->load->view('facturacion/edittarifa',$info); 
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: updtarifa
     * Descripcion: Permite registrar la actualizacion de una tarifa
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function updtarifa() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(9)){
                
                /*Captura Variables*/
                $idTarifa = $this->input->post('id_tarifa');
                $nombreTarifa = strtoupper($this->input->post('nombre_tarifa'));
                $valorTarifa = $this->input->post('val_tarifa');
                $estadoTarifa = $this->input->post('estado_tarifa');
                $incrCalendarioA = $this->input->post('incrementoCalendarioA');
                
                if ($valorTarifa > 0 || $valorTarifa == '-1'){
                                    
                    /*Consulta Modelo para actualizar informacion de Tipo Tarifa*/
                    $updTarifa = $this->MFacturacion->actualiza_tarifa($idTarifa,$nombreTarifa,$valorTarifa,$estadoTarifa,$incrCalendarioA);
                    if ($updTarifa == FALSE){

                        $this->session->set_tempdata('messageError', 'No fue posible actualizar la tarifa en el sistema. Comuniquese con el administrador.', 7);
                        $this->parametrizatarifa();

                    } else {

                        $this->session->set_tempdata('message', 'Se actualizo correctamente los datos de la tarifa en el sistema.', 7);
                        $this->parametrizatarifa();

                    }
                
                } else {
                    
                    $this->session->set_tempdata('messageError', 'No fue posible actualizar la tarifa. El valor de la tarifa no puede ser 0.', 7);
                    $this->parametrizatarifa();
                    
                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: liquidafactura
     * Descripcion: Redirecciona a la opcion de liquidar factura
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function liquidafactura() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(12)){
                
                /*Consulta Modelo para obtener listado de Estudiantes registrados*/
                $listEstudiantes = $this->MEstudiante->list_estudiantes(1); /*solo activos*/
                /*Consulta Modelo para obtener listado tarifas fijas*/
                $listTarFijas = $this->MFacturacion->list_tarifa_fija();
                
                $info['list_estudiante'] = $listEstudiantes;
                $info['list_tarfijas'] = $listTarFijas;
                $this->load->view('facturacion/liquidafactura',$info); 
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: estadocuenta
     * Descripcion: Permite visualizar el estado de cuenta de un estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function estadocuenta($idEstudiante,$data) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(12) || $this->MRecurso->validaRecurso(16)){
                
                /*Consulta Modelo para obtener listado de Recibos Liqiuidados para el estudiante*/
                $listRecibosLiq = $this->MFacturacion->recibos_liquidados_est($idEstudiante); 
                
                if ($listRecibosLiq != FALSE){
                    
                    $info['data'] = $data;
                    $info['list_recibos'] = $listRecibosLiq;
                    $info['id_estudiante'] = $idEstudiante;
                    $this->load->view('facturacion/cuentaestudiante',$info); 
                    
                } else {
                    
                    $this->session->set_tempdata('messageError', 'El estudiante no tiene ninguna liquidación vigente', 7);
                    $this->liquidafactura();
                    
                }
                            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: detallerecibo
     * Descripcion: Permite visualizar el estado de cuenta de un estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function detallerecibo() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(12)){
                
                /*Captura variables*/
                $recibo = $this->input->post('recibo');
                $id_estudiante = $this->input->post('id_estudiante');
                
                /*Consulta Modelo para obtener informacion maestro del recibo*/
                $dataReciboMaestro = $this->MFacturacion->informacion_recibo_maestro($id_estudiante,$recibo); 
                $infoFactura['maestro'] = $dataReciboMaestro;
                
                /*Consulta Modelo para obtener informacion detalle del recibo*/
                $dataReciboDetalle = $this->MFacturacion->informacion_recibo_detalle($id_estudiante,$recibo); 
                $infoFactura['detalle'] = $dataReciboDetalle;
                
                /*Consulta Modelo para obtener informacion de plazos del recibo*/
                $dataReciboPlazos = $this->MFacturacion->informacion_recibo_plazos($recibo); 
                $infoFactura['plazos'] = $dataReciboPlazos;
                
                /*Consulta Modelo para obtener informacion de la resolucion*/
                $dataResolucion = $this->MFacturacion->informacion_resolucion(); 
                $infoFactura['resolucion'] = $dataResolucion;
                
                /*Consulta Modelo para obtener informacion del calendario del estudiante*/
                $dataCalendario = $this->MFacturacion->calendario_estudiante($id_estudiante); 
                $infoFactura['calendarioEst'] = $dataCalendario;
                
                $info['dataGeneral'] = $infoFactura;
                $this->session->set_tempdata('vistarecibo', 1, 7);
                $this->estadocuenta($id_estudiante,$info);
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: regliquidafactura
     * Descripcion: Permite registrar la liquidacion de una cuenta del estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 25/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function regliquidafactura() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(12)){
                
                /*Captura Variables*/
                $idEstudianteLiq = $this->input->post('idest_liq');
                $idCursoLiq = $this->input->post('idcur_liq');
                $idJornadaLiq = $this->input->post('idjor_liq');
                $mesFactura = $this->input->post('mes_factura');
                $anoFactura = $this->input->post('ano_factura');
                $liqAdicionales = $this->input->post('adicionales');
                $tipoPlazo = $this->input->post('plazo_pago');
                $calendarioEstudiante = $this->input->post('idcal_liq');
                $valorIncreCal = $this->config->item('valorincrecal'); /*valor de incremento por calendario parametrizado*/
                
                /*Consulta Modelo para obtener listado tarifas fijas*/
                $listTarFijas = $this->MFacturacion->list_tarifa_fija();
                
                /*Valida si se selecciono alguna tarifa fija*/
                $flagSelectFija = 0;
                $flagConfigFija = 1;
                if ($listTarFijas != FALSE){
                    foreach ($listTarFijas as $tarfija){
                        
                        if ($this->input->post('tarfija_'.$tarfija['idTarifa']) == 'on'){
                            
                            $flagSelectFija = 1;
                            
                            /*Consulta Modelo para obtener el valor parametrizado de la tarifa fija*/
                            $dataTarifaFija = $this->MFacturacion->getvalor_tarifafija($tarfija['idTarifa'],$idCursoLiq,$idJornadaLiq);
                            if ($dataTarifaFija == FALSE){
                                $flagConfigFija = 0;
                            }
                            
                        }
                    }
                }
                
                /*Valida si se selecciono tarifa adicional y si el estudiante tiene pendientes de liquidar*/
                $flagSelectAdc = 0;
                if ($liqAdicionales == 'on'){
                    
                    $validaAdicionales = $this->MFacturacion->liquida_tarifa($idEstudianteLiq, NULL, NULL, NULL, 'N', 'S');
                    if ($validaAdicionales != FALSE){
                        
                        $flagSelectAdc = 1;
                        
                    }
                    
                }
                
                /*****************************************************************/
                /*Liquidacion Tarifas Fijas*/
                /*****************************************************************/
                if ($flagSelectFija == 1 && $flagConfigFija == 1){
                    
                    /*recorre nuevamente la lista de tarifas fijas y las registra*/
                    if ($listTarFijas != FALSE){
                        
                        $result = TRUE;
                        foreach ($listTarFijas as $tarfija){

                            $tarifaLiq = $this->input->post("tarfija_".$tarfija['idTarifa']);
                            if ($tarifaLiq == 'on'){

                                /*Consulta Modelo para obtener el valor parametrizado de la tarifa fija*/
                                $dataTarifaFija = $this->MFacturacion->getvalor_tarifafija($tarfija['idTarifa'],$idCursoLiq,$idJornadaLiq);
                                
                                if ($dataTarifaFija != FALSE){
                                    
                                    /*Consulta Modelo para registrar factura maestro*/
                                    $insFactura = $this->MFacturacion->registra_factura($idEstudianteLiq,$idCursoLiq,$idJornadaLiq,1);
                                    
                                    if ($insFactura != FALSE){
                                        
                                        /*-----------------------------------------------------------------------------------*/
                                        /*Validacion si esta activo el incremento del calendario para la tarifa fija*/
                                        if ($tarfija['incrementoCalendario'] == 'S'){
                                            
                                            /*valida si el calendario del estudiante es A*/
                                            if ($calendarioEstudiante == 'A'){
                                                /*suma el valor del incremento para la tarifa*/
                                                $valorTarifaFinal = ($dataTarifaFija->valorTarifa) + $valorIncreCal;
                                            } else {
                                                $valorTarifaFinal = $dataTarifaFija->valorTarifa;
                                            }
                                            
                                        } else {
                                            $valorTarifaFinal = $dataTarifaFija->valorTarifa;
                                        }
                                        /*-----------------------------------------------------------------------------------*/
                                        
                                        /*Consulta Modelo para registrar detalle de factura*/
                                        $this->MFacturacion->registra_factura_detalle($insFactura,$tarfija['idTarifa'],$dataTarifaFija->descTarifa,$valorTarifaFinal,1);
                                                                                    
                                    } else {
                                        
                                        /*Fallo!*/
                                        $errorDescribe[$tarfija['idTarifa']] = "No fue posible crear la factura maestro para la tarifa fija ID ".$tarfija['idTarifa'];
                                        $this->session->set_tempdata('messageArray', $errorDescribe, 7);
                                        log_message("ERROR", "204: No fue posible crear la factura maestro para la tarifa fija ID ".$tarfija['idTarifa']);
                                        
                                    }
                                    
                                } else {
                                    
                                    /*Fallo!*/
                                    $errorDescribe[$tarfija['idTarifa']] = "La tarifa fija ID ".$tarfija['idTarifa']." no se encuentra parametrizada para el curso/jornada del Estudiante.";
                                    $this->session->set_tempdata('messageArray', $errorDescribe, 7);
                                    log_message("ERROR", "205: La tarifa fija ID ".$tarfija['idTarifa']." no se encuentra parametrizada para el curso/jornada del Estudiante ID ".$idEstudianteLiq.".");
                                    
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                } else {
                    
                    if ($flagConfigFija == 0){
                        
                        /*Fallo!*/
                        $errorDescribe['206'] = "Una tarifa fija no se encuentra parametrizada para el curso/jornada del Estudiante.";
                        $this->session->set_tempdata('messageArray', $errorDescribe, 7);
                        log_message("ERROR", "206: Una tarifa fija no se encuentra parametrizada para el curso/jornada del Estudiante ID ".$idEstudianteLiq.".");
                        
                    }
                    
                } 
                          
                /*****************************************************************/
                /*Liquidacion Tarifas*/
                /*****************************************************************/
                if (($flagSelectFija == 1 && $flagConfigFija == 1) || $flagSelectAdc == 1){
                    
                    /*Obtiene Nro de Recibo*/
                    $nroRecibo = $this->MFacturacion->get_recibo();
                
                    if ($nroRecibo != FALSE){

                        /*Tarifas Fijas*/
                        if ($flagSelectFija == 1 && $flagConfigFija == 1){

                            /*Consulta Modelo para liquidar Tarifas Fijas*/
                            $liquidaFija = $this->MFacturacion->liquida_tarifa($idEstudianteLiq, $anoFactura, $mesFactura, $nroRecibo, 'S', 'N');
                            
                        }

                        /*Tarifas Adicionales*/
                        if ($flagSelectAdc == 1){

                            /*Consulta Modelo para liquidar Tarifas Adicionales*/
                            $liquidaAdc = $this->MFacturacion->liquida_tarifa($idEstudianteLiq, $anoFactura, $mesFactura, $nroRecibo, 'N', 'N');

                        }
                        
                        /*Fechas de Plazo para Pago*/
                        if ($tipoPlazo == 1){
                            
                            $plazos = $this->MFacturacion->registra_plazo_pago($nroRecibo,date('Y-m'),$tipoPlazo,NULL);
                            if ($plazos == FALSE){

                                /*Fallo!*/
                                $errorDescribe['250'] = "No fue posible registrar los plazos.";
                                $this->session->set_tempdata('messageArray', $errorDescribe, 7);
                                log_message("ERROR", "250: No fue posible registrar los plazos para el recibo ".$nroRecibo." con fecha liquida ".date('Y-m'));

                            } 
                            
                        } else {
                            
                            if ($tipoPlazo == 2){
                                
                                /*captura variable*/
                                $date1 = new DateTime($this->input->post('fecha_limite')); 
                                $fechaLimite = $date1->format('Y-m-d'); 
                                
                                $plazos = $this->MFacturacion->registra_plazo_pago($nroRecibo,date('Y-m'),$tipoPlazo,$fechaLimite);
                                if ($plazos == FALSE){

                                    /*Fallo!*/
                                    $errorDescribe['251'] = "No fue posible registrar fecha fija de pago.";
                                    $this->session->set_tempdata('messageArray', $errorDescribe, 7);
                                    log_message("ERROR", "251: No fue posible registrar fecha fija de pago para el recibo ".$nroRecibo." con fecha liquida ".date('Y-m'));

                                } 
                                
                            }
                            
                        }
                        
                        /*****************************************************************/
                        $this->session->set_tempdata('message', 'Liquidación realizada. Nro Recibo '.$nroRecibo.'', 7);
                        $this->session->set_tempdata('messageArray', $errorDescribe, 7);
                        $this->liquidafactura();

                    } else {

                        /*****************************************************************/
                        $this->session->set_tempdata('messageError', 'No se pudo obtener un nro de recibo. Comuniquese con el administrador', 7);
                        $this->session->set_tempdata('messageArray', $errorDescribe, 7);
                        $this->liquidafactura();

                    }
                    
                } else {
                    
                    /*****************************************************************/
                    $this->session->set_tempdata('messageError', 'No se puede liquidar. Seleccione al menos una tarifa.', 7);
                    $this->session->set_tempdata('messageArray', $errorDescribe, 7);
                    $this->liquidafactura();
                    
                }
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: aplicarpago
     * Descripcion: Redirecciona a la opcion de aplicar pagos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function aplicarpago() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(13)){
                
                /*Consulta Modelo para obtener lista de recibos liquidados*/
                $listRecibosLiquidados = $this->MFacturacion->list_recibos_liquidados(2); /*liquidados*/
                
                /*Consulta Modelo para obtener lista de formas de pago*/
                $listFormas = $this->MFacturacion->list_formas_pago();
                
                $info['list_liquidados'] = $listRecibosLiquidados;
                $info['list_formas'] = $listFormas;
                $this->load->view('facturacion/aplicarpago',$info); 
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: registrapago
     * Descripcion: Permite registrar el pago de un recibo en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registrapago() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(14)){
                
                /*Captura Variables*/
                $estudiante = $this->input->post('idestudianteapl');
                $recibo = $this->input->post('idreciboapl');
                $valorRecaudo = $this->input->post('valorrecaudo');
                $valorRecaudoOrg = $this->input->post('valorrecaudo_org');
                $tipoFormaPago = $this->input->post('forma_pago');
                $referenciaBanco = strtoupper($this->input->post('ref_banco'));
                
                if ($this->jasr->validaTipoString($valorRecaudo,10)){
                
                    if (($valorRecaudo >= ($valorRecaudoOrg-5000)) && ($valorRecaudo <= ($valorRecaudoOrg+10000))) {
                        
                        /*Consulta Modelo para registrar pago*/
                        $insPago = $this->MFacturacion->registra_pago($recibo,$valorRecaudo,$tipoFormaPago,$referenciaBanco);
                        if ($insPago != FALSE){

                            $this->session->set_tempdata('message', 'Se aplico el pago correctamente.', 7);
                            $this->aplicarpago();

                        } else {

                            $this->session->set_tempdata('messageError', 'No fue posible aplicar el pago. Comuniquese con el administrador.', 7);
                            $this->aplicarpago();

                        }
                        
                    } else {
                        
                        $this->session->set_tempdata('messageError', 'No se puede aplicar el pago. El valor recaudado no se encuentra en el rango permitido.', 7);
                        $this->aplicarpago();
                        
                    }
                    
                } else {
                    
                    $this->session->set_tempdata('messageError', 'No se puede aplicar el pago. El valor recaudado es incorrecto', 7);
                    $this->aplicarpago();
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: anularrecibo
     * Descripcion: Permite registrar la anulacion de un recibo en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function anularrecibo() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(15)){
                
                /*Captura Variables*/
                $estudiante = $this->input->post('idestudianteanl');
                $recibo = $this->input->post('idreciboanl');
                $motivo = strtoupper($this->input->post('motivoanula'));

                /*Consulta Modelo para anular recibo pago*/
                $anulaRecibo = $this->MFacturacion->anula_recibo($estudiante,$recibo,$motivo);
                if ($anulaRecibo != FALSE){

                    $this->session->set_tempdata('message', "Se anulo el recibo Nro. ".$recibo." correctamente.", 7);
                    $this->aplicarpago();

                } else {

                    $this->session->set_tempdata('messageError', 'No fue posible anular el recibo. Comuniquese con el administrador.', 7);
                    $this->aplicarpago();

                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
}
