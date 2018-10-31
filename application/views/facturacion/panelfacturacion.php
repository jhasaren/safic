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
                        <h3>Control de Facturación</h3>
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
                    <div class="col-md-2 col-sm-12 col-xs-12"></div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
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
                                <h2>Panel Principal</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>-->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php if ($this->MRecurso->validaRecurso(11)){ /*Registrar cxc*/ ?>
                                <a class="btn btn-primary btn-lg btn-block btn-estudiante" href="#">Registrar Cuenta por Cobrar</a><br />
                                <?php } ?>
                                <?php if ($this->MRecurso->validaRecurso(12)){ /*Liquida factura*/ ?>
                                <a class="btn btn-primary btn-lg btn-block" href="<?php echo base_url().'index.php/CFacturacion/liquidafactura'; ?>">Liquidar Factura</a><br />
                                <?php } ?>
                                <?php if ($this->MRecurso->validaRecurso(12)){ /*Aplicar Pagos*/ ?>
                                <a class="btn btn-primary btn-lg btn-block" href="<?php echo base_url().'index.php/CFacturacion/aplicarpago'; ?>">Aplicar Pagos</a><br />
                                <?php } ?>
                                <?php if ($this->MRecurso->validaRecurso(10)){ /*Resolucion Recibos*/ ?>
                                <a class="btn btn-primary btn-lg btn-block" href="<?php echo base_url().'index.php/CFacturacion/resolrecibos'; ?>">Resolución de Recibos</a><br />
                                <?php } ?>
                                <?php if ($this->MRecurso->validaRecurso(9)){ /*Parametrizar Tarifa*/ ?>
                                <a class="btn btn-primary btn-lg btn-block" href="<?php echo base_url().'index.php/CFacturacion/parametrizatarifa'; ?>">Parametrizar Tarifas</a><br />
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12"></div>
                </div>
            </div>
        </div>
        <!-- /page content -->
        
         <!--Modal - Agregar Cuenta x Cobrar-->
        <div class="modal fade" id="myModal-est" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-est" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" id="form_regcxc" name="form_regcxc" action="<?php echo base_url() . 'index.php/CFacturacion/regcuentacobrar'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Registrar Cuenta x Cobrar</h3> 
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="idestudiante">Seleccione el Estudiante</label>
                                <input type="text" class="form-control" id="dataestudiante" name="dataestudiante" placeholder="Escriba todo o parte del nombre" required="" >
                            </div>
                            <br />
                            <div class="form-group">
                            <fieldset>
                                <legend>Tarifas Adicionales:</legend>
                                
                                <table style="width: 90%">
                                    <thead>
                                        <th></th>
                                        <th><center>Valor</center></th>
                                        <th><center>Cantidad</center></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($list_tar_adicionales != FALSE){
                                            foreach ($list_tar_adicionales as $tarifaadc){
                                                ?>
                                                <tr style="background-color: #FFFFFF;">
                                                    <td class="big green">
                                                        <div class="checkbox">
                                                            <label>
                                                              <input type="checkbox" class="flat" name="<?php echo $tarifaadc['idTarifa']; ?>" >
                                                              <?php echo $tarifaadc['descTarifa']; ?>                                                              
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="big blue">
                                                        <center>
                                                            <label>
                                                              $<?php echo number_format($tarifaadc['valorTipoTarifa'],0,',','.'); ?>                                                             
                                                            </label>
                                                        </center>
                                                    </td>
                                                    <td class="center">
                                                        <center>
                                                            <label>
                                                                <input type="number" class="form-control" id="cantidad_<?php echo $tarifaadc['idTarifa']; ?>" name="cantidad_<?php echo $tarifaadc['idTarifa']; ?>" placeholder="" required="" style="width: 80px" value="1" pattern="\d*">                                                             
                                                            </label>
                                                        </center>    
                                                    </td>                                                    
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </fieldset>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Registrar</button>
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
    
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url().'public/gentelella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js'; ?>"></script>
    <script>
    var estudiantes = [
        <?php foreach ($list_estudiante as $row_estud) { ?>
            { value: '<?php echo $row_estud['idEstudiante']." | ".$row_estud['nombres'].' '.$row_estud['apellidos']." | ".$row_estud['descCurso']; ?>' },
        <?php } ?>
    ];
    $('#dataestudiante').autocomplete({
        lookup: estudiantes
    });
    </script>
        
  </body>
</html>
