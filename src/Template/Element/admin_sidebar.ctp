<?php
$paramController = $this->request->params['controller'];
$paramAction = $this->request->params['action'];
?>

<div id="sidebar" class="sidebar responsive">
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'fixed')
        } catch (e) {
        }
    </script>


    <div>
        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        <li class="<?php if ($paramController == 'Appadmins' && ($paramAction == 'index')) { ?> active <?php } ?>">
            <a href="<?php echo HTTP_ROOT . 'appadmins'; ?>">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>

            <b class="arrow"></b>
        </li>

        <?php if ($this->request->session()->read('Auth.User.type') == 1) { ?>
            <li class="<?php if ($paramController == 'Appadmins' && ($paramAction == 'userListing')) { ?> active <?php } ?>">
                <a class="dropdown-toggle" href="#">
                    <i class="menu-icon fa fa-user-md"></i>
                    <span class="menu-text"> Manage Users </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <ul class="submenu nav-hide" style="<?php if ($paramController == 'Appadmins' && $paramAction == 'userListing') { ?> display:block; <?php } ?>">
                    <li class="<?php if ($paramController == 'Appadmins' && $paramAction == 'userListing') { ?> active <?php } ?>">
                        <a href="<?php echo HTTP_ROOT; ?>appadmins/user_listing">
                            <i class="menu-icon fa fa-user"></i>
                            User Listing
                        </a>

                    </li>

                </ul>
            </li>
        <?php } ?>

        <li class="<?php if ($paramController == 'Appadmins' && ($paramAction == 'profileSetup' || $paramAction == 'changePassword')) { ?> active <?php } ?>">
            <a class="dropdown-toggle" href="#">
                <i class="menu-icon fa fa-pencil-square-o"></i>
                <span class="menu-text"> Manage Profile </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu nav-hide" style="<?php if ($paramController == 'Appadmins' && ($paramAction == 'profileSetup' || $paramAction == 'changePassword')) { ?> display:block; <?php } ?>">
                <li class="<?php if ($paramController == 'Appadmins' && $paramAction == 'profileSetup') { ?> active <?php } ?>">
                    <a href="<?php echo HTTP_ROOT; ?>appadmins/profile_setup">
                        <i class="menu-icon fa fa-pencil-square-o"></i>
                        <span class="menu-text"> Profile Setting </span>
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="<?php if ($paramController == 'Appadmins' && $paramAction == 'changePassword') { ?> active <?php } ?>">
                    <a href="<?php echo HTTP_ROOT; ?>appadmins/change_password">
                        <i class="menu-icon fa fa-lock"></i>
                        <span class="menu-text"> Change Password </span>
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>
        </li>

        <!--- Setting--->

        <?php if ($this->request->session()->read('Auth.User.type') == 1) { ?>   
            <li class="<?php if ($paramController == 'Appadmins' && ($paramAction == 'settinglist' || $paramAction == 'valuesetting')) { ?> active <?php } ?>">
                <a class="dropdown-toggle" href="#">
                    <i class="menu-icon fa fa-cog"></i>
                    <span class="menu-text"> System Setup </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>
                <ul class="submenu nav-hide" style="<?php if ($paramController == 'Appadmins' && ($paramAction == 'settinglist' || $paramAction == 'valuesetting')) { ?> display:block; <?php } ?>">
                    <li class="<?php if ($paramController == 'Appadmins' && $paramAction == 'settinglist') { ?> active <?php } ?>">
                        <a href="<?php echo HTTP_ROOT; ?>appadmins/settinglist">
                            <i class="menu-icon fa fa-envelope"></i>
                            <span class="menu-text"> Email Setting </span>
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li class="<?php if ($paramController == 'Appadmins' && $paramAction == 'valuesetting') { ?> active <?php } ?>">
                        <a href="<?php echo HTTP_ROOT; ?>appadmins/valuesetting">
                            <i class="menu-icon fa fa-pencil-square"></i>
                            <span class="menu-text"> Value Setting </span>
                        </a>
                        <b class="arrow"></b>
                    </li>

                </ul>
            </li>

        <?php } ?>



        <li class="" >
            <a style="color:#002a80;font-weight: bold;" href="<?php echo HTTP_ROOT; ?>users/logout">
                <i class="menu-icon fa fa-power-off"></i>
                <span class="menu-text">Logout</span>
            </a>           
        </li>
    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'collapsed')
        } catch (e) {
        }
    </script>
</div>

<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try {
                    ace.settings.check('breadcrumbs', 'fixed')
                } catch (e) {
                }
            </script>

            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="<?php echo HTTP_ROOT . 'appadmins'; ?>">Home</a>
                </li>
                <!--<li class="active">Dashboard</li>-->
            </ul><!-- /.breadcrumb -->

        </div>