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
                        <h3>Registro Estudiantil</h3>
                        <span class="input-group-btn">
                        <?php if ($this->MRecurso->validaRecurso(3)){ /*Agregar Curso*/ ?>
                            <a class="btn btn-success btn-curso" href="#"><i class="glyphicon glyphicon-plus"></i> Agregar Curso</a>
                        <?php } ?>
                        <?php if ($this->MRecurso->validaRecurso(5)){ /*Agregar Jornada*/ ?>
                            <a class="btn btn-success btn-jornada" href="#"><i class="glyphicon glyphicon-plus"></i> Agregar Jornada</a>
                        <?php } ?>
                        </span>
                        <br />
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <?php if ($this->MRecurso->validaRecurso(4)){ /*Agregar Estudiante*/ ?>
                                <span class="input-group-btn">
                                    <a class="btn btn-success btn-estudiante" href="#"><i class="glyphicon glyphicon-plus"></i> Agregar Estudiante</a>
                                </span>
                                <?php } ?>
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
                                <th>Tipo Documento</th>
                                <th>ID Estudiante</th>
                                <th>Estudiante</th>
                                <th>Curso</th>
                                <th>Jornada</th>
                                <th>Calendario</th>
                                <th>Activo</th>
                                <th>Acción</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($list_estudiante != FALSE) {
                                        foreach ($list_estudiante as $row_list) {
                                            ?>
                                            <tr style="background-color: #FFFFFF;">
                                                <td class="center green"><?php echo $row_list['descTipoDocumento']; ?></td>
                                                <td class="center blue"><?php echo $row_list['idEstudiante']; ?></td>
                                                <td class="center blue"><?php echo $row_list['nombres'] . " " . $row_list['apellidos']; ?></td>
                                                <td class="center blue"><?php echo $row_list['descCurso']; ?></td>
                                                <td class="center blue"><?php echo $row_list['descJornada']; ?></td>
                                                <td class="center blue"><?php echo $row_list['descCalendario']; ?></td>
                                                <td class="center">
                                                    <?php if ($row_list['activo'] == 'S') { ?>
                                                        <span class="label label-success">Activo</span>
                                                    <?php } else { ?>
                                                        <span class="label label-danger">Inactivo</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="center">
                                                    <?php if ($this->MRecurso->validaRecurso(7) || $this->MRecurso->validaRecurso(6)) { /* Ver/Editar Estudiante */ ?>
                                                        <a class="btn btn-info btn-sm" href="<?php echo base_url() . 'index.php/CEstudiante/getestudiante/' . $row_list['idEstudiante']; ?>">
                                                            <i class="glyphicon glyphicon-eye-open"></i>
                                                            Ver
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
                
                    
                <!--<div class="row">-->
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Cursos</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>-->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table id="" class="table table-responsive">
                                    <thead>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Fecha Registro</th>
                                        <th>Accion</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($list_cursos != FALSE){
                                            foreach ($list_cursos as $row_list_curso){
                                                ?>
                                                <tr style="background-color: #FFFFFF;">
                                                    <td class="small green"><?php echo $row_list_curso['idCurso']; ?></td>
                                                    <td class="big blue"><?php echo $row_list_curso['descCurso']; ?></td>
                                                    <td class="small"><?php echo $row_list_curso['fechaRegistra']; ?></td>
                                                    <td class="center">
                                                        <!--<a href="#" >
                                                            <span class="label label-success">Editar</span>
                                                        </a>-->
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
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Jornadas</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>-->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table id="" class="table table-responsive">
                                    <thead>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Fecha Registro</th>
                                        <th>Accion</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($list_jornadas != FALSE){
                                            foreach ($list_jornadas as $row_list_jornada){
                                                ?>
                                                <tr style="background-color: #FFFFFF;">
                                                    <td class="small green"><?php echo $row_list_jornada['idJornada']; ?></td>
                                                    <td class="big blue"><?php echo $row_list_jornada['descJornada']; ?></td>
                                                    <td class="small"><?php echo $row_list_jornada['fechaRegistra']; ?></td>
                                                    <td class="center">
                                                        <!--<a href="#" >
                                                            <span class="label label-success">Editar</span>
                                                        </a>-->
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
        
        <!--Modal - Agregar Estudiante-->
        <div class="modal fade" id="myModal-est" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-est" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_estudiante" action="<?php echo base_url() . 'index.php/CEstudiante/addestudiante'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Nuevo Estudiante</h3> 
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="identificacion">Identificación del Estudiante</label>
                                <select class="form-control" name="tipo_doc">
                                   <?php
                                    foreach ($list_documento as $row_doc) {
                                        ?>
                                        <option value="<?php echo $row_doc['idTipoDocumento']; ?>"><?php echo $row_doc['descTipoDocumento']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <input type="tel" class="form-control" id="id_estudiante" name="id_estudiante" placeholder="Nro del Documento" required="" pattern="\d*">
                            </div>
                            <div class="form-group">
                                <label for="nombre_est">Nombres y Apellidos</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nombre_est" name="nombre_est" placeholder="Nombres" required="">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="apellido_est" name="apellido_est" placeholder="Apellidos" required="">
                            </div>
                            <div class="form-group">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                <input type="text" name="fechanace" required="" class="form-control has-feedback-left" id="single_cal1" value="<?php echo $fechaIni; ?>" placeholder="Fecha Nacimiento" aria-describedby="inputSuccess2Status" readonly="">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                            </div>
                            <div class="form-group">
                                <label for="eps">Seguro de Salud</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="eps_estudiante" name="eps_estudiante" placeholder="Nombre de la Entidad" required="">
                            </div>
                            <div class="form-group">
                                <label for="rh">Tipo de Sangre</label>
                                <select class="form-control" name="tipo_rh">
                                   <option value="O+">O+</option>
                                   <option value="O-">O-</option>
                                   <option value="A+">A+</option>
                                   <option value="A-">A-</option>
                                   <option value="B+">B+</option>
                                   <option value="B-">B-</option>
                                   <option value="AB+">AB+</option>
                                   <option value="AB-">AB-</option>
                                </select>
                            </div>
                            <div class="form-group">                                
                                <label for="fecha_ingresa">Fecha de Ingreso</label>
                                <input type="text" name="fechaingresa" required="" class="form-control has-feedback-left" id="single_cal4" value="<?php echo date("Y-m-d"); ?>" placeholder="Fecha Ingreso" aria-describedby="inputSuccess2Status" readonly="">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status" class="sr-only">(success)</span>
                            </div>
                            <div class="form-group">
                                <label for="curso">Curso</label>
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
                                <label for="calendario">Calendario</label>
                                <select class="form-control" name="calendario">
                                   <?php
                                    foreach ($list_calendario as $row_cal) {
                                        ?>
                                        <option value="<?php echo $row_cal['idTipoCalendario']; ?>"><?php echo $row_cal['descCalendario']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <hr />
                            <h3>Datos del Acudiente</h3>
                            <div class="form-group">
                                <label for="identificacionAcu">Identificación Acudiente</label>
                                <select class="form-control" name="tipo_doc_acu">
                                   <?php
                                    foreach ($list_documento as $row_doc) {
                                        ?>
                                        <option value="<?php echo $row_doc['idTipoDocumento']; ?>"><?php echo $row_doc['descTipoDocumento']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <input type="tel" class="form-control" id="id_acudiente" name="id_acudiente" placeholder="Nro del Documento" required="" pattern="\d*">
                            </div>
                            <div class="form-group">
                                <label for="nombre_acu">Nombres y Apellidos</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nombre_acu" name="nombre_acu" placeholder="Nombres" required="">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="apellido_acu" name="apellido_acu" placeholder="Apellidos" required="">
                            </div>
                            <div class="form-group">
                                <label for="parentesco">Parentesco</label>
                                <select class="form-control" name="parentesco">
                                   <option value="PADRE">PADRE</option>
                                   <option value="MADRE">MADRE</option>
                                   <option value="HERMANO">HERMANO</option>
                                   <option value="TIO">TIO</option>
                                   <option value="ABUELO">ABUELO</option>
                                   <option value="PRIMO">PRIMO</option>
                                   <option value="OTRO">OTRO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="contacto">Información de Contacto</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="dir_acu" name="dir_acu" placeholder="Direccion" required="">
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="tel_acu" name="tel_acu" placeholder="Telefono" required="">
                                <input type="email" class="form-control" id="mail_acu" name="mail_acu" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                            </div>
                            <hr />
                            <h3>Documentación del Estudiante</h3>
                            <?php
                            /*Lista todos los Requisitos*/
                            foreach ($list_requisitos as $requisito){
                                ?>
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" class="flat" name="<?php echo $requisito['idDocumento']; ?>" >
                                      <?php echo $requisito['descDocumento']; ?>
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
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
        
        <!--Modal - Agregar Curso-->
        <div class="modal fade" id="myModal-curso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-curso" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_curso" action="<?php echo base_url().'index.php/CEstudiante/addcurso'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Curso</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre_curso">Nombre del Curso</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="curso_safic" name="curso_safic" placeholder="Descripción" maxlength="50" required="" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/Modal-->
        
        <!--Modal - Agregar Jornada-->
        <div class="modal fade" id="myModal-jornada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-jorn" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_jornada" action="<?php echo base_url().'index.php/CEstudiante/addjornada'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Jornada</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre_jornada">Nombre de Jornada</label>
                                <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="jornada_safic" name="jornada_safic" placeholder="Descripción" maxlength="50" required="" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                            <button type="submit" class="btn btn-success">Agregar</button>
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
