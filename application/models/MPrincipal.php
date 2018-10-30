<?php
/**************************************************************************
* Nombre de la Clase: MPrincipal
* Descripcion: Es el Modelo principal de consulta a BD
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 22/10/2018
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MPrincipal extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: login_verify
     * Descripcion: Recupera y valida la informacion de inicio de sesion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function login_verify($username,$password) {
                
        /*Encriptacion de la Clave de Acceso*/
        $pass = sha1($password);
        
        /*Recupera datos del usuario*/
        $query = $this->db->query("SELECT
                                s.idUsuario,
                                s.nombres as nombre_usuario,
                                s.apellidos,
                                s.email,
                                s.activo,
                                s.idRol,
                                r.descRol,
                                s.idSede,
                                e.nombreSede,
                                e.direccionSede,
                                e.telefonoSede
                                FROM
                                safic_usuario s
                                JOIN safic_rol r ON r.idRol = s.idRol
                                JOIN sede e On e.idSede = s.idSede
                                WHERE s.idUsuario = ".$username."
                                AND s.password = '".$pass."'");
        
        $cant = $query->num_rows();
        
        if($cant>0){
            
            return $query->row();
            
        } else {
            
            return false;
            
        }
        
    }
        
    /**************************************************************************
     * Nombre del Metodo: change_pass
     * Descripcion: Actualiza la constraseña de un usuario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 20/04/2017, Ultima modificacion: 
     **************************************************************************/
    public function change_pass($idusuario,$newpass) {
                    
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        
        $query1 = $this->db->query("UPDATE
                                    safic_usuario SET
                                    password = '".sha1($newpass)."'
                                    WHERE
                                    idUsuario = ".$idusuario."");
        
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: rol_recurso
     * Descripcion: Recupera los recursos asignados al rol del usuario logueado
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function rol_recurso($idRol) {
        
        /*Recupera los recursos del rol asignado al usuario logueado*/
        $query = $this->db->query("SELECT
                                s.idRecurso,
                                r.descRecurso
                                FROM safic_rol_recurso s
                                JOIN safic_recurso r ON r.idRecurso = s.idRecurso
                                WHERE s.idRol = ".$idRol."");
        
        $cant = $query->num_rows();
        
        if($cant>0){
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: indicadores_generales
     * Descripcion: Recupera los indicadores generales del sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function indicadores_generales() {
        
        /*Recupera los indicadores generales*/
        $query1 = $this->db->query("SELECT
                                    count(1) as cantidadEstudiante
                                    FROM estudiante_maestro e
                                    WHERE activo = 'S'");
        $query['estudiantes'] = $query1->row();
        
        $query2 = $this->db->query("SELECT count(1) as cantidadCursos
                                    FROM curso c
                                    WHERE activo = 'S'");
        $query['cursos'] = $query2->row();
        
        $query3 = $this->db->query("SELECT count(1) as cantidadJornadas
                                    FROM jornada j
                                    WHERE activo = 'S'");
        $query['jornadas'] = $query3->row();
        
        $query4 = $this->db->query("SELECT count(1) as cantidadcuentas
                                    FROM factura_maestro f
                                    WHERE idEstado = 1
                                    AND nroRecibo = 0");
        $query['cuentascobrar'] = $query4->row();
        
        $query5 = $this->db->query("SELECT
                                    sum(f.valorTarifa) as valorCobrar
                                    FROM factura_detalle f
                                    JOIN factura_maestro m ON m.nroFactura = f.nroFactura
                                    WHERE m.idEstado = 1
                                    AND m.nroRecibo = 0");
        $query['valorcobrar'] = $query5->row();
        
        $query6 = $this->db->query("SELECT count(distinct nroRecibo) cantidadLiquida
                                    FROM factura_maestro f
                                    WHERE idEstado = 2
                                    AND nroRecibo != 0");
        $query['liquidaciones'] = $query6->row();
        
        $query7 = $this->db->query("SELECT
                                    sum(f.valorTarifa) as valorLiquidaciones
                                    FROM factura_detalle f
                                    JOIN factura_maestro m ON m.nroFactura = f.nroFactura
                                    WHERE m.idEstado = 2
                                    AND m.nroRecibo != 0");
        $query['valorliquidaciones'] = $query7->row();
        
        $query8 = $this->db->query("SELECT count(distinct nroRecibo) cantidadAnula
                                    FROM factura_maestro f
                                    WHERE idEstado = 4
                                    AND nroRecibo != 0");
        $query['anularecibo'] = $query8->row();
        
        
        return $query;
        
    }
    
}
