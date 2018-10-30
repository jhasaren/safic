<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="<?php echo base_url().'index.php/CPrincipal'; ?>" class="site_title"><i class="fa fa-circle-o"></i> <span><?php echo $this->config->item('namebussines'); ?></span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
        <div class="profile_info">
            <span>Bienvenido,</span>
            <h2><?php echo $this->session->userdata('nombre_usuario'); ?></h2>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                <li>
                    <a href="<?php echo base_url().'index.php/CPrincipal'; ?>">
                        <i class="fa fa-home"></i> Inicio
                    </a>
                </li>
                <!--************************************************************************-->
                <?php if ($this->MRecurso->validaRecurso(1)){ /*Registro Estudiantil*/ ?>
                <li>
                    <a href="<?php echo base_url().'index.php/CEstudiante'; ?>">
                        <i class="fa fa-folder-open-o"></i> Registro Estudiantil
                    </a>
                </li>
                <?php } ?>
                <!--************************************************************************-->
                <?php if ($this->MRecurso->validaRecurso(2)){ /*Control de Facturacion*/ ?>
                <li>
                    <a href="<?php echo base_url().'index.php/CFacturacion'; ?>">
                        <i class="fa fa-money"></i> Control Facturación
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Copyright Amadeus Soluciones" href="#">
            <span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Version 1.0.0" href="#">
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Salir" href="<?php echo base_url().'index.php/CPrincipal/logout'; ?>">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>