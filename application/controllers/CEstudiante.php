<?php
/**************************************************************************
* Nombre de la Clase: CEstudiante
* Version: 1.0
* Descripcion: Es el controlador para el Modulo de Registro Estudiantil
* en el sistema.
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 22/10/2018
**************************************************************************/

defined('BASEPATH') OR exit('No direct script access allowed');

class CEstudiante extends CI_Controller {

    function __construct() {
        
        parent::__construct(); /*por defecto*/
        $this->load->helper('url'); /*Carga la url base por defecto*/
        $this->load->library('jasr'); /*Funciones Externas de Apoyo*/
        
        /*Carga Modelos*/
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
     * Fecha Creacion: 27/03/2017, Ultima modificacion: 
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
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function module($info) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(1)){
            
                /*Consulta Modelo para obtener listado de Tipo Documento*/
                $listTipoDoc = $this->MEstudiante->list_tipo_documento();
                /*Consulta Modelo para obtener listado Cursos*/
                $listCursos = $this->MEstudiante->list_cursos();
                /*Consulta Modelo para obtener listado Jornadas*/
                $listJornadas = $this->MEstudiante->list_jornadas();
                /*Consulta Modelo para obtener listado Documentos Requisito*/
                $listRequisitos = $this->MEstudiante->list_documentos_requisito();
                /*Consulta Modelo para obtener listado de Estudiantes registrados*/
                $listEstudiantes = $this->MEstudiante->list_estudiantes(0); /*todos*/
                
                /*Retorna a la vista con los datos obtenidos*/
                $info['list_documento'] = $listTipoDoc;
                $info['list_estudiante'] = $listEstudiantes;
                $info['list_cursos'] = $listCursos;
                $info['list_jornadas'] = $listJornadas;
                $info['list_requisitos'] = $listRequisitos;
                $this->load->view('estudiantes/estudiantes',$info); 
            
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->load->view('login');
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addestudiante
     * Descripcion: Crear Estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function addestudiante(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(1)){
                
                    /*Captura Variables Estudiante*/
                    $dataEstudiante['tipoDocEst'] = $this->input->post('tipo_doc');
                    $dataEstudiante['idEstudiante'] = $this->input->post('id_estudiante');
                    $dataEstudiante['nombreEst'] = strtoupper($this->input->post('nombre_est'));
                    $dataEstudiante['apellidoEst'] = strtoupper($this->input->post('apellido_est'));
                    $date1 = new DateTime($this->input->post('fechanace')); 
                    $dataEstudiante['fechaNaceEst'] = $date1->format('Y-m-d'); 
                    $dataEstudiante['epsEst'] = strtoupper($this->input->post('eps_estudiante'));
                    $dataEstudiante['rhEst'] = $this->input->post('tipo_rh');
                    $date2 = new DateTime($this->input->post('fechaingresa')); 
                    $dataEstudiante['fechaIngresoEst'] = $date2->format('Y-m-d'); 
                    $dataEstudiante['cursoEst'] = $this->input->post('curso');
                    $dataEstudiante['jornadaEst'] = $this->input->post('jornada');
                    
                    /*Captura Variables Acudiente*/
                    $dataAcudiente['tipoDocAcu'] = $this->input->post('tipo_doc_acu');
                    $dataAcudiente['idAcudiente'] = $this->input->post('id_acudiente');
                    $dataAcudiente['nombreAcu'] = strtoupper($this->input->post('nombre_acu'));
                    $dataAcudiente['apellidoAcu'] = strtoupper($this->input->post('apellido_acu'));
                    $dataAcudiente['parentesco'] = $this->input->post('parentesco');
                    $dataAcudiente['direccionAcu'] = strtoupper($this->input->post('dir_acu'));
                    $dataAcudiente['telefonoAcu'] = $this->input->post('tel_acu');
                    $dataAcudiente['mailAcu'] = $this->input->post('mail_acu');
                    
                    if (!$this->MEstudiante->valida_estudiante($dataEstudiante['idEstudiante'])){
                    
                        if ($this->jasr->validaTipoString($dataEstudiante['nombreEst'],1) && $this->jasr->validaTipoString($dataEstudiante['apellidoEst'],1)){

                            if ($this->jasr->validaTipoString($dataEstudiante['idEstudiante'],5)){

                                if ($this->jasr->validaTipoString($dataAcudiente['idAcudiente'],5) && $this->jasr->validaTipoString($dataAcudiente['nombreAcu'],1) && $this->jasr->validaTipoString($dataAcudiente['apellidoAcu'],1)){

                                    if ($this->jasr->validaTipoString($dataAcudiente['mailAcu'],6)){

                                        /*Envia datos al modelo para el registro del estudiante y acudiente*/
                                        $registerDataEst = $this->MEstudiante->registra_estudiante($dataEstudiante,$dataAcudiente);

                                        if ($registerDataEst == TRUE){
                                            
                                            /*Consulta Modelo para obtener listado de Requisitos*/
                                            $listRequisitos = $this->MEstudiante->list_documentos_requisito();
                                            
                                            foreach ($listRequisitos as $requisitoEst){

                                                $cumpleRequisito = $this->input->post($requisitoEst['idDocumento']);

                                                if ($cumpleRequisito == 'on'){

                                                    /*inserta requisito del estudiante*/
                                                    $this->MEstudiante->ins_req_estudiante($requisitoEst['idDocumento'],$dataEstudiante['idEstudiante']);

                                                } 

                                            }
                                            
                                            $info['message'] = 'Estudiante Registrado Exitosamente';
                                            $info['alert'] = 1;
                                            $this->module($info);

                                        } else {

                                            $info['message'] = 'No fue posible registrar el estudiante';
                                            $info['alert'] = 2;
                                            $this->module($info);

                                        }

                                    } else {

                                        $info['message'] = 'No fue posible registrar el estudiante. Email del Acudiente inválido.';
                                        $info['alert'] = 2;
                                        $this->module($info);

                                    }

                                } else {

                                    $info['message'] = 'No fue posible registrar el estudiante. Datos del Acudiente inválidos.';
                                    $info['alert'] = 2;
                                    $this->module($info);

                                }

                            } else {

                                $info['message'] = 'No fue posible registrar el estudiante. Identificación inválida.';
                                $info['alert'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible registrar el estudiante. Nombre/Apellido incorrecto.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }
                
                    } else {
                        
                        $info['message'] = 'La identificacion del estudiante ya existe en el sistema.';
                        $info['alert'] = 2;
                        $this->module($info);
                        
                    }
                    
                } else {
                    
                    show_404();
                    
                }
                
            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: updestudiante
     * Descripcion: Actualiza la informacion del Estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function updestudiante(){
        
        if ($this->session->userdata('validated')) {
        
            /*valida que la peticion http sea POST*/
            if (!$this->input->post()){

                $this->module($info);

            } else {

                if ($this->MRecurso->validaRecurso(6)){
                
                    /*Captura Variables Estudiante*/
                    $dataEstudiante['tipoDocEst'] = $this->input->post('tipo_doc');
                    $dataEstudiante['idEstudiante'] = $this->input->post('id_estudiante');
                    $dataEstudiante['nombreEst'] = strtoupper($this->input->post('nombre_est'));
                    $dataEstudiante['apellidoEst'] = strtoupper($this->input->post('apellido_est'));
                    $date1 = new DateTime($this->input->post('fechanace')); 
                    $dataEstudiante['fechaNaceEst'] = $date1->format('Y-m-d'); 
                    $dataEstudiante['epsEst'] = strtoupper($this->input->post('eps_estudiante'));
                    $dataEstudiante['rhEst'] = $this->input->post('tipo_rh');
                    $date2 = new DateTime($this->input->post('fechaingresa')); 
                    $dataEstudiante['fechaIngresoEst'] = $date2->format('Y-m-d'); 
                    $dataEstudiante['cursoEst'] = $this->input->post('curso');
                    $dataEstudiante['jornadaEst'] = $this->input->post('jornada');
                    $tipoEstado = $this->input->post('estado');
                    if ($tipoEstado == 'on'){
                        $dataEstudiante['estadoEst'] = 'S';
                    } else {
                        $dataEstudiante['estadoEst'] = 'N';
                    }
                    
                                                            
                    if ($this->jasr->validaTipoString($dataEstudiante['nombreEst'],1) && $this->jasr->validaTipoString($dataEstudiante['apellidoEst'],1)){

                        if ($this->jasr->validaTipoString($dataEstudiante['idEstudiante'],5)){

                            /*Envia datos al modelo para la actualizacion del estudiante*/
                            $updDataEst = $this->MEstudiante->actualiza_estudiante($dataEstudiante);

                            if ($updDataEst == TRUE){

                                /*Consulta Modelo para Borrar listado de documentos Requisitos del estudiante*/
                                $delRequisitos = $this->MEstudiante->del_req_estudiante($dataEstudiante['idEstudiante']);
                                
                                if ($delRequisitos){
                                
                                    /*Consulta Modelo para obtener listado de Requisitos*/
                                    $listRequisitos = $this->MEstudiante->list_documentos_requisito();

                                    foreach ($listRequisitos as $requisitoEst){

                                        $cumpleRequisito = $this->input->post($requisitoEst['idDocumento']);

                                        if ($cumpleRequisito == 'on'){

                                            /*inserta requisito del estudiante*/
                                            $this->MEstudiante->ins_req_estudiante($requisitoEst['idDocumento'],$dataEstudiante['idEstudiante']);

                                        } 

                                    }
                                
                                }
                                
                                $info['message'] = 'Estudiante Actualizado Exitosamente';
                                $info['alert'] = 1;
                                $this->module($info);

                            } else {

                                $info['message'] = 'No fue posible Actualizar el estudiante. Comuniquese con el administrador.';
                                $info['alert'] = 2;
                                $this->module($info);

                            }

                        } else {

                            $info['message'] = 'No fue posible actualizar el estudiante. Identificación inválida.';
                            $info['alert'] = 2;
                            $this->module($info);

                        }

                    } else {

                        $info['message'] = 'No fue posible actualizar el estudiante. Nombre/Apellido incorrecto.';
                        $info['alert'] = 2;
                        $this->module($info);

                    }
                    
                } else {
                    
                    show_404();
                    
                }
                
            }
        
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addcurso
     * Descripcion: Permite registrar un nuevo curso al sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function addcurso() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(3)){
                
                /*Captura Variables*/
                $descCurso = strtoupper($this->input->post('curso_safic'));
                
                /*Consulta Modelo para registrar curso*/
                $insCurso = $this->MEstudiante->registra_curso($descCurso);
                if ($insCurso == FALSE){
                    
                    $info['message'] = 'No fue posible registrar el curso en el sistema. Comuniquese con el administrador.';
                    $info['alert'] = 2;
                    $this->module($info);
                    
                } else {
                    
                    $info['message'] = 'Se registro correctamente el curso en el sistema.';
                    $info['alert'] = 1;
                    $this->module($info);
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addjornada
     * Descripcion: Permite registrar una nueva jornada en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function addjornada() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(5)){
                
                /*Captura Variables*/
                $descJornada = strtoupper($this->input->post('jornada_safic'));
                
                /*Consulta Modelo para registrar curso*/
                $insJornada = $this->MEstudiante->registra_jornada($descJornada);
                if ($insJornada == FALSE){
                    
                    $info['message'] = 'No fue posible registrar la jornada en el sistema. Comuniquese con el administrador.';
                    $info['alert'] = 2;
                    $this->module($info);
                    
                } else {
                    
                    $info['message'] = 'Se registro correctamente la Jornada en el sistema.';
                    $info['alert'] = 1;
                    $this->module($info);
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: getestudiante
     * Descripcion: Permite recuperar los datos de un estudiante y devolver a la
     * vista para editar o visualizar la informacion.
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function getestudiante($idEstudiante) {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(6) || $this->MRecurso->validaRecurso(7)){
                                                
                /*Consulta Modelo para obtener los datos del estudiante*/
                $dataEstudiante = $this->MEstudiante->get_estudiante($idEstudiante);
                
                if ($dataEstudiante == FALSE){
                    
                    $info['message'] = 'No fue posible recuperar la informacion del estudiante. Comuniquese con el administrador.';
                    $info['alert'] = 2;
                    $this->module($info);
                    
                } else {
                    
                    $listTipoDoc = $this->MEstudiante->list_tipo_documento(); /*Consulta Modelo para obtener listado de Tipo Documento*/
                    $listCursos = $this->MEstudiante->list_cursos(); /*Consulta Modelo para obtener listado Cursos*/
                    $listJornadas = $this->MEstudiante->list_jornadas(); /*Consulta Modelo para obtener listado Jornadas*/
                    $listRequisitos = $this->MEstudiante->list_documentos_requisito(); /*Consulta Modelo para obtener listado Documentos Requisito*/
                    
                    /*Consulta Modelo para obtener los acudientes del estudiante*/
                    $acudientesRegistro = $this->MEstudiante->list_acudientes($idEstudiante);
                    /*Consulta Modelo para obtener los documentos entregados del estudiante*/
                    $documentosEstudiante = $this->MEstudiante->list_doc_estudiante($idEstudiante);
                    
                    $info['list_documento'] = $listTipoDoc;
                    $info['list_cursos'] = $listCursos;
                    $info['list_jornadas'] = $listJornadas;
                    $info['list_requisitos'] = $listRequisitos;
                    $info['documentos_estudiante'] = $documentosEstudiante;
                    $info['dataEstudiante'] = $dataEstudiante;
                    $info['list_acudientes'] = $acudientesRegistro;
                    
                    if ($this->MRecurso->validaRecurso(6)){ 
                        /*permiso de editar*/
                        $this->load->view('estudiantes/getestudiante',$info);
                    } else {
                        /*permiso de ver*/
                        $this->load->view('estudiantes/viewestudiante',$info);
                    }
                    
                                        
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: addacudiente
     * Descripcion: Permite registrar un acudiente para el estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function addacudiente() {
        
        if ($this->session->userdata('validated')) {

            if ($this->MRecurso->validaRecurso(8)){
                
                /*Captura Variables Acudiente*/
                $idEstudiante = $this->input->post('id_estudiante');
                $dataAcudiente['tipoDocAcu'] = $this->input->post('tipo_doc_acu');
                $dataAcudiente['idAcudiente'] = $this->input->post('id_acudiente');
                $dataAcudiente['nombreAcu'] = strtoupper($this->input->post('nombre_acu'));
                $dataAcudiente['apellidoAcu'] = strtoupper($this->input->post('apellido_acu'));
                $dataAcudiente['parentesco'] = $this->input->post('parentesco');
                $dataAcudiente['direccionAcu'] = strtoupper($this->input->post('dir_acu'));
                $dataAcudiente['telefonoAcu'] = $this->input->post('tel_acu');
                $dataAcudiente['mailAcu'] = $this->input->post('mail_acu');
                
                /*Consulta Modelo para registrar Acudiente*/
                $insAcudiente = $this->MEstudiante->registra_acudiente($idEstudiante,$dataAcudiente);
                
                if ($insAcudiente == FALSE){
                    
                    $info['message'] = 'No fue posible registrar el acudiente en el sistema. Comuniquese con el administrador.';
                    $info['alert'] = 2;
                    $this->module($info);
                    
                } else {
                    
                    $info['message'] = 'Se registro correctamente el Acudiente en el sistema.';
                    $info['alert'] = 1;
                    $this->module($info);
                    
                }
                
            } else {
                
                show_404();
                
            }
            
        } else {
            
            $this->index();
            
        }
        
    }
    
    
}
