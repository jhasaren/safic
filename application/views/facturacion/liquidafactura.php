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
                        <h3>Liquidar Factura</h3>
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
                        <?php if ($this->session->tempdata('message')) { ?>
                            <div class="alert alert-info" id="success-alert">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Hecho! </strong> <?php echo $this->session->tempdata('message'); ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->tempdata('messageError')) { ?>
                            <div class="alert alert-warning" id="success-alert">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Fallo! </strong> <?php echo $this->session->tempdata('messageError'); ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->tempdata('messageArray')) { ?>
                            <div class="alert alert-warning" id="success-alert">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>Algo salio mal, por favor informe al administrador.</strong>
                            </div>
                        <?php } ?>
                        <!--/Alerta-->
                    </div>
                </div>
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Lista de Estudiantes</h2>
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
                                    <th>ID Estudiante</th>
                                    <th>Estudiante</th>
                                    <th>Curso</th>
                                    <th>Jornada</th>
                                    <th>Calendario</th>
                                    <th>Ultima Factura</th>
                                    <th>Activo</th>
                                    <th>Acción</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($list_estudiante != FALSE){
                                        foreach ($list_estudiante as $row_list){
                                            ?>
                                            <tr style="background-color: #FFFFFF;">
                                                <td class="center blue"><?php echo $row_list['descTipoDocumento'].". ".$row_list['idEstudiante']; ?></td>
                                                <td class="center blue"><?php echo $row_list['nombres']." ".$row_list['apellidos']; ?></td>
                                                <td class="center blue"><?php echo $row_list['descCurso']; ?></td>
                                                <td class="center blue"><?php echo $row_list['descJornada']; ?></td>
                                                <td class="center blue"><?php echo $row_list['descCalendario']; ?></td>
                                                <td class="center green">-</td>
                                                <td class="center">
                                                    <?php if ($this->MRecurso->validaRecurso(12)){ /*Liquidar*/ ?>
                                                    <a class="btn btn-info btn-sm btn-liqfac" href="#" data-rel="<?php echo $row_list['idEstudiante']; ?>" data-rel2="<?php echo $row_list['idCurso']; ?>" data-rel3="<?php echo $row_list['idJornada']; ?>" data-rel4="<?php echo $row_list['descCalendario']; ?>" >
                                                        <i class="glyphicon glyphicon-eye-open"></i>
                                                        Liquidar
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                                <td class="center">
                                                    <?php if ($this->MRecurso->validaRecurso(12)){ /*Estado de Cuenta*/ ?>
                                                    <a class="btn btn-info btn-sm" href="<?php echo base_url().'index.php/CFacturacion/estadocuenta/'.$row_list['idEstudiante'].'/0'; ?>">
                                                        <i class="glyphicon glyphicon-eye-open"></i>
                                                        Estado de Cuenta
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
        <!-- /page content -->
        
         <!--Modal - Liquidar Factura-->
        <div class="modal fade" id="myModal-liq" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-liq" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_liquidar" action="<?php echo base_url() . 'index.php/CFacturacion/regliquidafactura'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Liquidar Factura</h3> 
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="codigo_estudiante">Código Estudiante:</label>
                                <input type="text" class="form-control" id="idest_liq" name="idest_liq" required="" readonly="" >
                                <input type="hidden" class="form-control" id="idcur_liq" name="idcur_liq" >
                                <input type="hidden" class="form-control" id="idjor_liq" name="idjor_liq" >
                                <input type="hidden" class="form-control" id="idcal_liq" name="idcal_liq" >
                                <br />
                                <?php 
                                $fecha = strtotime('+1 month', strtotime(date('Y-m-d')));
                                $fechaSugerida = date('m',$fecha );
                                ?>
                                <label for="periodo">Periodo a Facturar:</label>
                                <select class="form-control" name="mes_factura">
                                    <option value="1" <?php if ($fechaSugerida == 1){ echo "selected"; } ?>>Enero</option>
                                    <option value="2" <?php if ($fechaSugerida == 2){ echo "selected"; } ?>>Febrero</option>
                                    <option value="3" <?php if ($fechaSugerida == 3){ echo "selected"; } ?>>Marzo</option>
                                    <option value="4" <?php if ($fechaSugerida == 4){ echo "selected"; } ?>>Abril</option>
                                    <option value="5" <?php if ($fechaSugerida == 5){ echo "selected"; } ?>>Mayo</option>
                                    <option value="6" <?php if ($fechaSugerida == 6){ echo "selected"; } ?>>Junio</option>
                                    <option value="7" <?php if ($fechaSugerida == 7){ echo "selected"; } ?>>Julio</option>
                                    <option value="8" <?php if ($fechaSugerida == 8){ echo "selected"; } ?>>Agosto</option>
                                    <option value="9" <?php if ($fechaSugerida == 9){ echo "selected"; } ?>>Septiembre</option>
                                    <option value="10" <?php if ($fechaSugerida == 10){ echo "selected"; } ?>>Octubre</option>
                                    <option value="11" <?php if ($fechaSugerida == 11){ echo "selected"; } ?>>Noviembre</option>
                                    <option value="12" <?php if ($fechaSugerida == 12){ echo "selected"; } ?>>Diciembre</option>
                                </select>
                                <select class="form-control" name="ano_factura">
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="plazo">Pago Hasta:</label>
                                <select class="form-control" id="plazo_pago" name="plazo_pago">
                                    <option value="1">PLAZOS DEL SISTEMA</option>
                                    <option value="2">FECHA FIJA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fecha_limite">Fecha Limite de Pago:</label>
                                <input type="text" name="fecha_limite" class="form-control has-feedback-left" id="single_cal1" value="<?php echo date('Y-m-d'); ?>" placeholder="" aria-describedby="inputSuccess2Status" readonly="">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                            </div>
                            <div class="form-group">
                            <fieldset>
                                <legend>Conceptos a Incluir:</legend>
                                <?php
                                if ($list_tarfijas != FALSE){
                                    foreach ($list_tarfijas as $tarfija){
                                        ?>
                                        <div class="checkbox">
                                            <label>
                                              <input type="checkbox" class="flat" name="tarfija_<?php echo $tarfija['idTarifa']; ?>" >
                                              <?php echo $tarfija['descTarifa']; ?>                                                              
                                            </label>
                                        </div> 
                                        <?php
                                    }
                                }
                                ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="flat" name="adicionales" checked="" >
                                        TODAS LAS CUENTAS POR COBRAR REGISTRADAS                                                              
                                    </label>
                                </div> 
                            </fieldset>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Liquidar</button>
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
