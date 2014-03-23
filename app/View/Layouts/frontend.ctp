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
            'style',
            'flexigrid',
            'thickbox',
            'bootstrap',
            'bootstrap-responsive',
            'bootstrap-datepicker',
            'bootstrap-timepicker',
            'google-code-prettify/prettify',
            'menu',
            'common',
            'frontend',
            'table'
            ));

        for ($i = 0; $i < count($csss); $i++):
            echo $this->Html->css($csss[$i] . ".css");
        endfor;

        echo $this->Html->script(array(
            'jquery-1.7.2.min',
            'flexigrid',
            'common',
            'jquery.validate.min',
            'thickbox',
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
            'google-code-prettify/prettify',
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
    </head>
    <body>
        <input type="hidden" id="controller" value="<?php echo $controller; ?>" />
        <input type="hidden" id="default-sort" value="<?php echo $defaultSort; ?>" />

        <input type="hidden" id="default-width" value="<?php echo $defaultWidth; ?>" />
        <input type="hidden" id="default-height" value="<?php echo $defaultHeight; ?>" />
        <?php echo $this->element('header/menu'); ?>

        <div class="content">
            <div id="breadcrumbs">
                <?php echo $this->element('header/breadcrumbs'); ?>
            </div>
            <div class="main"  >
                <?php echo $this->fetch('content'); ?>
            </div>

        </div>
        <div id="footer">
            COPYRIGHT© VNDIAL CO.,LTD ALL RIGHTS RESERVED.
        </div>
    </body>
</html>
