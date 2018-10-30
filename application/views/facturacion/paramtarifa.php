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
                        <h3>Parametrizar Tarifas</h3>
                        <span class="input-group-btn">
                            <a class="btn btn-success btn-tarfija" href="#"><i class="glyphicon glyphicon-plus"></i> Param. Tarifa Fija</a>
                        </span>
                        <br />
                    </div>
                    
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <span class="input-group-btn">
                                    <a class="btn btn-success btn-estudiante" href="#"><i class="glyphicon glyphicon-plus"></i> Crear Tipo Tarifa</a>
                                </span>
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
                    </div>
                </div>
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Tarifas Fijas</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <th>ID</th>
                                    <th>Tarifa Fija</th>
                                    <th>Curso</th>
                                    <th>Jornada</th>
                                    <th>Valor$</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($list_param_tar != FALSE){
                                        foreach ($list_param_tar as $row_list){
                                            ?>
                                            <tr style="background-color: #FFFFFF;">
                                                <td class="center green"><?php echo $row_list['idRegistro']; ?></td>
                                                <td class="center green"><?php echo $row_list['descTarifa']; ?></td>
                                                <td class="center blue"><?php echo $row_list['descCurso']; ?></td>
                                                <td class="center blue"><?php echo $row_list['descJornada']; ?></td>
                                                <td class="center blue">$<?php echo number_format($row_list['valorTarifa'],0,',','.'); ?></td>
                                                <td class="center">
                                                    <?php if ($row_list['activo'] == 'S') { ?>
                                                    <span class="label label-success">Activo</span>
                                                    <?php } else { ?>
                                                    <span class="label label-danger">Inactivo</span>
                                                    <?php }?>
                                                </td>
                                                <td class="center">
                                                    <a href="#" >
                                                        <span class="label label-info">Editar</span>
                                                    </a>
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
                
<!--                <div class="row">-->
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Tipo Tarifa</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table id="datatable" class="table table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Fija</th>
                                        <th>Valor $</th>
                                        <th>Activo</th>
                                        <th>Accion</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($list_tipo_tarifa != FALSE){
                                            foreach ($list_tipo_tarifa as $row_list_tar){
                                                ?>
                                                <tr style="background-color: #FFFFFF;">
                                                    <td class="small green"><?php echo $row_list_tar['idTarifa']; ?></td>
                                                    <td class="big blue"><?php echo $row_list_tar['descTarifa']; ?></td>
                                                    <td class="small"><?php echo $row_list_tar['fija']; ?></td>
                                                    <?php if ($row_list_tar['valorTipoTarifa'] < 0){ ?>
                                                    <td class="small">-</td>
                                                    <?php } else { ?>
                                                    <td class="small">$<?php echo number_format($row_list_tar['valorTipoTarifa'],0,',','.'); ?></td>
                                                    <?php } ?>
                                                    <td class="small"><?php echo $row_list_tar['activo']; ?></td>
                                                    <td class="center">
                                                        <a href="<?php echo base_url().'index.php/CFacturacion/edittarifa/'.$row_list_tar['idTarifa']; ?>" >
                                                            <span class="label label-info">Editar</span>
                                                        </a>
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
                <!--</div>-->
                
            </div>
        </div>
        <!-- /page content -->
        
        <!--Modal - Agregar Tipo Tarifa-->
        <div class="modal fade" id="myModal-est" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-est" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_tarifa" action="<?php echo base_url() . 'index.php/CFacturacion/addtipotarifa'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Crear Tipo Tarifa</h3> 
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tipo_tarifa">Tipo</label>
                                <select class="form-control" id="tipo_tarifa" name="tipo_tarifa">
                                   <option value="S">FIJA</option>
                                   <option value="N">ADICIONAL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nombre_tarifa">Concepto</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nombre_tarifa" name="nombre_tarifa" placeholder="Nombre de la Tarifa" required="">
                            </div>
                            <div class="form-group">
                                <label for="valor_tarifa">Valor Tarifa</label>
                                <input type="number" class="form-control" id="valor_tarifa" name="valor_tarifa" placeholder="Valor en Pesos $" required="">
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
        
        <!--Modal - Parametrizar Tarifa Fija-->
        <div class="modal fade" id="myModal-tar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-tar" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_tarifa_fija" action="<?php echo base_url() . 'index.php/CFacturacion/addtarifafija'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Parametrizar Tarifa Fija</h3> 
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="Curso">Curso</label>
                                <select class="form-control" name="curso">
                                   <?php
                                    foreach ($list_cursos as $row_cur) {
                                        ?>
                                        <option value="<?php echo $row_cur['idCurso']; ?>"><?php echo $row_cur['descCurso']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jornada">Jornada</label>
                                <select class="form-control" name="jornada">
                                   <?php
                                    foreach ($list_jornadas as $row_jor) {
                                        ?>
                                        <option value="<?php echo $row_jor['idJornada']; ?>"><?php echo $row_jor['descJornada']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tarifa_fija">Tarifa Fija</label>
                                <select class="form-control" name="tarifa_fija">
                                   <?php
                                    if ($list_tarfijas != FALSE){
                                         foreach ($list_tarfijas as $row_tarfi) {
                                             ?>
                                             <option value="<?php echo $row_tarfi['idTarifa']; ?>"><?php echo $row_tarfi['descTarifa']; ?></option>
                                             <?php
                                         }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="valor_tarifa">Valor Tarifa</label>
                                <input type="number" class="form-control" id="valor_tarfija" name="valor_tarfija" placeholder="Valor en Pesos $" required="">
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
        
  </body>
</html>
