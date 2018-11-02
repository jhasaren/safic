<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Centro Educativo, Facturacion, Administracion, Control">
    <meta name="author" content="Amadeus Soluciones">

    <title>SAFIC</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url().'public/gentelella/vendors/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url().'public/gentelella/vendors/nprogress/nprogress.css'; ?>" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url().'public/gentelella/build/css/custom.min.css'; ?>" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css'; ?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url().'public/gentelella/vendors/iCheck/skins/flat/green.css'; ?>" rel="stylesheet">
    
    <!-- Datatables -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" rel="stylesheet">
    
    <!-- Datatables Buttons -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'; ?>" rel="stylesheet">
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
    
    <style>
    @media (min-width: 768px){
        .col-sm-6 {
            width: 50%;
        }
    }
    </style>
    
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
            <?php 
            /*include*/
            $this->load->view('includes/menu');
            ?>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <?php 
            /*include*/
            $this->load->view('includes/top');
            ?>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Estado de Cuenta</h3>
                        <span class="input-group-btn">
                        </span>
                        <br />
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!--Alerta-->
                        <?php if ($alert == 1){ ?>
                            <div class="alert alert-info alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <?php echo $message; ?>
                            </div>
                        <?php } else if ($alert == 2){ ?>
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <!--/Alerta-->
                                   
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Detalle Factura</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>-->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                
                                <center>
                                <form role="form" name="form_recibos_liq" action="<?php echo base_url().'index.php/CFacturacion/detallerecibo'; ?>" method="post">
                                    <div class="modal-body">
                                        <fieldset>
                                            <div class="col-md-5 xdisplay_inputx form-group has-feedback">
                                            <input type="hidden" class="form-control" id="id_estudiante" name="id_estudiante" value="<?php echo $id_estudiante; ?>" >
                                            <select class="form-control" name="recibo" >
                                                    <?php
                                                     foreach ($list_recibos as $row_rec) {
                                                         ?>
                                                         <option value="<?php echo $row_rec['nroRecibo']; ?>"><?php echo "Recibo: ".$row_rec['nroRecibo']." | Periodo: ".$row_rec['anoFacturado']."".$row_rec['mesFacturado']." | Valor: $".$row_rec['total']; ?></option>
                                                         <?php
                                                     }
                                                     ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 xdisplay_inputx form-group has-feedback" style="text-align: left">
                                                <button type="submit" class="btn btn-success">Consultar</button>
                                            </div>
                                        </fieldset>
                                    </div>
                                </form>
                                </center>
                                <hr>
                                
                                <?php
                                if ($this->session->tempdata('vistarecibo')){
                                ?>
                                <!--inicia Formato Factura-->
                                <div id="ticketPrint" class="container">
                                    <!--tabla-->
                                    <center>
                                    <table border="0" style="border-collapse: collapse; width: 830px;" cellspacing="0" cellpadding="0"><colgroup><col style="width: 69pt;" width="92" /> <col span="4" style="width: 60pt;" width="80" /> <col style="width: 63pt;" width="84" /> <col span="3" style="width: 60pt;" width="80" /> <col style="width: 71pt;" width="94" /> </colgroup>
                                        <tbody>
                                            <tr style="height: 15pt; color: #000">
                                                <td colspan="7" rowspan="3" class="xl65" style="height: 45pt; width: 432pt; font-size: 20px" width="576" height="60">JARDIN MATERNO INFANTIL '<?php echo strtoupper($this->config->item('namebussines')); ?>'<br /> <B><?php echo strtoupper($this->config->item('idbussines')); ?></B></td>
                                                <td colspan="3" rowspan="3" class="xl66" style="width: 191pt; text-align: center;" width="254"><span class="font6">Recibo de Pago</span><span class="font5"><br /> </span><span class="font7" style="font-size: 26px; font-weight: bold"><?php echo $data['dataGeneral']['maestro']->nroRecibo; ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <table border="0" style="border-collapse: collapse; width: 830px;" cellspacing="0" cellpadding="0"><colgroup><col style="width: 69pt;" width="92" /> <col span="4" style="width: 60pt;" width="80" /> <col style="width: 63pt;" width="84" /> <col span="3" style="width: 60pt;" width="80" /> <col style="width: 71pt;" width="94" /> </colgroup>
                                        <tbody>
                                            <tr style="height: 15pt;">
                                                <td colspan="4" rowspan="3" class="xl65" style="height: 45pt; width: 249pt;" width="332" height="60">
                                                    <B>ALUMNO:</B><br />
                                                    <?php echo $data['dataGeneral']['maestro']->nombre_estudiante; ?><br /> 
                                                    <B>COD. ESTUDIANTE:</B><br /> 
                                                    <span style="color: #0000FF; font-size: 16px; font-weight: bold"><?php echo $data['dataGeneral']['maestro']->descTipoDocumento." ".$data['dataGeneral']['maestro']->idEstudiante; ?></span><br />
                                                </td>
                                                <td colspan="3" rowspan="3" class="xl65" style="width: 183pt;" width="244">
                                                    <B>CURSO:</B> <?php echo $data['dataGeneral']['maestro']->descCurso; ?><br />
                                                    <B>JORNADA:</B> <?php echo $data['dataGeneral']['maestro']->descJornada; ?><br />
                                                    <B>CALENDARIO:</B> <?php echo $data['dataGeneral']['calendarioEst']->descCalendario; ?>
                                                </td>
                                                <td colspan="3" rowspan="3" class="xl65" style="width: 191pt; text-align: right" width="254">
                                                    <B>Periodo Facturado:</B> <?php echo $data['dataGeneral']['maestro']->anoFacturado."".$data['dataGeneral']['maestro']->mesFacturado; ?><br />
                                                    <B>Fecha Liquida:</B> <?php echo $data['dataGeneral']['maestro']->fechaLiquida; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <table border="0" style="border-collapse: collapse; width: 830px;" cellspacing="0" cellpadding="0"><colgroup><col style="width: 69pt;" width="92" /> <col span="4" style="width: 60pt;" width="80" /> <col style="width: 63pt;" width="84" /> <col span="3" style="width: 60pt;" width="80" /> <col style="width: 71pt;" width="94" /> </colgroup>
                                        <tbody>
                                            <tr style="height: 15pt;">
                                                <td colspan="10" class="xl65" style="height: 15pt; width: 623pt; text-align: center; font-size: 18px; color: #000" width="830" height="20">BANCO AV VILLAS - Cuenta Corriente: <B>#229-00056-7</B><br /><br /></td>
                                            </tr>
                                            <tr style="height: 15pt; border-top-width: 0.5px; border-top: solid; border-color: #999999;">
                                                <td class="xl66" style="height: 15pt; text-align: left; font-weight: bold" height="20">CID</td>
                                                <td colspan="4" class="xl67" style="border-left: none; text-align: left; font-weight: bold">DESCRIPCION CONCEPTO</td>
                                                <td class="xl66" style="border-top: none; border-left: none; text-align: center; font-weight: bold">CANTIDAD</td>
                                                <td colspan="2" class="xl67" style="border-left: none; text-align: center; font-weight: bold">VALOR UNITARIO</td>
                                                <td colspan="2" class="xl67" style="border-left: none; text-align: center; font-weight: bold">TOTAL</td>
                                            </tr>
                                            <?php
                                            if ($data['dataGeneral']['detalle'] != FALSE){
                                                foreach ($data['dataGeneral']['detalle'] as $row_detalle){
                                                    ?>
                                                    <tr style="height: 18pt;">
                                                        <td class="xl68" style="height: 18pt; border-top: none;" height="24"><?php echo $row_detalle['idTarifa']; ?></td>
                                                        <td colspan="4" class="xl69" style="border-left: none;"><?php echo $row_detalle['descTarifa']; ?></td>
                                                        <td class="xl69" style="border-top: none; border-left: none; text-align: center;"><?php echo $row_detalle['cantidad']; ?></td>
                                                        <td colspan="2" class="xl70" style="border-left: none; text-align: center;">$<?php echo number_format($row_detalle['valorTarifa'],0,',','.'); ?></td>
                                                        <td colspan="2" class="xl70" style="border-left: none; text-align: center;">$<?php echo number_format($row_detalle['totalTarifa'],0,',','.'); ?></td>
                                                    </tr>
                                                    <?php
                                                    $totalPagar = $totalPagar + $row_detalle['totalTarifa'];
                                                }
                                            }
                                            ?>
                                            <tr style="height: 18pt;">
                                                <td class="xl68" style="height: 18pt; border-top: none;" height="24">&nbsp;</td>
                                                <td colspan="4" class="xl69" style="border-left: none;">&nbsp;</td>
                                                <td class="xl69" style="border-top: none; border-left: none;">&nbsp;</td>
                                                <td colspan="2" class="xl70" style="border-left: none;">&nbsp;</td>
                                                <td colspan="2" class="xl70" style="border-left: none; text-align: center;">&nbsp;</td>
                                            </tr>
                                            <tr style="height: 18pt; border-top: solid; border-color: #999999;">
                                                <td colspan="8" class="xl71" style="height: 18pt; text-align: right;" height="24">TOTAL A PAGAR</td>
                                                <td colspan="2" class="xl72" style="border-left: none; text-align: center;">$<?php echo number_format($totalPagar,0,',','.'); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p>&nbsp;</p>
                                    <table border="0" style="border-collapse: collapse; width: 830px;" cellspacing="0" cellpadding="0"><colgroup><col style="width: 69pt;" width="92" /> <col span="4" style="width: 60pt;" width="80" /> <col style="width: 63pt;" width="84" /> <col span="3" style="width: 60pt;" width="80" /> <col style="width: 71pt;" width="94" /> </colgroup>
                                        <tbody>
                                            <tr style="height: 15.75pt;">
                                                <td colspan="6" rowspan="5" class="xl65" style="height: 121.5pt; width: 372pt;" width="496" height="162">
                                                    <B>Importante:</B>
                                                    <p style="text-align: justify">
                                                        El pago se deberá realizar en cualquier sucursal del <B>BANCO AV VILLAS</B>. Si extravía este documento 
                                                        se debera acercar nuevamente a la sede de la institución para reliquidar la factura y esta tendrá un costo adicional de Papeleria. Recuerde
                                                        realizar el pago dentro de las fechas establecidas.
                                                    </p>
                                                </td>
                                                <td colspan="3" class="xl66" style="width: 180pt; text-align: center; font-size: 20px; color: #002166; font-weight: bold" width="240">Fechas de Pago</td>
                                                <td class="xl67" style="width: 71pt; text-align: left; font-size: 20px" width="94"></td>
                                            </tr>
                                            <?php
                                            if ($data['dataGeneral']['plazos'] != FALSE){
                                                $i = 0;
                                                foreach ($data['dataGeneral']['plazos'] as $row_plazos){
                                                    switch ($i) {
                                                        case 0:
                                                            $color="#66cc00";
                                                            break;
                                                        case 1:
                                                            $color= "#ff6600";
                                                            break;
                                                        case 2:
                                                            $color="#e2bc25";
                                                            break;
                                                        case 3:
                                                            $color="#ff0000";
                                                            break;
                                                    }
                                                    ?>
                                                    <tr style="height: 15.75pt; color: <?php echo $color; ?>">
                                                        <td colspan="3" class="xl66" style="height: 15.75pt; width: 180pt; text-align: center; font-size: 20px" width="240" height="21">Pagar Hasta: <?php echo $row_plazos['fecha_plazo']; ?></td>
                                                        <td class="xl67" style="width: 71pt; text-align: left; font-size: 20px" width="94">$<?php echo number_format($totalPagar+($row_plazos['valorCobro']),0,',','.'); ?></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                            <tr style="height: 15pt;">
                                                <td colspan="3" class="xl66" style="height: 15pt; width: 180pt; text-align: center;" width="240" height="20"></td>
                                                <td class="xl67" style="width: 71pt; text-align: left;" width="94"></td>
                                            </tr>
                                            <tr style="height: 15pt;">
                                                <td colspan="3" class="xl66" style="height: 15pt; width: 180pt; text-align: center;" width="240" height="20"></td>
                                                <td class="xl67" style="width: 71pt; text-align: left;" width="94"></td>
                                            </tr>
<!--                                            <tr style="height: 15pt;">
                                                <td colspan="3" class="xl66" style="height: 15pt; width: 180pt; text-align: center;" width="240" height="20"></td>
                                                <td class="xl67" style="width: 71pt; text-align: left;" width="94"></td>
                                            </tr>-->
<!--                                            <tr style="height: 15pt;">
                                                <td colspan="3" class="xl66" style="height: 15pt; width: 180pt; text-align: center;" width="240" height="20"></td>
                                                <td class="xl67" style="width: 71pt; text-align: left;" width="94"></td>
                                            </tr>-->
                                        </tbody>
                                    </table>
                                    <?php echo $data['dataGeneral']['resolucion']->descResolucion." Numeración ".$data['dataGeneral']['resolucion']->rangoInicial." hasta ".$data['dataGeneral']['resolucion']->rangoFinal; ?><br />
                                    Recibo de pago generado por <B>SAFIC SOFTWARE</B> &COPY;
                                    </center>
                                    <!--tabla-->  
                                    <br />
                                </div>
                            </div>
                            <!--Fin Formato Factura-->
                            
                            <center>
                            <p class="center-block download-buttons">
                                <input id="btnprint" class="btn btn-success btn-lg" type="button" value="Imprimir" onclick="PrintElem('#ticketPrint')" />
                                <a href="<?php echo base_url().'index.php/CFacturacion/liquidafactura'; ?>" class="btn btn-info btn-lg">
                                    <i class="glyphicon glyphicon-repeat glyphicon-white"></i> Regresar
                                </a>
                            </p>
                            </center>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
                
        <!-- footer content -->
        <?php 
        /*include*/
        $this->load->view('includes/footer-bar');
        ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url().'public/gentelella/vendors/jquery/dist/jquery.min.js'; ?>"></script>
    
    <!--Impresion factura-->
    <script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var myWindow = window.open('', 'Factura', 'height=400,width=600');
        myWindow.document.write('<html><head><title>Ticket de Venta</title>');
        myWindow.document.write('</head><body >');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');
        myWindow.document.close(); //necessary for IE >= 10
        
        myWindow.focus(); //necessary for IE >= 10
        myWindow.print();
        myWindow.close();
    }    
        
    //Lanzamos la llamada al evento click
    /*$(document).ready(function () {
            console.log("Imprimir Ticket");
            $("#btnprint").click();
    });*/
    
    </script>
    <!--Fin impresion ticket-->
    
    <!-- Bootstrap -->
    <script src="<?php echo base_url().'public/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js'; ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url().'public/gentelella/vendors/fastclick/lib/fastclick.js'; ?>"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url().'public/gentelella/vendors/nprogress/nprogress.js'; ?>"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url().'public/gentelella/build/js/custom.js'; ?>"></script><!--Minificar--> 
    
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url().'public/gentelella/vendors/moment/min/moment.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js'; ?>"></script>
    
    <!-- iCheck -->
    <script src="<?php echo base_url().'public/gentelella/vendors/iCheck/icheck.min.js'; ?>"></script>
    
    <!-- Datatables -->
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
    
    <!-- Datatables Buttons -->
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js'; ?>"></script>
        
  </body>
</html>
