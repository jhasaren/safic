<?php
/**************************************************************************
* Nombre de la Clase: MEstudiante
* Descripcion: Es el Modelo para las interacciones en BD del modulo registro
* estudiantil
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 22/10/2018
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MEstudiante extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_estudiantes
     * Descripcion: Obtiene todos los estudiantes registrados
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_estudiantes($tipo) {
        
        if ($tipo == 0){ 
            /*todos*/
            $sql = "SELECT
                    t.descTipoDocumento,
                    e.idEstudiante,
                    e.nombres,
                    e.apellidos,
                    e.fechaIngreso,
                    c.idCurso,
                    cl.descCurso,
                    c.idJornada,
                    jo.descJornada,
                    c.idTipoCalendario,
                    tc.descCalendario,
                    e.activo
                    FROM estudiante_maestro e
                    JOIN tipo_documento t ON t.idTipoDocumento = e.idTipoDocumento
                    LEFT JOIN estudiante_carrera c ON c.idEstudiante = e.idEstudiante AND c.activo = 'S'
                    LEFT JOIN curso cl ON cl.idCurso = c.idCurso
                    LEFT JOIN jornada jo ON jo.idJornada = c.idJornada
                    LEFT JOIN tipo_calendario tc ON tc.idTipoCalendario = c.idTipoCalendario
                    WHERE e.idSede = ".$this->session->userdata('sede')."";
            
        } else {
            /*solo activos*/
            $sql = "SELECT
                    t.descTipoDocumento,
                    e.idEstudiante,
                    e.nombres,
                    e.apellidos,
                    e.fechaIngreso,
                    c.idCurso,
                    cl.descCurso,
                    c.idJornada,
                    jo.descJornada,
                    c.idTipoCalendario,
                    tc.descCalendario,
                    e.activo
                    FROM estudiante_maestro e
                    JOIN tipo_documento t ON t.idTipoDocumento = e.idTipoDocumento
                    LEFT JOIN estudiante_carrera c ON c.idEstudiante = e.idEstudiante AND c.activo = 'S'
                    LEFT JOIN curso cl ON cl.idCurso = c.idCurso
                    LEFT JOIN jornada jo ON jo.idJornada = c.idJornada
                    LEFT JOIN tipo_calendario tc ON tc.idTipoCalendario = c.idTipoCalendario
                    WHERE e.idSede = ".$this->session->userdata('sede')."
                    AND e.activo = 'S'
                    ORDER BY e.nombres";
            
        }
        
        /*Recupera los estudiantes registrados*/
        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_tipo_documento
     * Descripcion: Obtiene los tipos de documento para la identificacion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_tipo_documento() {
                
        /*Recupera los tipos de doc creados*/
        $query = $this->db->query("SELECT
                                idTipoDocumento,
                                descTipoDocumento
                                FROM tipo_documento
                                ORDER BY 1");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
        
    /**************************************************************************
     * Nombre del Metodo: list_cursos
     * Descripcion: Obtiene los tipos cursos
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_cursos() {
                
        /*Recupera los cursos creados*/
        $query = $this->db->query("SELECT
                                idCurso,
                                descCurso,
                                fechaRegistra
                                FROM curso c
                                WHERE activo = 'S'
                                AND idSede = ".$this->session->userdata('sede')."
                                ORDER BY 2");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
        
    /**************************************************************************
     * Nombre del Metodo: list_jornadas
     * Descripcion: Obtiene los tipos de jornadas
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_jornadas() {
                
        /*Recupera las jornadas creadas*/
        $query = $this->db->query("SELECT
                                idJornada,
                                descJornada,
                                fechaRegistra
                                FROM jornada j
                                WHERE activo = 'S'
                                AND idSede = ".$this->session->userdata('sede')."
                                ORDER BY 2");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: list_documentos_requisito
     * Descripcion: Obtiene los documentos de requisito
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_documentos_requisito() {
                
        /*Recupera los documentos requisitos creados*/
        $query = $this->db->query("SELECT
                                idDocumento,
                                descDocumento
                                FROM documentos d
                                WHERE activo = 'S'
                                ORDER BY 2");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_estudiante
     * Descripcion: Registra un Estudiante en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_estudiante($dataEstudiante,$dataAcudiente) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                    estudiante_maestro (
                                    idTipoDocumento, 
                                    idEstudiante, 
                                    nombres, 
                                    apellidos, 
                                    fechaNacimiento, 
                                    tipoSangreRH, 
                                    entidadSalud, 
                                    fechaIngreso, 
                                    idSede, 
                                    activo,
                                    fechaRegistro,
                                    usuarioRegistra
                                    ) VALUES (
                                    ".$dataEstudiante['tipoDocEst'].",
                                    ".$dataEstudiante['idEstudiante'].",
                                    '".$dataEstudiante['nombreEst']."',
                                    '".$dataEstudiante['apellidoEst']."',
                                    '".$dataEstudiante['fechaNaceEst']."',
                                    '".$dataEstudiante['rhEst']."',
                                    '".$dataEstudiante['epsEst']."',
                                    '".$dataEstudiante['fechaIngresoEst']."',
                                    ".$this->session->userdata('sede').",
                                    'S',
                                    NOW(),
                                    ".$this->session->userdata('userid')."
                                    )");
        
        if ($this->valida_acudiente($dataAcudiente['idAcudiente'])){ /*valida si existe acudiente*/
            
            $query2 = $this->db->query("UPDATE acudiente SET
                                    nombres = '".$dataAcudiente['nombreAcu']."', 
                                    apellidos = '".$dataAcudiente['apellidoAcu']."', 
                                    direccion = '".$dataAcudiente['direccionAcu']."', 
                                    telefono = '".$dataAcudiente['telefonoAcu']."', 
                                    email = '".$dataAcudiente['mailAcu']."'
                                    WHERE
                                    idAcudiente = ".$dataAcudiente['idAcudiente'].""); 
            
        } else {
            
           $query2 = $this->db->query("INSERT INTO
                                    acudiente (
                                    idTipoDocAcu,
                                    idAcudiente, 
                                    nombres, 
                                    apellidos,  
                                    direccion, 
                                    telefono, 
                                    email
                                    ) VALUES (
                                    ".$dataAcudiente['tipoDocAcu'].",
                                    ".$dataAcudiente['idAcudiente'].",
                                    '".$dataAcudiente['nombreAcu']."',
                                    '".$dataAcudiente['apellidoAcu']."',
                                    '".$dataAcudiente['direccionAcu']."',
                                    '".$dataAcudiente['telefonoAcu']."',
                                    '".$dataAcudiente['mailAcu']."'
                                    )"); 
            
        }
                
        $query3 = $this->db->query("INSERT INTO
                                    estudiante_carrera (
                                    idEstudiante, 
                                    fechaRegistro, 
                                    idCurso, 
                                    idJornada, 
                                    activo,
                                    idSede,
                                    idUsuarioRegistra,
                                    idTipoCalendario
                                    ) VALUES (
                                    ".$dataEstudiante['idEstudiante'].",
                                    NOW(),
                                    ".$dataEstudiante['cursoEst'].",
                                    ".$dataEstudiante['jornadaEst'].",
                                    'S',
                                    ".$this->session->userdata('sede').",
                                    ".$this->session->userdata('userid').",
                                    ".$dataEstudiante['calendario']."
                                    )");
        
        $query4 = $this->db->query("INSERT INTO
                                    estudiante_acudiente (
                                    idEstudiante,
                                    idAcudiente,
                                    parentesco
                                    ) VALUES (
                                    ".$dataEstudiante['idEstudiante'].",
                                    ".$dataAcudiente['idAcudiente'].",
                                    '".$dataAcudiente['parentesco']."'
                                    )");
        
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: actualiza_estudiante
     * Descripcion: Actualiza los datos de un Estudiante en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function actualiza_estudiante($dataEstudiante) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $query = $this->db->query("UPDATE estudiante_maestro SET
                                    idTipoDocumento = ".$dataEstudiante['tipoDocEst'].",
                                    nombres = '".$dataEstudiante['nombreEst']."',
                                    apellidos = '".$dataEstudiante['apellidoEst']."',
                                    fechaNacimiento = '".$dataEstudiante['fechaNaceEst']."',
                                    tipoSangreRH = '".$dataEstudiante['rhEst']."',
                                    entidadSalud = '".$dataEstudiante['epsEst']."',
                                    fechaIngreso = '".$dataEstudiante['fechaIngresoEst']."',
                                    activo = '".$dataEstudiante['estadoEst']."'
                                    WHERE
                                    idEstudiante = ".$dataEstudiante['idEstudiante']."");
        
        /*Verifica si ya existe la relacion entre estudiante y curso/jornada/calendario - carrera*/
        $queryValida = $this->db->query("SELECT
                                        e.idEstudiante,
                                        e.idCurso,
                                        e.idJornada
                                        FROM estudiante_carrera e
                                        WHERE
                                        e.idEstudiante = ".$dataEstudiante['idEstudiante']."
                                        AND e.idCurso = ".$dataEstudiante['cursoEst']."
                                        AND e.idJornada = ".$dataEstudiante['jornadaEst']."
                                        AND e.idTipoCalendario = ".$dataEstudiante['calendario']."
                                        AND e.activo = 'S'");
        
        if ($queryValida->num_rows() == 0) {
            
            /*Coloca todos los registros como inactivos*/
            $this->db->query("UPDATE estudiante_carrera 
                            SET activo = 'N'
                            WHERE idEstudiante = ".$dataEstudiante['idEstudiante']."");
            
            /*Crea un nuevo registro como activo*/
            $this->db->query("INSERT INTO
                            estudiante_carrera (
                            idEstudiante, 
                            fechaRegistro, 
                            idCurso, 
                            idJornada, 
                            activo, 
                            idSede, 
                            idUsuarioRegistra,
                            idTipoCalendario
                            ) VALUES (
                            ".$dataEstudiante['idEstudiante'].",
                            NOW(),
                            ".$dataEstudiante['cursoEst'].",
                            ".$dataEstudiante['jornadaEst'].",
                            'S',
                            ".$this->session->userdata('sede').",
                            ".$this->session->userdata('userid').",
                            ".$dataEstudiante['calendario']."
                            )");

        }  
        
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_acudiente
     * Descripcion: Registra un Acudiente en BD
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_acudiente($idEstudiante,$dataAcudiente) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        
        if ($this->valida_acudiente($dataAcudiente['idAcudiente'])){ /*valida si existe acudiente*/
            
            $query2 = $this->db->query("UPDATE acudiente SET
                                    nombres = '".$dataAcudiente['nombreAcu']."', 
                                    apellidos = '".$dataAcudiente['apellidoAcu']."', 
                                    direccion = '".$dataAcudiente['direccionAcu']."', 
                                    telefono = '".$dataAcudiente['telefonoAcu']."', 
                                    email = '".$dataAcudiente['mailAcu']."'
                                    WHERE
                                    idAcudiente = ".$dataAcudiente['idAcudiente'].""); 
            
            $query3 = $this->db->query("UPDATE estudiante_acudiente SET
                                    parentesco = '".$dataAcudiente['parentesco']."'
                                    WHERE
                                    idAcudiente = ".$dataAcudiente['idAcudiente']."
                                    AND idEstudiante = ".$idEstudiante.""); 
            
        } else {
            
           $query2 = $this->db->query("INSERT INTO
                                    acudiente (
                                    idTipoDocAcu,
                                    idAcudiente, 
                                    nombres, 
                                    apellidos,  
                                    direccion, 
                                    telefono, 
                                    email
                                    ) VALUES (
                                    ".$dataAcudiente['tipoDocAcu'].",
                                    ".$dataAcudiente['idAcudiente'].",
                                    '".$dataAcudiente['nombreAcu']."',
                                    '".$dataAcudiente['apellidoAcu']."',
                                    '".$dataAcudiente['direccionAcu']."',
                                    '".$dataAcudiente['telefonoAcu']."',
                                    '".$dataAcudiente['mailAcu']."'
                                    )"); 
            
        }
        
        /*Verifica si ya existe la relacion entre acudiente y estudiante*/
        $queryValida = $this->db->query("SELECT
                                        idEstudiante,
                                        idAcudiente,
                                        parentesco
                                        FROM estudiante_acudiente
                                        WHERE idAcudiente = ".$dataAcudiente['idAcudiente']."
                                        AND idEstudiante = ".$idEstudiante."");
        
        if ($queryValida->num_rows() == 0) {

            $this->db->query("INSERT INTO
                            estudiante_acudiente (
                            idEstudiante,
                            idAcudiente,
                            parentesco
                            ) VALUES (
                            ".$idEstudiante.",
                            ".$dataAcudiente['idAcudiente'].",
                            '".$dataAcudiente['parentesco']."'
                            )");

        }        
        
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: valida_estudiante
     * Descripcion: Consulta si ya existe registrado el id para un estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function valida_estudiante($idEstudiante) {
                
        /*Recupera los datos del estudiante*/
        $query = $this->db->query("SELECT
                                idEstudiante,
                                activo
                                FROM estudiante_maestro
                                WHERE idEstudiante = ".$idEstudiante."");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: valida_acudiente
     * Descripcion: Consulta si ya existe registrado el id para un acudiente
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function valida_acudiente($idAcudiente) {
                
        /*Recupera los datos del estudiante*/
        $query = $this->db->query("SELECT
                                idAcudiente,
                                email
                                FROM acudiente
                                WHERE idAcudiente = ".$idAcudiente."");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return true;

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: ins_req_estudiante
     * Descripcion: Inserta el requisito entregado del estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function ins_req_estudiante($idRequisito,$idEstudiante) {
        
        $queryValida = $this->db->query("SELECT
                                        idEstudiante
                                        FROM
                                        documento_estudiante
                                        WHERE
                                        idEstudiante = ".$idEstudiante."
                                        AND idDocumento = ".$idRequisito."");
        
        if ($queryValida->num_rows() == 0) {
        
            $this->db->trans_start();        
            $query = $this->db->query("INSERT INTO
                                    documento_estudiante (
                                    idEstudiante,
                                    idDocumento)
                                    VALUES (
                                    ".$idEstudiante.",
                                    ".$idRequisito."
                                    )");
            $this->db->trans_complete();
            $this->db->trans_off();

            if ($this->db->trans_status() === FALSE){

                return false;

            } else {

                return true;

            }
        
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: del_req_estudiante
     * Descripcion: Borra todos los documentos marcados como entregados del estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function del_req_estudiante($idEstudiante) {
        
        $this->db->trans_start();        
        $this->db->query("DELETE FROM documento_estudiante
                        WHERE idEstudiante = ".$idEstudiante."");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_curso
     * Descripcion: regitra un nuevo curso en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_curso($nombreCurso) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                curso (
                                descCurso, 
                                activo, 
                                idSede, 
                                fechaRegistra, 
                                idUsuarioRegistra
                                )
                                VALUES (
                                '".$nombreCurso."',
                                'S',
                                ".$this->session->userdata('sede').",
                                NOW(),
                                ".$this->session->userdata('userid')."
                                )");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_jornada
     * Descripcion: registra una nueva jornada en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_jornada($nombreJornada) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                jornada (
                                descJornada, 
                                activo, 
                                idSede, 
                                fechaRegistra, 
                                idUsuarioRegistra
                                )
                                VALUES (
                                '".$nombreJornada."',
                                'S',
                                ".$this->session->userdata('sede').",
                                NOW(),
                                ".$this->session->userdata('userid')."
                                )");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: get_estudiante
     * Descripcion: Obtiene los datos del estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 22/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function get_estudiante($idEstudiante) {
                
        /*Recupera la informacion del estudiante*/
        $query = $this->db->query("SELECT
                                e.idTipoDocumento,
                                t.descTipoDocumento,
                                e.idEstudiante,
                                e.nombres,
                                e.apellidos,
                                e.fechaNacimiento,
                                e.tipoSangreRH,
                                e.entidadSalud,
                                e.fechaIngreso,
                                e.idSede,
                                e.activo,
                                s.idCurso,
                                c.descCurso,
                                s.idJornada,
                                j.descJornada,
                                s.idTipoCalendario,
                                p.descCalendario
                                FROM
                                estudiante_maestro e
                                JOIN tipo_documento t ON t.idTipoDocumento = e.idTipoDocumento
                                LEFT JOIN estudiante_carrera s ON s.idEstudiante = e.idEstudiante AND s.activo = 'S'
                                LEFT JOIN curso c ON c.idCurso = s.idCurso
                                LEFT JOIN jornada j ON j.idJornada = s.idJornada
                                LEFT JOIN tipo_calendario p ON p.idTipoCalendario = s.idTipoCalendario
                                WHERE e.idEstudiante = ".$idEstudiante."");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->row();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: list_acudientes
     * Descripcion: Lista los acudientes del estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_acudientes($idEstudiante) {
                
        /*Recupera los acudientes del estudiante*/
        $query = $this->db->query("SELECT
                                a.idTipoDocAcu,
                                t.descTipoDocumento,
                                e.idAcudiente,
                                e.parentesco,
                                a.nombres,
                                a.apellidos,
                                a.direccion,
                                a.telefono,
                                a.email
                                FROM estudiante_acudiente e
                                JOIN acudiente a ON a.idAcudiente = e.idAcudiente
                                JOIN tipo_documento t ON t.idTipoDocumento = a.idTipoDocAcu
                                WHERE e.idEstudiante = ".$idEstudiante."");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: list_doc_estudiante
     * Descripcion: Lista los documentos entregados del estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_doc_estudiante($idEstudiante) {
                
        /*Recupera los documentos del estudiante*/
        $query = $this->db->query("SELECT
                                d.idDocumento,
                                s.descDocumento
                                FROM documento_estudiante d
                                JOIN documentos s ON s.idDocumento = d.idDocumento
                                WHERE d.idEstudiante = ".$idEstudiante."");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: list_tipo_calendario
     * Descripcion: Obtiene los tipos de calendario
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 01/11/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_tipo_calendario() {
                
        /*Recupera los tipos de calendario creados*/
        $query = $this->db->query("SELECT
                                t.idTipoCalendario,
                                t.descCalendario
                                FROM tipo_calendario t
                                WHERE activo = 'S'");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: suprime_acudiente_estudiante
     * Descripcion: desasocia el acudiente del estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 01/11/2018, Ultima modificacion: 
     **************************************************************************/
    public function suprime_acudiente_estudiante($idAcudiente,$idEstudiante) {
        
        $this->db->trans_start();        
        $this->db->query("DELETE FROM estudiante_acudiente
                        WHERE idEstudiante = ".$idEstudiante."
                        AND idAcudiente = ".$idAcudiente."");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){

            return false;

        } else {

            return true;

        }
        
    }
    
    
}
