<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Dashboard - SMA Admin</title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />       
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/style.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>font-awesome/4.2.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>fonts/fonts.googleapis.com.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
        <script src="<?php echo HTTP_ROOT; ?>js/ace-extra.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/jquery.2.1.1.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/validator.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/common.js"></script>

    </head>

    <body class="login-layout">

        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>   

        <script type="text/javascript">
            jQuery(function ($) {
                $(document).on('click', '.toolbar a[data-target]', function (e) {
                    e.preventDefault();
                    var target = $(this).data('target');
                    $('.widget-box.visible').removeClass('visible');//hide others
                    $(target).addClass('visible');//show target
                });
            });
        </script>


        <input type="hidden" id="pageurl" value="<?php echo HTTP_ROOT; ?>"/>
    </body>
</html>
