<?php
/**************************************************************************
* Nombre de la Clase: CPrincipal
* Version: 1.0.0
* Descripcion: Es el controlador principal el cual carga por default al iniciar
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 22/10/2018
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CPrincipal extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        $this->load->driver('cache'); /*Carga cache*/
        
        /*Carga Modelos*/
        $this->load->model('MPrincipal'); /*Modelo Princial*/
                
        date_default_timezone_set('America/Bogota'); /*Zona horaria*/

        //lineas para eliminar el historico de navegacion./
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: index (por defecto CodeIgniter)
     * Descripcion: Carga la vista de login cuando se inicia sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function index() {
        
        if ($this->session->userdata('validated')) {
            
//            $info['serviciosDia'] = $this->MPrincipal->cantidad_servicios(date('Y-m-d'),date('Y-m-d')); /*Consulta el Modelo Cantidad de servicios*/
//            $info['productosDia'] = $this->MPrincipal->cantidad_productos_venta(date('Y-m-d'),date('Y-m-d')); /*Consulta el Modelo Cantidad de Productos venta*/
//            $info['recibosPagados'] = $this->MPrincipal->cantidad_recibos_estado(date('Y-m-d'),date('Y-m-d'),5); /*Consulta el Modelo Cantidad recibos pagados*/
//            $info['recibosLiquidados'] = $this->MPrincipal->cantidad_recibos_pendientes(); /*Consulta el Modelo Cantidad recibos pendiente pago*/
//            $info['clientesRegistrados'] = $this->MPrincipal->cantidad_clientes(); /*Consulta el Modelo Cantidad de clientes*/
//            $info['gastosPendientes'] = $this->MPrincipal->cantidad_gastos_pendientes(); /*Consulta el Modelo Cantidad de Gastos Pendientes*/
//            $info['gastosPendienteDetalle'] = $this->MPrincipal->gastos_pendiente_detalle(); /*Consulta el Modelo detalle de Gastos Pendientes*/
//            $info['consumoProductos80'] = $this->MPrincipal->consumo_productos_80(); /*Consulta el Modelo productos consumidos 80%*/
//            $info['consumoProductos60'] = $this->MPrincipal->consumo_productos_60(); /*Consulta el Modelo productos consumidos 60%*/
            $info['indicadores'] = $this->MPrincipal->indicadores_generales(); /*Consulta el Modelo productos consumidos 60%*/
            $this->load->view('home',$info);
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: module
     * Descripcion: Devuelve al usuario al home con mensaje de notificacion.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {
            
            //$info['serviciosDia'] = $this->MPrincipal->cantidad_servicios(date('Y-m-d'),date('Y-m-d')); /*Consulta el Modelo Cantidad de servicios*/
            //$info['productosDia'] = $this->MPrincipal->cantidad_productos_venta(date('Y-m-d'),date('Y-m-d')); /*Consulta el Modelo Cantidad de Productos venta*/
            //$info['recibosPagados'] = $this->MPrincipal->cantidad_recibos_estado(date('Y-m-d'),date('Y-m-d'),5); /*Consulta el Modelo Cantidad recibos pagados*/
            //$info['recibosLiquidados'] = $this->MPrincipal->cantidad_recibos_pendientes(); /*Consulta el Modelo Cantidad recibos pendiente pago*/
            //$info['clientesRegistrados'] = $this->MPrincipal->cantidad_clientes(); /*Consulta el Modelo Cantidad de clientes*/
            //$info['citasReservadas'] = $this->MPrincipal->cantidad_citas_agendadas(date('Y-m-d'),date('H:i:s')); /*Consulta el Modelo Cantidad de Citas Pendientes*/
            //$info['citasReservadasDia'] = $this->MPrincipal->cantidad_citas_agendadas(date('Y-m-d'),'00:00:00'); /*Consulta el Modelo Cantidad de Citas del Dia*/
            $this->load->view('home',$info);
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: login
     * Descripcion: valida el Inicio de Sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 21/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function login(){

        /*valida que la peticion http sea POST*/
        if (!$this->input->post()){
            
            $this->index();
            
        } else {
            
            /*valida que los datos no esten vacios*/
            if ($this->input->post('username') == NULL || $this->input->post('pass') == NULL) { 

                $this->index();

            } else {

                /*Captura Variables*/
                $username = $this->input->post('username');
                $password = $this->input->post('pass');

                /*Consulta el Modelo Principal validacion de credenciales*/
                $validateLogin = $this->MPrincipal->login_verify($username,$password);

                if ($validateLogin != FALSE){

                    if ($validateLogin->activo == 'S'){
                        
                        /*Consulta el Modelo Principal para obtener los recursos*/
                        $recursos = $this->MPrincipal->rol_recurso($validateLogin->idRol);
                        
                        if ($recursos == FALSE){
                            
                            $info['message'] = "No tiene recursos asignados. Comuniquese con el administrador";
                            $info['stateMessage'] = 1;
                            $this->load->view('login',$info);
                            
                        } else {
                        
                            $datos_session = array(
                                'userid' => $username,
                                'nombre_usuario' => $validateLogin->nombre_usuario,
                                'perfil' => $validateLogin->descRol,
                                'activo' => $validateLogin->activo,
                                'recursos' => $recursos,
                                'sede' => $validateLogin->idSede,
                                'nombre_sede' => $validateLogin->nombreSede,
                                'dir_sede' => $validateLogin->direccionSede." Tel:".$validateLogin->telefonoSede,
                                'validated' => true
                            );

                            $this->session->set_userdata($datos_session);
                            log_message("DEBUG", "=================================");
                            log_message("DEBUG", $this->session->userdata('validated'));
                            log_message("DEBUG", $this->session->userdata('userid'));
                            log_message("DEBUG", "=================================");

                            $this->index();

                        }
                        
                    } else {

                        $info['message'] = "Usuario Inactivo. Comuniquese con el administrador";
                        $info['stateMessage'] = 1;
                        $this->load->view('login',$info);

                    }

                } else {

                    $info['message'] = "Usuario y/o Contraseña incorrecto";
                    $info['stateMessage'] = 1;
                    $this->load->view('login',$info);

                }

            }
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: changepass
     * Descripcion: Cambiar contraseña usuario logueado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function changepass(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->index();

            } else {

                /*Captura Variables*/
                $passactual = $this->input->post('passactual');
                $passnew = $this->input->post('passnew');
                $passnewconf = $this->input->post('passnewconf');
                    
                /*Consulta el Modulo para validar la clave actual sea correcta*/
                $validateLogin = $this->MPrincipal->login_verify($this->session->userdata('userid'),$passactual);

                if ($validateLogin != FALSE){

                    if ($this->jasr->validaTipoString($passnew,8)){

                        if ($passnew == $passnewconf){
                            
                            /*Enviar datos al modelo para actualizar la clave*/
                            $dataPass = $this->MPrincipal->change_pass($this->session->userdata('userid'),$passnew);
                            
                            if ($dataPass == TRUE) {
                                
                                $this->session->sess_destroy(); /*Cierra la sesion*/
                                $info['message'] = 'Contraseña actualizada exitosamente. Ingrese nuevamente';
                                $info['stateMessage'] = 1;
                                $this->load->view('login',$info); /*Envia usuario al login*/
                                
                            } else {
                                
                                $info['message'] = 'No es posible actualizar. Comuniquese con el administrador del sistema.';
                                $info['alert'] = 2;
                                $this->module($info);
                                
                            }
                            
                        } else {
                            
                            $info['message'] = 'No es posible actualizar. Contraseña nueva no coincide con la confirmación.';
                            $info['alert'] = 2;
                            $this->module($info);
                            
                        }

                    } else {

                        $info['message'] = 'No es posible actualizar. La nueva contraseña no cumple con los requisitos minimos de seguridad.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }

                } else {

                    $info['message'] = 'No es posible actualizar. Contraseña actual incorrecta.';
                    $info['alert'] = 2;
                    $this->module($info);

                }
                
            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: logout
     * Descripcion: Cerrar de Sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/03/2017, Ultima modificacion: 
     **************************************************************************/
    public function logout() {

        /*Borra los datos cargados en memoria Cache [tablas tipo]*/
        $this->cache->memcached->delete('mListgroupservice');
        $this->cache->memcached->delete('mListtypeproduct');
        $this->cache->memcached->delete('mListroles');
        $this->cache->memcached->delete('mListsedes');
        $this->cache->memcached->delete('mTypeProveedor');
        $this->cache->memcached->delete('mListFormaPago');
        $this->cache->memcached->delete('mClientInList');
        $this->cache->memcached->delete('mStateGasto');
        $this->cache->memcached->delete('mTypeGasto');
        $this->cache->memcached->delete('mCategoriaGasto');
        $this->cache->memcached->delete('mListundmedida');
        $this->cache->memcached->delete('mListboards');
        
        /*Destruye los datos de sesion*/
        $this->session->sess_destroy();
        $this->load->view('login');
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: backup
     * Descripcion: Genera Backup de la Base de datos.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function backup() {
        
        if ($this->session->userdata('validated')) {
            
            /*captura variables*/
            $pass = $this->input->post('pass');
            
            $validateLogin = $this->MPrincipal->login_verify($this->session->userdata('userid'),$pass);
            
            if ($validateLogin != FALSE){
                
                // Load the DB utility class
                $this->load->dbutil();
                // Backup your entire database and assign it to a variable
                $backup = $this->dbutil->backup();
                // Load the download helper and send the file to your desktop
                $this->load->helper('download');
                force_download('freya-'.date('Ymd-His').'.gz', $backup);
                
                $info['message'] = 'Se genero el backup de datos exitosamente. Por favor elija la ubicacion en la USB y guardelo.';
                $info['alert'] = 1;
                $this->module($info);
                
            } else {
                
                $info['message'] = 'La contraseña ingresada no es correcta.';
                $info['alert'] = 2;
                $this->module($info);
                
            }
            
        } else {
            
            show_404();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: optimize
     * Descripcion: Optimiza la Base de Datos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/09/2018, Ultima modificacion: 
     **************************************************************************/
    public function optimize() {
        
        if ($this->session->userdata('validated')) {
                        
            // Load the DB utility class
            $this->load->dbutil();
            
            $result = $this->dbutil->optimize_database();

            if ($result !== FALSE)
            {
                    print_r($result);
            }

//            $info['message'] = 'Se genero el backup de datos exitosamente. Por favor elija la ubicacion en la USB y guardelo.';
//            $info['alert'] = 1;
//            $this->module($info);
            
        } else {
            
            show_404();
            
        }
        
    }
    
}
