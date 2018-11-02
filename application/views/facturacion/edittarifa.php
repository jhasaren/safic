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
    <!-- Datatables -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" rel="stylesheet">
    
    <!-- iCheck -->
    <link href="<?php echo base_url().'public/gentelella/vendors/iCheck/skins/flat/green.css'; ?>" rel="stylesheet">
    
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
                        <h3>Parametrizar Tarifas</h3>
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
                            <div class="x_content">
                                <!--Formulario-->
                                <form role="form" name="form_edit_tarifa" action="<?php echo base_url() . 'index.php/CFacturacion/updtarifa'; ?>" method="post" autocomplete="off">
                                    <div class="modal-body">
                                        <div class="x_title">
                                            <h2 style="color: green">Detalle de Tarifa</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="id_tarifa">ID</label>
                                            <input type="tel" class="form-control" id="id_tarifa" name="id_tarifa" required="" value="<?php echo $data_tarifa->idTarifa; ?>" readonly="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre_tarifa">Concepto</label>
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nombre_tarifa" name="nombre_tarifa" placeholder="Concepto" value="<?php echo $data_tarifa->descTarifa; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <?php 
                                            if ($data_tarifa->fija == 'S'){
                                                $readonly = "readonly";
                                            } else {
                                                $readonly = "";
                                            }
                                            ?>
                                            <label for="valor_tarifa">Valor $</label>
                                            <input type="number" class="form-control" id="val_tarifa" name="val_tarifa" placeholder="Valor" value="<?php echo $data_tarifa->valorTipoTarifa; ?>" required="" <?php echo $readonly; ?> >
                                        </div>
                                        <div class="form-group">
                                            <label for="tarifa_fija">Fija</label>
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="tarifa_fija" name="tarifa_fija" placeholder="Fija" value="<?php echo $data_tarifa->fija; ?>" readonly="">
                                        </div>
                                        <div class="form-group">                                
                                            <label for="fecha_ingresa">Fecha de Creación</label>
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="fecha_ingresa" name="fecha_ingresa" placeholder="Fija" value="<?php echo $data_tarifa->fechaRegistro; ?>" readonly="">
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="usuario_ingresa" name="usuario_ingresa" placeholder="Usuario Ingresa" value="<?php echo $data_tarifa->idUsuarioRegistra; ?>" readonly="">
                                        </div>
                                        <div class="">
                                            <?php
                                            if ($data_tarifa->activo == 'S') {
                                                $check = 'checked';
                                            } else {
                                                $check = '';
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" class="flat" name="estado_tarifa" <?php echo $check; ?> >
                                                Activo
                                            </label>
                                        </div>
                                        <div class="">
                                            <?php
                                            if ($data_tarifa->incrementoCalendario == 'S') {
                                                $check2 = 'checked';
                                            } else {
                                                $check2 = '';
                                            }
                                            
                                            if ($data_tarifa->fija == 'N'){
                                                $disabled = 'disabled';
                                            } else {
                                                $disabled = '';
                                            }
                                            ?>
                                            <label>
                                                <input type="checkbox" class="flat" name="incrementoCalendarioA" <?php echo $check2; ?> <?php echo $disabled; ?> >
                                                Incremento Calendario A
                                            </label>
                                        </div>
                                        <br />                                        
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo base_url() . 'index.php/CFacturacion/parametrizatarifa'; ?>" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                                        <?php
                                        if ($this->MRecurso->validaRecurso(9)){ /*permiso de editar*/
                                        ?>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <?php } ?>
                                    </div>
                                </form>
                                <!--/Formulario-->
                            </div>
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
    
  </body>
</html>