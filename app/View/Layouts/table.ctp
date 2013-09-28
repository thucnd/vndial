<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array(
            'backend',
            'menu',
            'common',
            'style',
            'flexigrid',
            'bootstrap',
            'bootstrap-responsive'
        ));

        echo $this->Html->script(array(
            'jquery-1.7.2.min',
            'flexigrid',
            'common',
            'jquery.validate.min',
            'bootstrap-transition',
            'bootstrap-alert',
            'bootstrap-modal',
            'bootstrap-dropdown',
            'bootstrap-scrollspy',
            'bootstrap-tab',
            'bootstrap-tooltip',
            'bootstrap-popover',
            'bootstrap-button',
            'bootstrap-collapse',
            'bootstrap-carousel',
            'bootstrap-typeahead'
        ));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>


        <link rel="stylesheet" href="themes/font-awesome/css/font-awesome.min.css" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="themes/font-awesome/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!--page specific plugin styles-->

        <link rel="stylesheet" href="themes/css/prettify.css" />

        <!--fonts-->

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

        <!--ace styles-->

        <link rel="stylesheet" href="themes/css/w8.min.css" />
        <link rel="stylesheet" href="themes/css/w8-responsive.min.css" />
        <link rel="stylesheet" href="themes/css/w8-skins.min.css" />

        <script src="themes/js/jquery-ui-1.10.3.custom.min.js"></script>

        <script src="themes/js/jquery.ui.touch-punch.min.js"></script>

        <script src="themes/js/jquery.slimscroll.min.js"></script>
        <script src="themes/js/jquery.easy-pie-chart.min.js"></script>
        <script src="themes/js/jquery.sparkline.min.js"></script>

        <script src="themes/js/jquery.flot.min.js"></script>
        <script src="themes/js/jquery.flot.pie.min.js"></script>
        <script src="themes/js/jquery.flot.resize.min.js"></script>

        <script src="themes/js/w8-elements.min.js"></script>
        <script src="themes/js/w8.min.js"></script>

    </head>
</head>
<body>
    <?php echo $this->element('admin/r_top'); ?>

    <div class="container-fluid" id="main-container">
        <a id="menu-toggler" href="#">
            <span></span>
        </a>

        <div id="sidebar">
            <?php echo $this->element('admin/l_menu'); ?>
            <div id="sidebar-collapse">
                <i class="icon-double-angle-left"></i>
            </div>
        </div>

        <div id="main-content" class="clearfix">
            <div id="breadcrumbs">
                <?php echo $this->element('admin/breadcrumbs'); ?>
            </div>

            <div id="page-content" class="clearfix">
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </div>

    <a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
    <div id="footer">
        COPYRIGHT© VNDIAL CO.,LTD ALL RIGHTS RESERVED.
    </div>
</body>
</html>
