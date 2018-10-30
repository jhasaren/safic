<div class="nav_menu">
    <nav>
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url().'public/img/img.jpg'; ?>" alt="">
                    <?php echo $this->session->userdata('perfil'); ?>
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li>
                        <a href="#"> <?php echo $this->session->userdata('userid'); ?></a>
                    </li>
                    <li>
                        <a class="btn-changepass"  href="#">Cambiar Contraseña</a>
                    </li>
                <!--<li>
                        <a class="btn-backup"  href="#">Generar Backup</a>
                    </li>-->
<!--                    <li>
                        <a href="<?php // echo base_url().'index.php/CPrincipal/optimize'; ?>"><i class="fa fa-sign-out pull-right"></i> Optimizar BD</a>
                    </li>-->
                    <li>
                        <a class="btn-help"  href="#">Ayuda</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url().'index.php/CPrincipal/logout'; ?>"><i class="fa fa-sign-out pull-right"></i> Salir</a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
    
    <!--Modal - Cambiar Clave-->
    <div class="modal fade" id="myModal-cpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-cpass" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" name="form_change_pass" action="<?php echo base_url().'index.php/CPrincipal/changepass'; ?>" method="post" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3>Cambiar Contraseña</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="contrasenaActual">Contraseña Actual:</label>
                            <input type="password" class="form-control" id="passactual" name="passactual" placeholder="Digite su contraseña actual" required="">
                        </div>
                        <br />
                        <div class="form-group">
                            <label for="contrasenaNueva">Nueva Contraseña</label>
                            <br />
                            Nota: Minimo 1 letra mayúscula, 1 letra minúscula, al menos un número y la longitud debe ser minimo 8 caracteres. Ej: Safic1234
                            <br /><br />
                            <input type="password" class="form-control" id="passnew" name="passnew" placeholder="Digite la nueva contraseña" required="">
                        </div>
                        <div class="form-group">
                            <label for="contrasenaNuevaConfirma">Confirme la nueva Contraseña</label>
                            <input type="password" class="form-control" id="passnewconf" name="passnewconf" placeholder="Confirme la nueva contraseña" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/Modal - Cambiar Clave-->
    
    <!--Modal - Generar Backup-->
    <div class="modal fade" id="myModal-cback" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-cback" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" name="form_backup" action="<?php echo base_url().'index.php/CPrincipal/backup'; ?>" method="post" autocomplete="off">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h3>Generar Backup de Datos</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="contrasenaNuevaConfirma">Contraseña</label>
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="Digite su contraseña" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                        <button type="submit" class="btn btn-success">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/Modal - Generar Backup-->
    
    <!--Modal - Ayuda-->
    <div class="modal fade" id="myModal-help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-help" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>SAFIC</h3>v1.0.0 [29/10/2018]
                </div>
                <div class="modal-body">
                    Software de Administración y Facturacion Integral para Centros Educativos
                    <br /><br />
                    Autor:<br />
                    John Alexander Sanchez R. - Desarrollador<br />
                    Leidy J. Mendoza Yara - Tester & Documentador<br /><br />
                    Amadeus Soluciones [Cali-Colombia]<br />
                    jhonalexander90@gmail.com
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                </div>
            </div>
        </div>
    </div>
    <!--/Modal - Ayuda-->
    
</div>