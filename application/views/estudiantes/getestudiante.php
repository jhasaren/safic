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
                        <h3>Registro Estudiantil</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <div></div>
                                <?php if ($this->MRecurso->validaRecurso(8)){ /*Agregar Acudiente*/ ?>
                                <span class="input-group-btn">
                                    <a class="btn btn-info btn-acudiente" href="#"><i class="glyphicon glyphicon-plus"></i> Agregar Acudiente</a>
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
                        
                        <div class="x_panel">
                            <div class="x_content">
                                <!--Formulario-->
                                <form role="form" name="form_edit_estudiante" action="<?php echo base_url() . 'index.php/CEstudiante/updestudiante'; ?>" method="post" autocomplete="off">
                                    <div class="modal-body">
                                        <div class="x_title">
                                            <h2 style="color: green">Información del Estudiante</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <!--<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>-->
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="identificacion">Identificación del Estudiante</label>
                                            <select class="form-control" name="tipo_doc">
                                               <?php
                                                foreach ($list_documento as $row_doc) {
                                                    ?>
                                                    <option value="<?php echo $row_doc['idTipoDocumento']; ?>" <?php if ($dataEstudiante->idTipoDocumento == $row_doc['idTipoDocumento']){ echo "selected"; } ?> ><?php echo $row_doc['descTipoDocumento']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <input type="tel" class="form-control" id="id_estudiante" name="id_estudiante" placeholder="Nro del Documento" required="" value="<?php echo $dataEstudiante->idEstudiante; ?>" pattern="\d*" readonly="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre_est">Nombres y Apellidos</label>
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="nombre_est" name="nombre_est" placeholder="Nombres" value="<?php echo $dataEstudiante->nombres; ?>" required="">
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="apellido_est" name="apellido_est" placeholder="Apellidos" value="<?php echo $dataEstudiante->apellidos; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                            <input type="text" name="fechanace" required="" class="form-control has-feedback-left" id="single_cal1" value="<?php echo $dataEstudiante->fechaNacimiento; ?>" placeholder="Fecha Nacimiento" aria-describedby="inputSuccess2Status" readonly="">
                                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="eps">Seguro de Salud</label>
                                            <input type="text" class="form-control" onblur="this.value = this.value.toUpperCase()" id="eps_estudiante" name="eps_estudiante" placeholder="Nombre de la Entidad" value="<?php echo $dataEstudiante->entidadSalud; ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label for="rh">Tipo de Sangre</label>
                                            <select class="form-control" name="tipo_rh">
                                               <option value="O+" <?php if ($dataEstudiante->tipoSangreRH == 'O+'){ echo "selected"; } ?>>O+</option>
                                               <option value="O-" <?php if ($dataEstudiante->tipoSangreRH == 'O-'){ echo "selected"; } ?>>O-</option>
                                               <option value="A+" <?php if ($dataEstudiante->tipoSangreRH == 'A+'){ echo "selected"; } ?>>A+</option>
                                               <option value="A-" <?php if ($dataEstudiante->tipoSangreRH == 'A-'){ echo "selected"; } ?>>A-</option>
                                               <option value="B+" <?php if ($dataEstudiante->tipoSangreRH == 'B+'){ echo "selected"; } ?>>B+</option>
                                               <option value="B-" <?php if ($dataEstudiante->tipoSangreRH == 'B-'){ echo "selected"; } ?>>B-</option>
                                               <option value="AB+" <?php if ($dataEstudiante->tipoSangreRH == 'AB+'){ echo "selected"; } ?>>AB+</option>
                                               <option value="AB-" <?php if ($dataEstudiante->tipoSangreRH == 'AB-'){ echo "selected"; } ?>>AB-</option>
                                            </select>
                                        </div>
                                        <div class="form-group">                                
                                            <label for="fecha_ingresa">Fecha de Ingreso</label>
                                            <input type="text" name="fechaingresa" required="" class="form-control has-feedback-left" id="single_cal4" value="<?php echo $dataEstudiante->fechaIngreso; ?>" placeholder="Fecha Ingreso" aria-describedby="inputSuccess2Status" readonly="">
                                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="curso">Curso</label>
                                            <select class="form-control" name="curso">
                                               <?php
                                                foreach ($list_cursos as $row_cur) {
                                                    ?>
                                                    <option value="<?php echo $row_cur['idCurso']; ?>" <?php if ($dataEstudiante->idCurso == $row_cur['idCurso']){ echo "selected"; } ?> ><?php echo $row_cur['descCurso']; ?></option>
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
                                                    <option value="<?php echo $row_jor['idJornada']; ?>" <?php if ($dataEstudiante->idJornada == $row_jor['idJornada']){ echo "selected"; } ?> ><?php echo $row_jor['descJornada']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="">
                                            <?php
                                            if ($dataEstudiante->activo == 'S') {
                                                $check = 'checked';
                                            } else {
                                                $check = '';
                                            }
                                            ?>
                                            <label>
                                                Activo
                                              <input type="checkbox" class="flat" name="estado" <?php echo $check; ?> >
                                            </label>
                                        </div>
                                        
                                        <br /><br />
                                        
                                        <div class="x_title">
                                            <h2 style="color: green">Datos del Acudiente</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_panel">
                                            <div class="x_content">
                                                <table id="" class="table table-responsive">
                                                    <thead>
                                                        <th>Identificación</th>
                                                        <th>Acudiente</th>
                                                        <th>Contacto</th>
                                                        <th>Parentesco</th>
                                                        <th>Acción</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($list_acudientes != FALSE){
                                                            foreach ($list_acudientes as $row_list_acu){
                                                                ?>
                                                                <tr style="background-color: #FFFFFF;">
                                                                    <td class="big green"><?php echo $row_list_acu['descTipoDocumento'].". ".$row_list_acu['idAcudiente']; ?></td>
                                                                    <td class="big blue"><?php echo $row_list_acu['nombres']." ".$row_list_acu['apellidos']; ?></td>
                                                                    <td class="small"><?php echo "Dir: ".$row_list_acu['direccion']."<br />Tel: ".$row_list_acu['telefono']."<br />".$row_list_acu['email']; ?></td>
                                                                    <td class="big blue"><?php echo $row_list_acu['parentesco']; ?></td>
                                                                    <td class="center">
                                                                        <a href="<?php echo base_url().'index.php/CPrincipal/dataedit/gastos/'.$row_list['idGasto']; ?>" >
                                                                            <span class="label label-success">Editar</span>
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
                                        
                                        <br /><br />
                                        
                                        <div class="x_title">
                                            <h2 style="color: green">Documentación del Estudiante</h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php
                                        /*recupera los requisitos del estudiante y agrega los ID a un array*/
                                        $i = 0;
                                        if ($documentos_estudiante != FALSE){
                                            foreach ($documentos_estudiante as $req_est){
                                                $dataReqEst[$i] = $req_est['idDocumento'];
                                                $i++;
                                            }
                                        }
                                        
                                        /*Lista todos los Requisitos*/
                                        foreach ($list_requisitos as $requisito){
                                            if (in_array($requisito['idDocumento'], $dataReqEst)){
                                                $check = "checked";                                                
                                            } else {
                                                $check = "";
                                            }
                                            ?>
                                            <div class="checkbox">
                                                <label>
                                                  <input type="checkbox" class="flat" name="<?php echo $requisito['idDocumento']; ?>" <?php echo $check; ?> >
                                                  <?php echo $requisito['descDocumento']; ?>
                                                </label>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <a href="<?php echo base_url() . 'index.php/CEstudiante'; ?>" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                                        <?php
                                        if ($this->MRecurso->validaRecurso(6)){ /*permiso de editar*/
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
        
        <!--Modal - Agregar Acudiente-->
        <div class="modal fade" id="myModal-acud" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-acud" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form role="form" name="form_acudiente" action="<?php echo base_url() . 'index.php/CEstudiante/addacudiente'; ?>" method="post" autocomplete="off">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3>Agregar Acudiente</h3> 
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="identificacionAcu">Estudiante</label><br />
                                <?php echo $dataEstudiante->descTipoDocumento.". ".$dataEstudiante->idEstudiante; ?> - 
                                <?php echo $dataEstudiante->nombres." ".$dataEstudiante->apellidos; ?>
                                <input type="hidden" id="id_estudiante" name="id_estudiante" value="<?php echo $dataEstudiante->idEstudiante; ?>">
                            </div>
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
                                <input type="text" class="form-control" id="mail_acu" name="mail_acu" placeholder="Email" >
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
    
  </body>
</html>