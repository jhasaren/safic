<?php
/**************************************************************************
* Nombre de la Clase: MFacturacion
* Descripcion: Es el Modelo para las interacciones en BD del modulo Facturacion
* Autor: jhonalexander90@gmail.com
* Fecha Creacion: 23/10/2018
**************************************************************************/

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MFacturacion extends CI_Model {

    public function __construct() {
        
        /*instancia la clase de conexion a la BD para este modelo*/
        parent::__construct();
        $this->load->driver('cache'); /*Carga cache*/
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: list_tipo_tarifa
     * Descripcion: Obtiene los tipos de tarifa creados en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_tipo_tarifa() {
                
        /*Recupera los tipos de doc creados*/
        $query = $this->db->query("SELECT
                                    idTarifa,
                                    descTarifa,
                                    fija,
                                    activo,
                                    valorTipoTarifa
                                    FROM tipo_tarifa
                                    ORDER BY 2");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: list_param_tarifa
     * Descripcion: Obtiene la parametrizacin de tarifas fijas
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_param_tarifa() {
                
        /*Recupera los tipos de doc creados*/
        $query = $this->db->query("SELECT
                                t.idRegistro,
                                t.idTarifa,
                                a.descTarifa,
                                t.idCurso,
                                c.descCurso,
                                t.idJornada,
                                j.descJornada,
                                t.valorTarifa,
                                t.activo
                                FROM tarifas_parametro t
                                JOIN tipo_tarifa a ON a.idTarifa = t.idTarifa
                                JOIN curso c ON c.idCurso = t.idCurso
                                JOIN jornada j ON j.idJornada = t.idJornada");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: list_tarifa_fija
     * Descripcion: Obtiene los tipos de tarifa fijas del sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_tarifa_fija() {
                
        /*Recupera los tipos de doc creados*/
        $query = $this->db->query("SELECT
                                    idTarifa,
                                    descTarifa
                                    FROM tipo_tarifa
                                    WHERE activo = 'S'
                                    AND fija = 'S'
                                    ORDER BY 2");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: list_tarifa_adc
     * Descripcion: Obtiene los tipos de tarifa adicionales del sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_tarifa_adc() {
                
        /*Recupera los tipos de tarifas adicionales creadas*/
        $query = $this->db->query("SELECT
                                    idTarifa,
                                    descTarifa,
                                    valorTipoTarifa
                                    FROM tipo_tarifa
                                    WHERE activo = 'S'
                                    AND fija = 'N'
                                    ORDER BY descTarifa");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_tipo_tarifa
     * Descripcion: regitra un nuevo tipo tarifa en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_tipo_tarifa($tarifaFija,$descTarifa,$valorTipoTarifa) {
        
        if ($tarifaFija == 'S'){
            $valorTipoTarifa = -1;
        }
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                tipo_tarifa (
                                descTarifa, 
                                fija, 
                                valorTipoTarifa,
                                activo, 
                                fechaRegistro, 
                                idUsuarioRegistra
                                )
                                VALUES (
                                '".$descTarifa."',
                                '".$tarifaFija."',
                                ".$valorTipoTarifa.",
                                'S',
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
     * Nombre del Metodo: registra_tarifa_fija
     * Descripcion: regitra la param. de tarifa fija en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_tarifa_fija($idCurso,$idJornada,$idTarifaFija,$valorTarifaFija) {
        
        /*Verifica si ya existe la relacion entre idTarifa y curso/jornada*/
        $queryValida = $this->db->query("SELECT
                                        idRegistro
                                        FROM tarifas_parametro t
                                        WHERE
                                        idTarifa = ".$idTarifaFija."
                                        AND idCurso = ".$idCurso."
                                        AND idJornada = ".$idJornada."");
        
        if ($queryValida->num_rows() == 0) {
            $sql = "INSERT INTO
                    tarifas_parametro ( 
                    idTarifa, 
                    idCurso, 
                    idJornada, 
                    valorTarifa, 
                    fechaRegistro, 
                    activo, 
                    idUsuarioRegistra
                    )
                    VALUES (
                    ".$idTarifaFija.",
                    ".$idCurso.",
                    ".$idJornada.",
                    ".$valorTarifaFija.",
                    NOW(),
                    'S',
                    ".$this->session->userdata('userid')."
                    )";
        } else {
            $sql = "UPDATE tarifas_parametro SET 
                    valorTarifa = ".$valorTarifaFija."
                    WHERE
                    idTarifa = ".$idTarifaFija."
                    AND idCurso = ".$idCurso."
                    AND idJornada = ".$idJornada."";
        }
        
        $this->db->trans_start();
        $this->db->query($sql);
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_resolucion
     * Descripcion: registra una resolucion de recibos en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_resolucion($resolucion,$reciboIni,$reciboFin) {
        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        $this->db->query("INSERT INTO
                        resolucion_recibo ( 
                        descResolucion, 
                        rangoInicial, 
                        rangoFinal, 
                        fechaRegistra, 
                        idUsuarioRegistra,
                        activo
                        )
                        VALUES (
                        '".$resolucion."',
                        ".$reciboIni.",
                        ".$reciboFin.",
                        NOW(),
                        ".$this->session->userdata('userid').",
                        'S'
                        )");
        $idRes = $this->db->insert_id();
                
        for($i=$reciboIni;$i<=$reciboFin;$i++){
            
            $verify = $this->db->query("SELECT nroRecibo
                                        FROM rango_recibos
                                        WHERE nroRecibo = ".$i."");
            
            $cant = $verify->num_rows();
            
            if($cant > 0){
                
                return FALSE;

            } else {

                $this->db->query("INSERT INTO
                                rango_recibos (
                                nroRecibo,
                                consumido,
                                idResolucion
                                ) VALUES (
                                ".$i.",
                                'N',
                                ".$idRes."
                                )");

            }
            
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
     * Nombre del Metodo: list_resoluciones
     * Descripcion: Obtiene las resoluciones creadas en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 23/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_resoluciones() {
                
        /*Recupera las resoluciones de recibos creadas*/
        $query = $this->db->query("SELECT
                                    r.idResolucion,
                                    r.descResolucion,
                                    r.rangoInicial,
                                    r.rangoFinal,
                                    r.activo,
                                    r.fechaRegistra,
                                    (select count(1) from rango_recibos WHERE idResolucion = r.idResolucion) as totalRecibos,
                                    (select count(1) from rango_recibos WHERE idResolucion = r.idResolucion and consumido = 'S') as recibosConsume
                                    FROM resolucion_recibo r");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_factura
     * Descripcion: registra el registro inicial de la factura
     * Autor: jhonalexander90@gmail.com
     * Estados Factura:
     *      1 - CUENTA X COBRAR
     *      2 - LIQUIDADO
     * Fecha Creacion: 24/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_factura($idEstudiante,$curso,$jornada,$estado) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                factura_maestro (
                                nroRecibo, 
                                idEstudiante, 
                                idCurso, 
                                idJornada,
                                idEstado,
                                idSede
                                )
                                VALUES (
                                0,
                                ".$idEstudiante.",
                                ".$curso.",
                                ".$jornada.",
                                ".$estado.",
                                ".$this->session->userdata('sede')."   
                                )");
        $idFactura = $this->db->insert_id();
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return $idFactura;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_factura_detalle
     * Descripcion: registra el detalle de una factura
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_factura_detalle($factura,$idTarifa,$descTarifa,$valorTarifa,$cantidadTarifa) {
        
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO
                                factura_detalle (
                                nroFactura, 
                                idTarifa, 
                                descTarifa, 
                                valorTarifa,
                                cantidad,
                                fechaRegistra,
                                idUsuarioRegistra
                                )
                                VALUES (
                                ".$factura.",
                                ".$idTarifa.",
                                '".$descTarifa."',
                                ".$valorTarifa.",
                                ".$cantidadTarifa.",
                                NOW(),
                                ".$this->session->userdata('userid')."
                                )");
        $idFactura = $this->db->insert_id();
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return $idFactura;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: get_tarifa
     * Descripcion: Obtiene los datos de una tarifa del sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function get_tarifa($idTarifa) {
                
        /*Recupera el detalle de una tarifa*/
        $query = $this->db->query("SELECT
                                t.idTarifa,
                                t.descTarifa,
                                t.fija,
                                t.valorTipoTarifa,
                                t.activo,
                                t.fechaRegistro,
                                t.idUsuarioRegistra
                                FROM tipo_tarifa t
                                WHERE idTarifa = ".$idTarifa."");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->row();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: actualiza_tarifa
     * Descripcion: permite actualizar los datos de una tarifa en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 24/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function actualiza_tarifa($idTarifa,$nombreTarifa,$valorTarifa,$estadoTarifa) {
        
        if ($estadoTarifa == 'on'){
            $activo = 'S';
        } else {
            $activo = 'N';
        }
        
        $this->db->trans_start();
        $this->db->query("UPDATE tipo_tarifa SET 
                        descTarifa = '".$nombreTarifa."',
                        valorTipoTarifa = ".$valorTarifa.",
                        activo = '".$activo."'
                        WHERE
                        idTarifa = ".$idTarifa."");
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: getvalor_tarifafija
     * Descripcion: Obtiene el valor de una tarifa fija parametrizada
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 26/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function getvalor_tarifafija($idTarifa,$idCurso,$idJornada) {
                
        /*Recupera valor de tarifa fija parametrizada*/
        $query = $this->db->query("SELECT
                                t.idRegistro,
                                t.valorTarifa,
                                c.descTarifa
                                FROM tarifas_parametro t
                                JOIN tipo_tarifa c ON c.idTarifa = t.idTarifa
                                WHERE t.activo = 'S'
                                AND t.idTarifa = ".$idTarifa."
                                AND t.idCurso = ".$idCurso."
                                AND t.idJornada = ".$idJornada."");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->row();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: get_recibo
     * Descripcion: permite obtener un numero de recibo disponible
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function get_recibo() {
        
        /*Recupera nro de recibo*/
        $query = $this->db->query("SELECT
                                r.nroRecibo
                                FROM rango_recibos r
                                JOIN resolucion_recibo p ON p.idResolucion = r.idResolucion AND p.activo = 'S'
                                WHERE consumido = 'N'
                                ORDER BY r.nroRecibo ASC
                                LIMIT 1");
        
        if ($query->num_rows() == 0) {

            return false;

        } else {

            $dataRecibo = $query->row();
            
            $this->db->trans_strict(TRUE);
            $this->db->trans_start();
            $this->db->query("UPDATE rango_recibos SET
                            consumido = 'S'
                            WHERE nroRecibo = ".$dataRecibo->nroRecibo."");
            $this->db->trans_complete();
            $this->db->trans_off();
            
            if ($this->db->trans_status() === FALSE){
            
                return false;
            
            } else {

                return $dataRecibo->nroRecibo;

            }

        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: liquida_tarifa
     * Descripcion: permite registrar el recibo a una tarifa y  cambiar su estado
     *      $tipo:
     *      S - fijas
     *      N - adicionales
     * 
     *      $consulta:
     *      S - solo consulta
     *      N - liquidacion
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function liquida_tarifa($idEstudiante,$anoFactura,$mesFactura,$nroRecibo,$tipo, $consulta) {
        
        /*Recupera nro de recibo*/
        $query = $this->db->query("SELECT
                                f.nroFactura,
                                f.nroRecibo,
                                f.idEstado,
                                f.idEstudiante,
                                d.idTarifa,
                                d.descTarifa,
                                d.valorTarifa,
                                d.cantidad,
                                p.fija,
                                f.mesFacturado,
                                f.anoFacturado
                                FROM factura_maestro f
                                JOIN factura_detalle d ON d.nroFactura = f.nroFactura
                                JOIN tipo_tarifa p ON p.idTarifa = d.idTarifa
                                WHERE f.idEstudiante = ".$idEstudiante."
                                AND f.idEstado = 1
                                AND p.fija = '".$tipo."'");
        
        if ($query->num_rows() == 0) {

            return false;

        } else {
            
            $dataLiquida = $query->result_array();
            
            if ($consulta == 'N'){
            
                $this->db->trans_strict(TRUE);
                $this->db->trans_start();
                foreach ($dataLiquida as $row_list){

                   $this->db->query("UPDATE factura_maestro SET
                                    nroRecibo = ".$nroRecibo.",
                                    idEstado = 2,
                                    idUsuarioFactura = ".$this->session->userdata('userid').",
                                    fechaLiquida = NOW(),
                                    mesFacturado = ".$mesFactura.",
                                    anoFacturado = ".$anoFactura."
                                    WHERE
                                    nroFactura = ".$row_list['nroFactura'].""); 

                }
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
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: recibos_liquidados_est
     * Descripcion: Recupera los recibos liquidados de un estudiante
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function recibos_liquidados_est($idEstudiante) {
                
        /*Recupera lista recibos liquidados por estudiante*/
        $query = $this->db->query("SELECT
                                f.nroRecibo,
                                f.mesFacturado,
                                f.anoFacturado,
                                SUM(d.valorTarifa * d.cantidad) as total,
                                f.fechaLiquida
                                FROM factura_maestro f
                                JOIN factura_detalle d ON d.nroFactura = f.nroFactura
                                WHERE f.idEstudiante = ".$idEstudiante."
                                AND f.idEstado = 2
                                GROUP BY f.nroRecibo,f.mesFacturado,f.anoFacturado");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: informacion_recibo_maestro
     * Descripcion: Recupera la informacion maestro de un recibo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function informacion_recibo_maestro($idEstudiante,$idRecibo) {
                
        /*Recupera los datos del recibo*/
        $queryMaestro = $this->db->query("SELECT
                                    DISTINCT
                                    f.nroRecibo,
                                    d.descTipoDocumento,
                                    f.idEstudiante,
                                    concat(e.nombres,' ',e.apellidos) as nombre_estudiante,
                                    f.idCurso,
                                    c.descCurso,
                                    f.idJornada,
                                    j.descJornada,
                                    f.idEstado,
                                    f.fechaLiquida,
                                    f.mesFacturado,
                                    f.anoFacturado
                                    FROM
                                    factura_maestro f
                                    JOIN estudiante_maestro e ON e.idEstudiante = f.idEstudiante
                                    JOIN tipo_documento d ON d.idTipoDocumento = e.idTipoDocumento
                                    JOIN curso c ON c.idCurso = f.idCurso
                                    JOIN jornada j ON j.idJornada = f.idJornada
                                    WHERE f.idEstudiante = ".$idEstudiante."
                                    AND f.nroRecibo = ".$idRecibo."");

        if ($queryMaestro->num_rows() == 0) {

            return false;

        } else {

            return $queryMaestro->row();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: informacion_recibo_detalle
     * Descripcion: Recupera la informacion detalle de un recibo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function informacion_recibo_detalle($idEstudiante,$idRecibo) {
                
        /*Recupera los datos del recibo*/
        $queryMaestro = $this->db->query("SELECT
                                        f.idDetalleRegistro,
                                        f.idTarifa,
                                        f.descTarifa,
                                        f.valorTarifa,
                                        sum(f.cantidad) as cantidad,
                                        sum(f.valorTarifa*f.cantidad) as totalTarifa
                                        FROM factura_detalle f
                                        JOIN factura_maestro e ON e.nroFactura = f.nroFactura
                                        WHERE
                                        e.nroRecibo = ".$idRecibo."
                                        AND e.idEstudiante = ".$idEstudiante."
                                        GROUP BY idTarifa
                                        ORDER BY f.idTarifa");

        if ($queryMaestro->num_rows() == 0) {

            return false;

        } else {

            return $queryMaestro->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: informacion_recibo_plazos
     * Descripcion: Recupera la informacion de plazos de un recibo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function informacion_recibo_plazos($idRecibo) {
                
        /*Recupera los plazos del recibo*/
        $queryMaestro = $this->db->query("SELECT
                                        p.nroRecibo,
                                        DATE_FORMAT(p.fechaPlazo,'%d/%m/%Y') as fecha_plazo,
                                        p.valorCobro
                                        FROM plazo_pago p
                                        WHERE 
                                        p.nroRecibo = ".$idRecibo."
                                        AND p.activo = 'S'
                                        ORDER BY secuencia");

        if ($queryMaestro->num_rows() == 0) {

            return false;

        } else {

            return $queryMaestro->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_plazo_pago
     * Descripcion: permite registrar los plazos de pago para un recibo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_plazo_pago($recibo,$fecha) {
        
        $fechaTime = strtotime('+1 month', strtotime($fecha));
        $fechaSugerida = date('Y-m-d',$fechaTime); /*fecha del siguiente mes*/

        $fecha1_time = strtotime('+3 day', strtotime($fechaSugerida));
        $fechaReg[1] = date('Y-m-d',$fecha1_time); /*plazo1 - hasta el 04*/
        $valorCobro[1] = -5000;

        $fecha2_time = strtotime('+5 day', strtotime($fechaSugerida));
        $fechaReg[2] = date('Y-m-d',$fecha2_time); /*plazo2 - hasta el 06*/
        $valorCobro[2] = 0;

        $fecha3_time = strtotime('+11 day', strtotime($fechaSugerida));
        $fechaReg[3] = date('Y-m-d',$fecha3_time); /*plazo3 - hasta el 12*/
        $valorCobro[3] = 5000;

        $fecha4_time = strtotime('+15 day', strtotime($fechaSugerida));
        $fechaReg[4] = date('Y-m-d',$fecha4_time); /*plazo4 - hasta el 16*/
        $valorCobro[4] = 10000;
                
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();
        
        for($i=1; $i<=4; $i++){
            
            $this->db->query("INSERT INTO plazo_pago (
                            nroRecibo, 
                            fechaPlazo, 
                            secuencia, 
                            activo,
                            valorCobro
                            ) VALUES (
                            ".$recibo.",
                            '".$fechaReg[$i]." 23:59:59',
                            ".$i.",
                            'S',
                            '".$valorCobro[$i]."')");
            
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
     * Nombre del Metodo: list_recibos_liquidados
     * Descripcion: Recupera todos recibos liquidados en el sistema
     * $estadoRecibo
     *      1 - CUENTA X PAGAR
     *      2 - LIQUIDADO
     *      3 - PAGADO
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_recibos_liquidados($estadoRecibo) {
                
        /*Recupera lista recibos liquidados*/
        $query = $this->db->query("SELECT
                                f.nroRecibo,
                                f.mesFacturado,
                                f.anoFacturado,
                                SUM(d.valorTarifa * d.cantidad) as total,
                                f.fechaLiquida,
                                f.idUsuarioFactura,
                                t.descTipoDocumento,
                                f.idEstudiante,
                                e.nombres,
                                e.apellidos,
                                f.idCurso,
                                s.descCurso,
                                f.idJornada,
                                j.descJornada
                                FROM factura_maestro f
                                JOIN factura_detalle d ON d.nroFactura = f.nroFactura
                                JOIN estudiante_maestro e ON e.idEstudiante = f.idEstudiante
                                JOIN tipo_documento t ON t.idTipoDocumento = e.idTipoDocumento
                                JOIN curso s ON s.idCurso = f.idCurso
                                JOIN jornada j ON j.idJornada = f.idJornada
                                WHERE f.idEstado = ".$estadoRecibo."
                                GROUP BY f.nroRecibo,f.mesFacturado,f.anoFacturado");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: list_formas_pago
     * Descripcion: Recupera las formas de pago
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 28/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function list_formas_pago() {
                
        /*Recupera las formas de pago*/
        $query = $this->db->query("SELECT
                                t.idFormaPago,
                                t.descFormaPago
                                FROM tipo_forma_pago t
                                WHERE activo = 'S'");

        if ($query->num_rows() == 0) {

            return false;

        } else {

            return $query->result_array();

        }

    }
    
    /**************************************************************************
     * Nombre del Metodo: registra_pago
     * Descripcion: permite registrar el pago de un recibo
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function registra_pago($recibo,$valorRecaudo,$tipoFormaPago,$referenciaBanco) {
                        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();     
        
        /*inserta la forma de pago*/
        $this->db->query("INSERT INTO forma_de_pago (
                        nroRecibo, 
                        valorPago, 
                        idFormaPago, 
                        fechaAplicaPago, 
                        usuarioAplicaPago, 
                        referenciaBanco
                        ) VALUES (
                        ".$recibo.",
                        ".$valorRecaudo.",
                        ".$tipoFormaPago.",
                        NOW(),
                        ".$this->session->userdata('userid').",
                        '".$referenciaBanco."')");
        
        /*Cambia de estado el recibo*/
        $this->db->query("UPDATE factura_maestro
                        SET idEstado = 3
                        WHERE nroRecibo = ".$recibo."");
        
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**************************************************************************
     * Nombre del Metodo: anula_recibo
     * Descripcion: permite registrar la anulacion de un recibo en el sistema
     * Autor: jhonalexander90@gmail.com
     * Fecha Creacion: 29/10/2018, Ultima modificacion: 
     **************************************************************************/
    public function anula_recibo($estudiante,$recibo,$motivo) {
                        
        $this->db->trans_strict(TRUE);
        $this->db->trans_start();     
        
        /*Cambia de estado el recibo*/
        $this->db->query("UPDATE factura_maestro
                        SET idEstado = 4,
                        nota = '".$motivo."',
                        fechaAnula = NOW(),
                        idUsuarioAnula = ".$this->session->userdata('userid')."
                        WHERE nroRecibo = ".$recibo."
                        AND idEstudiante = ".$estudiante."");
        
        $this->db->trans_complete();
        $this->db->trans_off();

        if ($this->db->trans_status() === FALSE){
            
            return false;
            
        } else {
            
            return true;
            
        }
        
    }
    
}
