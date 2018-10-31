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
                        <h3>Aplicar Pagos</h3>
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
                        <?php if ($this->session->tempdata('message')){ ?>
                        <div class="alert alert-info" id="success-alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Hecho! </strong> <?php echo $this->session->tempdata('message'); ?>
                        </div>
                        <?php } ?>
                        <?php if ($this->session->tempdata('messageError')){ ?>
                        <div class="alert alert-warning" id="success-alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Fallo! </strong> <?php echo $this->session->tempdata('messageError'); ?>
                        </div>
                        <?php } ?>
                        <!--/Alerta-->
                        
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Recibos Liquidados</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>-->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <th>Cod Estudiante</th>
                                        <th>Estudiante</th>
                                        <th>Curso</th>
                                        <th>Jornada</th>
                                        <th>Nro Recibo</th>
                                        <th>Periodo</th>
                                        <th>Total</th>
                                        <th>Fecha Liquida</th>
                                        <th>Accion</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($list_liquidados != FALSE){
                                            foreach ($list_liquidados as $row_rec){
                                                ?>
                                                <tr style="background-color: #FFFFFF;">
                                                    <td class="center green"><?php echo $row_rec['descTipoDocumento']." ".$row_rec['idEstudiante']; ?></td>
                                                    <td class="green"><?php echo $row_rec['nombres']." ".$row_rec['apellidos']; ?></td>
                                                    <td class="small blue"><?php echo $row_rec['descCurso']; ?></td>
                                                    <td class="small blue"><?php echo $row_rec['descJornada']; ?></td>
                                                    <td class="center red"><B><?php echo $row_rec['nroRecibo']; ?></B></td>
                                                    <td class="center red"><?php echo $row_rec['anoFacturado']."".$row_rec['mesFacturado']; ?></td>
                                                    <td class="center red">$<?php echo number_format($row_rec['total'],0,',','.'); ?></td>
                                                    <td class="small blue"><?php echo $row_rec['fechaLiquida']."<br />Por: ".$row_rec['idUsuarioFactura']; ?></td>
                                                    <td class="center blue">
                                                        <?php if ($this->MRecurso->validaRecurso(14)){ /*Aplicar Pago*/ ?>
                                                        <a class="btn btn-success btn-sm btn-aplpago" href="#" data-rel="<?php echo $row_rec['nroRecibo']; ?>" data-rel2="<?php echo $row_rec['idEstudiante']; ?>" data-rel3="<?php echo $row_rec['total']; ?>" >
                                                            <i class="glyphicon glyphicon-check"></i>
                                                            Aplicar Pago
                                                        </a>
                                                        <?php } ?><br />
                                                        <?php if ($this->MRecurso->validaRecurso(15)){ /*Anular Recibo*/ ?>
                                                        <a class="btn btn-warning btn-sm btn-anlrecibo" href="#" data-rel="<?php echo $row_rec['nroRecibo']; ?>" data-rel2="<?php echo $row_rec['idEstudiante']; ?>" >
                                                            <i class="glyphicon glyphicon-warning-sign"></i>
                                                            Anular Recibo
                                                        </a>
                                                        <?php } ?><br />
                                                        <?php if ($this->MRecurso->validaRecurso(16)){ /*Ver Factura*/ ?>
                                                        <a class="btn btn-info btn-sm" href="<?php echo base_url().'index.php/CFacturacion/estadocuenta/'.$row_rec['idEstudiante'].'/0'; ?>" target="e_blank">
                                                            <i class="glyphicon glyphicon-eye-open"></i>
                                                            Ver Factura
                                                        </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Aplicar Pago-->
        <div class="modal fade" id="myModal-aplpago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-aplpago" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_aplpago" action="<?php echo base_url() . 'index.php/CFacturacion/registrapago'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Aplicar Pago</h3> 
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="codigo_estudiante">Código Estudiante:</label>
                                <input type="text" class="form-control" id="idestudianteapl" name="idestudianteapl" required="" readonly="" >
                                <br />
                                <label for="nro_recibo">Nro Recibo:</label>
                                <input type="text" class="form-control" id="idreciboapl" name="idreciboapl" required="" readonly="" >
                                <br />
                                <label for="valor_recaudo">Valor Recaudado $:</label>
                                <input type="text" class="form-control" id="valorrecaudo" name="valorrecaudo" required="" >
                                <input type="hidden" class="form-control" id="valorrecaudo_org" name="valorrecaudo_org" >
                                <br />
                                <label for="forma_pago">Forma de Pago:</label>
                                <select class="form-control" name="forma_pago">
                                    <?php
                                    if ($list_formas != FALSE){
                                        foreach ($list_formas as $row_forma){
                                            ?>
                                            <option value="<?php echo $row_forma['idFormaPago']; ?>" ><?php echo $row_forma['descFormaPago']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <br />
                                <label for="ref_banco">Referencia Banco:</label>
                                <input type="text" class="form-control" id="ref_banco" name="ref_banco" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Aplicar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/Modal-->
        
        <!--Modal - Anular Recibo-->
        <div class="modal fade" id="myModal-anlrecibo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-anlrecibo" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_anlrecibo" action="<?php echo base_url() . 'index.php/CFacturacion/anularrecibo'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Anular Recibo</h3> 
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="codigo_estudiante">Código Estudiante:</label>
                                <input type="text" class="form-control" id="idestudianteanl" name="idestudianteanl" required="" readonly="" >
                                <br />
                                <label for="nro_recibo">Nro Recibo:</label>
                                <input type="text" class="form-control" id="idreciboanl" name="idreciboanl" required="" readonly="" >
                                <br />
                                <label for="motivo_anula">Motivo de Anulación:</label>
                                <input type="text" style="height: 120px" class="form-control" id="motivoanula" name="motivoanula" required="" maxlength="250" >
                                <br />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Anular</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/Modal-->
                           
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
