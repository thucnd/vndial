<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $pageTitle; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array(
            'bootstrap',
            'bootstrap-responsive',
            'bootstrap-datepicker',
            'bootstrap-timepicker',
            'google-code-prettify/prettify',
            'backend',
            'table'
        ));

        for ($i = 0; $i < count($csss); $i++):
            echo $this->Html->css($csss[$i] . ".css");
        endfor;

        echo $this->Html->script(array(
            'jquery-1.8.2.min',
            'common',
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
            'bootstrap-typeahead',
            'bootstrap-datepicker',
            'bootstrap-timepicker',
            'bootstrap-paginator',
            'bTable',
            'colResizable-1.3.min'
        ));

        for ($i = 0; $i < count($javascripts); $i++):
            echo $this->Html->script($javascripts[$i] . ".js");
        endfor;

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
        <link rel="stylesheet" href="/themes/css/w8.min.css" />
        <link rel="stylesheet" href="/themes/css/w8-skins.min.css" />
     
        <script src="/themes/js/w8-elements.min.js"></script>
        <script src="/themes/js/w8.min.js"></script>
      
    </head>
    <body>
        <input type="hidden" id="controller" value="<?php echo $controller; ?>" />
        <input type="hidden" id="default-sort" value="<?php echo $defaultSort; ?>" />

        <input type="hidden" id="default-width" value="<?php echo $defaultWidth; ?>" />
        <input type="hidden" id="default-height" value="<?php echo $defaultHeight; ?>" />
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
        
        <div style="display: block; padding-bottom: 20px;"></div>    
        <div id="footer">
            COPYRIGHT© VNDIAL CO.,LTD ALL RIGHTS RESERVED.
        </div>
    </body>
</html>
