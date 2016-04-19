<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo BASE_URL ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title_for_layout ?></title>
        <link rel="shortcut icon" href="assets/images/logo.jpeg" />

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/animate.min.css" rel="stylesheet">
        

        <!-- Custom styling plus plugins -->
        <link href="assets/css/custom.css" rel="stylesheet">
        <link href="assets/css/icheck/flat/green.css" rel="stylesheet" />
        <link href="assets/css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">
        <!--<link href="assets/css/smart_home_custom.css" rel="stylesheet">-->
        <script src="assets/js/jquery.min.js"></script>
    </head>
    <body class="nav-md">
        <?php if($this->params['controller'] == 'auth' && $this->action == 'login'){ ?>
            <div class="container body login-body">
                <?php echo $this->fetch('content'); ?>
            </div>
        <?php }else{ ?>
            <div class="container body">
                <?php echo $this->element('menu_left'); ?>
                <?php echo $this->element('menu_top'); ?>
                <!-- page content -->
                <div class="right_col" style="height: 1300px !important">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>
                                    <span class="fa fa-university">Smart home</span>
                                </h3>
                                <?php echo $this->Flash->render(); ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <?php echo $this->fetch('content'); ?>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- /page content -->
            </div>
        <?php } ?>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/icheck/icheck.min.js"></script>
        <script src="assets/js/custom.js"></script>
        <script src="assets/js/datatables/js/jquery.dataTables.js"></script>
        <script src="assets/js/datatables/tools/js/dataTables.tableTools.js"></script>
    </body>
</html>
