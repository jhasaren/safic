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
    <!-- Datatables -->
    <link href="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'; ?>" rel="stylesheet">
    
    <style>
    /*Deshabilitar cajon de busqueda en Datatable*/
    .dataTables_filter, .dataTables_info { display: none; }
    </style>
    
    <link rel="shortcut icon" href="<?php echo base_url().'public/img/favicon.ico'; ?>">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed"> <!--menu_fixed-->
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
            
            <?php if ($this->session->userdata('perfil') == 'FACTURACION' || $this->session->userdata('perfil') == 'SUPERADMIN') { ?>
            <!-- top tiles -->
            <div class="row tile_count">
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Total Estudiantes</span>
                    <div class="count"><?php echo ($indicadores['estudiantes']->cantidadEstudiante); ?></div>
                    <span class="count_bottom"><i class="green"></i> Activos</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Cursos</span>
                    <div class="count green"><?php echo ($indicadores['cursos']->cantidadCursos); ?></div>
                    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>Registrados</i></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Jornadas</span>
                    <div class="count blue"><?php echo ($indicadores['jornadas']->cantidadJornadas); ?></div>
                    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>Registrados</i></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-clock-o"></i> Anulaciones</span>
                    <div class="count purple"><?php echo ($indicadores['anularecibo']->cantidadAnula); ?></div>
                    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>Recibos</i></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Cuentas x Cobrar</span>
                    <div class="count red"><?php echo ($indicadores['cuentascobrar']->cantidadcuentas); ?></div>
                    <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>$<?php echo number_format(($indicadores['valorcobrar']->valorCobrar),0,',','.'); ?></i></span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Liquidaciones</span>
                    <div class="count"><?php echo ($indicadores['liquidaciones']->cantidadLiquida); ?></div>
                    <span class="count_bottom"><i class="red"><i class="fa fa-sort-asc"></i>$<?php echo number_format(($indicadores['valorliquidaciones']->valorLiquidaciones),0,',','.'); ?></i></span>
                </div>
            </div>
            <!-- /top tiles -->
            <?php } ?>
            
            <div class="">

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
                                <!--Gastos Pendiente Pago-->
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="bs-example" data-example-id="simple-jumbotron">
                                            <div class="jumbotron">
                                                <!--<h1>Freya!</h1>-->
                                                <!--<p>Software para la Administración Integral de Restaurantes</p>-->
                                                <center>
                                                    <img alt="Safic" src="<?php echo base_url().'public/img/logo.png'; ?>" style="width: 300px" />
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Recordatorios</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                    </li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="alert alert-info alert-dismissible fade in" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                                    </button>
                                                    Facturación se debe realizar antes de pasar al siguiente mes. Ej: entre 25 y 31 de cada mes.
                                                </div>
                                                
                                                <div class="alert alert-success alert-dismissible fade in" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                                    </button>
                                                    Las tarifas fijas son del tipo compuesta ya que dependen del curso y jornada del estudiante. Ej. Matricula, Pension, Libros, Etc.
                                                </div>
                                                
                                                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                                    </button>
                                                    Los plazos para pago son: <br />
                                                    <B>Plazo 1</B> - Hasta el dia 4 de cada mes (Descuento $5.000)<br />
                                                    <B>Plazo 2</B> - Hasta el dia 6 de cada mes (Tarifa Plena sin recargos)<br />
                                                    <B>Plazo 3</B> - Hasta el dia 12 de cada mes (Recargo por $5.000)<br />
                                                    <B>Plazo 4</B> - Hasta el dia 16 de cada mes (Recargo por $10.000)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Fin Gastos Pendiente Pago-->
                                
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
    <!-- Datatables -->
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js'; ?>"></script>
    <script src="<?php echo base_url().'public/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js'; ?>"></script>
  </body>
</html>
